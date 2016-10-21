<?php

/**
 * Description of modifierSituation_inventeursAction
 *
 * @author William
 */
class modifierSituation_inventeursAction extends gridAction {

  private $strSessionTokenCle = "session_situation_inventeurs_token";

  public function preExecute() {
    if (!$this->getRequest()->hasParameter('dossier_bpi')) {
      $this->redirect("@non_autorise");
    }
  }

  public function execute($request) {
    $this->logger = $this->getLogger();
    $this->strId = $request->getParameter('dossier_bpi');
    if (!$this->objDossierBpi = Dossier_bpiTable::getInstance()->findOneById($this->strId)) {
      $this->redirect("@non_autorise");
    }
    $srvToken = new ServiceToken();

    //Récupération ou création session_situation_inventeurs_token en session
    if ($srvToken->hasToken($this->strSessionTokenCle) && $this->getUser()->getFlash('erreur', '') == '' && $request->getParameter('start') != 'true') {
      $this->transactionToken = $srvToken->getToken($this->strSessionTokenCle);
      
      if($request->isMethod('post') && $request->hasParameter('modifier_modifications')){
        $intInventeurId = 0;
        foreach ($request->getParameterHolder()->getAll() as $key => $value) {
          if (strncmp($key, "percent_", 7) == 0){
            $intInventeurId = explode('_', $key);
            $intInventeurId = $intInventeurId[1];
            $objInventeur = InventeurTable::getInstance()->findOneById($intInventeurId);
            $nbPartCourante = $objInventeur->getPartInventiveSession($this->strId, $this->transactionToken);
            $nbTextField = intval($request->getParameter('percent_'.$intInventeurId));
            $nbPartRestante = intval($this->getUser()->getAttributeAction('pourcentage_restant'));
            if ($nbTextField - $nbPartCourante > $nbPartRestante){
                ////cas d'ajout de part inventive trop importante
                $this->getUser()->setFlash('warning', libelle('msg_inventeur_pourcentage_depasse'));
                $this->reload();
              }
            $this->actionInventeur($intInventeurId, $this->getRequestParameter('percent_'.$intInventeurId), 1);
          }
         }
      }
      //cas POST 'Enregistrer les modifications'
      else if ($request->isMethod('post') && (!$request->hasParameter('percent') &&
              !$request->hasParameter('resultats0') && $request->hasParameter('enregistrer_modifications'))) {

        if ($this->getUser()->getAttributeAction('pourcentage_restant') == 0) {
          $this->enregistrerModifications();
        } else {
          ////cas tentative d'enregistrement avec autre chose que 100% de part inventive
          $this->getUser()->setFlash('warning', libelle('msg_inventeur_pourcentage_insuffisant'));
          $this->reload();
        }
      }
       else if ($request->hasParameter('percent')) {//cas ajout d'un inventeur
        if ($request->getParameter('percent') > $this->getUser()->getAttributeAction('pourcentage_restant')) {
          ////cas d'ajout de part inventive trop importante
          $this->getUser()->setFlash('warning', libelle('msg_inventeur_pourcentage_depasse'));
          $this->reload();
        }
        $intInventeurId = 0;
        foreach ($request->getParameterHolder()->getAll() as $key => $value) {
          if ($value == 'Ajouter') {
            //récupération de l'ID de l'inventeur ajouté
            $intInventeurId = explode('_', $key);
            $intInventeurId = $intInventeurId[1];
          }
        }
        $this->actionInventeur($intInventeurId, $this->getRequestParameter('percent'), 0);
      } else if ($intPart = $this->getUser()->getAttribute('partInventivePopup', false)) { //cas Retour depuis popup
        $this->actionInventeur($this->getUser()->getAttribute('FormulaireInventeur')->getId(), $intPart, 0);
      }
      //cas GET ou POST pagination
    } else {
      //nettoyer base pour ancien token
      $strAncienToken = $srvToken->getToken($this->strSessionTokenCle);
      if ($strAncienToken != '') {
        Session_situation_inventeursTable::getInstance()->nettoyerAncienneSession($strAncienToken);
      }
      //création nouveau token
      $this->transactionToken = $srvToken->creerToken($this->strSessionTokenCle, "d" . $this->strId);
      if ($request->getParameter('start') == 'true') {
        $this->reload();
      }
    }

    $this->intPourcentageRestant = 100;


    //Génération requête liste inventeurs disponibles
    $objRequeteDoctrineDisponible = InventeurTable::getInstance()->retrieveInventeursDisponibles($this->transactionToken, $this->strId);
    //Génération requête inventeurs concernés
    $objRequeteDoctrineConcernes = InventeurTable::getInstance()->retrieveInventeursConcernes($this->transactionToken, $this->strId);

    //Initialisation pager liste du haut
    $this->processPager($objRequeteDoctrineDisponible, 'Inventeur');


    //Affectation liste inventeurs concernés
    $this->arrInventeursConcernes = $objRequeteDoctrineConcernes->execute();

    //calcul de la part inventive disponible
    foreach ($this->arrInventeursConcernes as $objInventeur) {
      $this->intPourcentageRestant -= $objInventeur->getPartInventiveSession($this->strId, $this->transactionToken);
    }
    $this->getUser()->setAttributeAction('pourcentage_restant', $this->intPourcentageRestant);


//    Partie ajout d'un inventeur à chaud
    $objForm = new InventeurPreCreerForm();

    if ($request->isMethod('post') && $request->hasParameter('enregistrer_inventeur') && $request->hasParameter('percent_popup')) {
      // on bind le formulaire
      $objForm->bind($request->getParameter($objForm->getName()));

      if ($objForm->isValid()) {
        $validator = new sfValidatorInteger(array('min' => 0, 'max' => $this->intPourcentageRestant));
        try {
          $validator->clean($request->getParameter('percent_popup'));
          // on sauvegarde les informations dans le session
          $this->getUser()->setAttribute("preFormulaireInventeur", $request->getParameter($objForm->getName()));
          $this->getUser()->setAttribute("partInventivePopup", $request->getParameter('percent_popup'));

          // redirection
          $this->redirect("referentiel_bpi/creerInventeurPopup?dossier_bpi=" . $this->strId);
        } catch (Exception $ex) {
          $this->getUser()->setFlash('warning', libelle('msg_inventeur_pourcentage_invalide'));
        }
      }
    }
    else {
      $this->getUser()->setAttribute("preFormulaireInventeur", null);
      $this->getUser()->setAttribute("partInventivePopup", null);
    }
    $this->objForm = $objForm;
  }

