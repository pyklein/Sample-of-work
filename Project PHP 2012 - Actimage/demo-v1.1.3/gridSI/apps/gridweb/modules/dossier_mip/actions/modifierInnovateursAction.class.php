<?php

/**
 * Description of modifierInnovateursAction
 *
 * @author William
 */
class modifierInnovateursAction extends gridAction {

  private $strSessionTokenCle = "session_innovateurs_token";

  public function execute($request) {

    $boolAjout = false;

    $this->strId = $request->getParameter('dossier_mip');
    if (!$this->objDossier  = Dossier_mipTable::getInstance()->findOneById($this->strId)){
      $this->redirect("@non_autorise");
    }

    $srvToken = new ServiceToken();

    //Récupération ou création session_innovateurs_token en session
    if ($srvToken->hasToken($this->strSessionTokenCle) && $this->getUser()->getFlash('warning', '') == '' && $request->getParameter('start') != 'true') {
      $this->transactionToken = $srvToken->getToken($this->strSessionTokenCle);
      //cas POST 'Enregistrer les modifications'
      if ($request->isMethod('post') && $request->hasParameter('save')) {
        $this->enregistrerModifications();
      } elseif ($request->isMethod('post') && $request->hasParameter('add')) {
        $boolAjout = true;
      }
      //cas GET ou POST pagination
    } else  {
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



    //Génération requête liste innovateurs disponibles
    $objRequeteDoctrineDisponible = UtilisateurTable::getInstance()->retrieveInnovateursMIPDisponibles($this->transactionToken, $this->strId);
    $objSession = new Session_innovateur_dossier_mip();
    $objSession->setTransactionToken($this->transactionToken);
    $this->objForm = new Session_innovateur_dossier_mipForm($objSession, array(), null, $objRequeteDoctrineDisponible);

    if ($request->isMethod('post') && $boolAjout){
      $this->processForm('ajout',null,false,false);
    }

    //Génération requête innovateurs concernés
    $objRequeteDoctrineConcernes = UtilisateurTable::getInstance()->retrieveInnovateursMIPConcernes($this->transactionToken, $this->strId);

    //Initialisation pager
    $this->processPager($objRequeteDoctrineDisponible, 'Utilisateur');
    

    //Affectation liste innovateurs concernés
    $this->arrInnovateursConcernes = $objRequeteDoctrineConcernes->execute();
  }

  /**
   * Enregistre les modifications en session de manière effective dans le referentiel
   */
  public function enregistrerModifications() {
    $logger = $this->getLogger();
    $logger->debug("{modifierInnovateursAction} enregistrerModifications DEBUT; session_innovateurs_token = " . $this->transactionToken);

    //parcours des enregistrement support puis enregistrement (en une transaction)
    try {
      Innovateur_dossier_mipTable::getInstance()->enregistrerModificationSession($this->transactionToken, $this->strId, $this->getUser()->getUtilisateur());
    } catch (Exception $ex) {
      $logger->debug("{modifierInnovateursAction} enregistrerModifications ECHEC; session_innovateurs_token = " . $this->transactionToken . " Erreur :" . $ex->getMessage());
      $this->getUser()->setFlash('erreur', libelle('msg_innovateurs_enregistrer_erreur', array($ex->getMessage())));
      $this->reload();
    }

    //redirection (start = true si réussite)
    $logger->debug("{modifierInnovateursAction} enregistrerModifications FIN; session_innovateurs_token = " . $this->transactionToken);
    $this->getUser()->setFlash('succes', libelle('msg_innovateurs_enregistrer_succes'));
    $this->reload();
  }
    protected function reload() {
    $this->redirect($this->getModuleName() . '/modifierInnovateurs?dossier_mip=' . $this->getRequestParameter('dossier_mip'));
  }
}

?>
