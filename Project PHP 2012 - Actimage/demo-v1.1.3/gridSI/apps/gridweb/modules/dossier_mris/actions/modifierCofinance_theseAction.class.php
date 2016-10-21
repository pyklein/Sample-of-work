<?php

/**
 * Description of modifierCofinance_theseAction
 *
 * @author William
 */
class modifierCofinance_theseAction extends gridAction{

  private $strSessionTokenCle = "session_cofinance_mris_token";

  public function preExecute(){
    if (!$this->getRequest()->hasParameter('dossier_these')){
      $this->getUser()->setFlash('warning', libelle('msg_credentials_acces_non_autorise'));
      $this->redirect('dossier_mris/listerDossier_these');
    }
  }

  public function execute($request) {
    $this->logger = $this->getLogger();
    $this->strId = $request->getParameter('dossier_these');
    if (!$this->objDossierBpi = Dossier_theseTable::getInstance()->findOneById($this->strId)) {
      $this->redirect("@non_autorise");
    }
    $srvToken = new ServiceToken();

    //Récupération ou création session_cofinance_mris_token en session
    if ($srvToken->hasToken($this->strSessionTokenCle) && $this->getUser()->getFlash('erreur', '') == '' && $request->getParameter('start') != 'true') {
      $this->transactionToken = $srvToken->getToken($this->strSessionTokenCle);
      //cas POST 'Enregistrer les modifications'
      if ($request->isMethod('post') && (!$request->hasParameter('percent') &&
              !$request->hasParameter('resultats0') && $request->hasParameter('enregistrer_modifications'))) {

        if ($this->getUser()->getAttributeAction('pourcentage_restant') >= 0) {
          $this->enregistrerModifications();
        } else {
          ////cas tentative d'enregistrement plus 100% de part de cofinancement
          $this->getUser()->setFlash('warning', libelle('msg_cofinance_pourcentage_excessif'));
          $this->reload();
        }
      } else if ($request->hasParameter('percent')) {//cas ajout d'un organisme
        if ($request->getParameter('percent') > $this->getUser()->getAttributeAction('pourcentage_restant')) {
          ////cas d'ajout de part inventive trop importante
          $this->getUser()->setFlash('warning', libelle('msg_organisme_pourcentage_depasse'));
          $this->reload();
        }
        $intOrganismeId = 0;
        foreach ($request->getParameterHolder()->getAll() as $key => $value) {
          if ($value == 'Ajouter') {
            //récupération de l'ID de l'organisme ajouté
            $intOrganismeId = explode('_', $key);
            $intOrganismeId = $intOrganismeId[1];
          }
        }
        $this->ajouterOrganisme($intOrganismeId, $this->getRequestParameter('percent'));
      }
      //cas GET ou POST pagination
    } else {
      //nettoyer base pour ancien token
      $strAncienToken = $srvToken->getToken($this->strSessionTokenCle);
      if ($strAncienToken != '') {
        Session_cofinance_theseTable::getInstance()->nettoyerAncienneSession($strAncienToken);
      }
      //création nouveau token
      $this->transactionToken = $srvToken->creerToken($this->strSessionTokenCle, "d" . $this->strId);
      if ($request->getParameter('start') == 'true') {
        $this->reload();
      }
    }

    $this->intPourcentageRestant = 100;


    //Génération requête liste organismes disponibles
    $objRequeteDoctrineDisponible = OrganismeTable::getInstance()->retrieveCofinanceursDisponibles($this->transactionToken, $this->strId);
    //Génération requête organismes concernés
    $objRequeteDoctrineConcernes = OrganismeTable::getInstance()->retrieveCofinanceursConcernes($this->transactionToken, $this->strId);

    //Initialisation pager liste du haut
    $this->processPager($objRequeteDoctrineDisponible, 'Organisme');


    //Affectation liste organismes concernés
    $this->arrOrganismeConcernes = $objRequeteDoctrineConcernes->execute();

    //calcul de la part inventive disponible
    foreach ($this->arrOrganismeConcernes as $objOrganisme) {
      $this->intPourcentageRestant -= $objOrganisme->getPartCofinanceSession($this->strId, $this->transactionToken);
    }
    $this->getUser()->setAttributeAction('pourcentage_restant', $this->intPourcentageRestant);


  }

  /**
   * Enregistre les modifications en session de manière effective dans le referentiel
   */
  public function enregistrerModifications() {
    $logger = $this->getLogger();
    $logger->debug("{modifierCofinance_theseAction} enregistrerModifications DEBUT; session_cofinance_mris_token = " . $this->transactionToken);

    //parcours des enregistrement support puis enregistrement (en une transaction)
    try {
      Cofinance_theseTable::getInstance()->enregistrerModificationSession($this->transactionToken, $this->strId, $this->getUser()->getUtilisateur());
    } catch (Exception $ex) {
      $logger->debug("{modifierCofinance_theseAction} enregistrerModifications ECHEC; session_cofinance_mris_token = " . $this->transactionToken . " Erreur :" . $ex->getMessage());
      $this->getUser()->setFlash('erreur', libelle('msg_cofinance_enregistrer_erreur', array($ex->getMessage())));
      $this->reload();
    }

    //redirection (start = true si réussite)
    $logger->debug("{modifierCofinance_theseAction} enregistrerModifications FIN; session_cofinance_mris_token = " . $this->transactionToken);
    $this->getUser()->setFlash('succes', libelle('msg_cofinance_enregistrer_succes'));
    $this->reload();
  }

  /**
   *  Fonction ajoutant un organisme dans la liste du bas
   * @param Integer $intOrganismeId   Identifiant de l'organisme à ajouter
   */
  protected function ajouterOrganisme($intOrganismeId, $intPartCofinance) {

    //verification de l'existence de l'organisme
    if (!OrganismeTable::getInstance()->findOneById($intOrganismeId)) {
      $this->redirect('@non_autorise');
    }
    //creation objet Session_situation_organismes
    $objSessionCofinance = Session_cofinance_theseTable::getInstance()->getSessionByOrganismeIdAndToken($intOrganismeId, $this->transactionToken);
    $objSessionCofinance = $objSessionCofinance == false ? new Session_cofinance_these() : $objSessionCofinance[0];
    $objSessionCofinance->setTransactionToken($this->transactionToken);
    $objSessionCofinance->setOrganismeId($intOrganismeId);
    $validator = new sfValidatorInteger(array('min' => 0));
    try { //validation du pourcentage
      $validator->clean($intPartCofinance);
      $objSessionCofinance->setPartCofinance($intPartCofinance);
      $objSessionCofinance->save();
    } catch (Exception $ex) {
      $this->getUser()->setFlash('warning', libelle('msg_organisme_pourcentage_invalide'));
    }
    $this->reload();
  }

  /**
   * recharge la page
   */
  protected function reload() {
    $this->redirect($this->getModuleName() . '/modifierCofinance_these?dossier_these=' . $this->getRequest()->getParameter('dossier_these'));
  }

}
?>