  /**
   * Enregistre les modifications en session de manière effective dans le referentiel
   */
  public function enregistrerModifications() {
    $logger = $this->getLogger();
    $logger->debug("{modifierSituation_inventeursAction} enregistrerModifications DEBUT; session_situation_inventeurs_token = " . $this->transactionToken);

    //parcours des enregistrement support puis enregistrement (en une transaction)
    try {
      Part_inventiveTable::getInstance()->enregistrerModificationSession($this->transactionToken, $this->strId, $this->getUser()->getUtilisateur());
    } catch (Exception $ex) {
      $logger->debug("{modifierSituation_inventeursAction} enregistrerModifications ECHEC; session_situation_inventeurs_token = " . $this->transactionToken . " Erreur :" . $ex->getMessage());
      $this->getUser()->setFlash('erreur', libelle('msg_innovateurs_enregistrer_erreur', array($ex->getMessage())));
      $this->reload();
    }

    //redirection (start = true si réussite)
    $logger->debug("{modifierSituation_inventeursAction} enregistrerModifications FIN; session_situation_inventeurs_token = " . $this->transactionToken);
    $this->getUser()->setFlash('succes', libelle('msg_innovateurs_enregistrer_succes'));
    $this->redirect('dossier_bpi/modifierSituation_inventeurs?dossier_bpi=' . $this->getRequestParameter('dossier_bpi'));
  }

  /**
   *  Fonction ajoutant un inventeur dans la liste du bas ou modifie le pourcentage de part inventive
   * d'un inventeur déjà present dans la liste.
   * @param Integer $intInventeurId   Identifiant de l'inventeur à ajouter
   * @param Integer $amodif 0 si c'est un ajout, 1 si c'est une modification
   */
  protected function actionInventeur($intInventeurId, $intPartInventive, $amodif) {

    //verification de l'existence de l'inventeur
    if (!InventeurTable::getInstance()->findOneById($intInventeurId)) {
      $this->redirect('@non_autorise');
    }
    //creation objet Session_situation_inventeurs
    $objSessionInventeur = Session_situation_inventeursTable::getInstance()->getSessionByInventeurIdAndToken($intInventeurId, $this->transactionToken);
    $objSessionInventeur = $objSessionInventeur == false ? new Session_situation_inventeurs() : $objSessionInventeur[0];
    $objSessionInventeur->setTransactionToken($this->transactionToken);
    $objSessionInventeur->setInventeurId($intInventeurId);
    $validator = new sfValidatorInteger(array('min' => 0));
    try { //validation du pourcentage
      $validator->clean($intPartInventive);
      $objSessionInventeur->setPartInventive($intPartInventive);
      $objSessionInventeur->save();
    } catch (Exception $ex) {
      $this->getUser()->setFlash('warning', libelle('msg_inventeur_pourcentage_invalide'));
    }
    // on vide la session des données liées au popup
    $this->getUser()->offsetUnset('percent_popup');
    $this->getUser()->offsetUnset('partInventivePopup');
    if ($amodif == 0)
      $this->reload();
  }
  
  /**
   * recharge la page
   */
  protected function reload() {
    $this->redirect($this->getModuleName() . '/modifierSituation_inventeurs?dossier_bpi=' . $this->getRequest()->getParameter('dossier_bpi'));
  }

}

?>
