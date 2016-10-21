<?php

/**
 * Description of lierDossiers_mipAction
 *
 * @author William
 */
class lierDossiers_mipAction extends gridAction{

  public function preExecute(){
    if (!$this->getRequest()->hasParameter('dossier_bpi')){
      $this->redirect("@non_autorise");
    }
  }

  private $strSessionTokenCle = "session_liaison_dossiers_token";

  public function execute($request) {

    $this->strId = $request->getParameter('dossier_bpi');
    if (!$this->objDossier  = Dossier_bpiTable::getInstance()->findOneById($this->strId)){
      $this->redirect("@non_autorise");
    }

    $srvToken = new ServiceToken();

    //Récupération ou création session_liaison_dossiers_token en session
    if ($srvToken->hasToken($this->strSessionTokenCle) && $this->getUser()->getFlash('warning', '') == '' && $request->getParameter('start') != 'true') {
      $this->transactionToken = $srvToken->getToken($this->strSessionTokenCle);
      //cas POST 'Enregistrer les modifications'
      if ($request->isMethod('post')){
        if ($request->hasParameter('retrait')){
          $this->deplacerDossiers(false);
        } elseif ($request->hasParameter('ajout')){
          $this->deplacerDossiers(true);
        }
        else{
          $this->enregistrerModifications();
        }
      }
      //cas GET ou POST pagination
    } else {
      //nettoyer base pour ancien token
      $strAncienToken = $srvToken->getToken($this->strSessionTokenCle);
      if ($strAncienToken != '') {
        Session_liaison_dossiers_bpi_mipTable::getInstance()->nettoyerAncienneSession($strAncienToken);
      }
      //création nouveau token
      $this->transactionToken = $srvToken->creerToken($this->strSessionTokenCle, "d".$this->strId);
      if ($request->getParameter('start') == 'true') {
        $this->reload();
      }
    }



    //Génération requête liste innovateurs disponibles
    $objRequeteDoctrineDisponibles = Dossier_mipTable::getInstance()->retrieveDossierMIPDisponibles($this->transactionToken, $this->strId);
    //Génération requête innovateurs concernés
    $objRequeteDoctrineConcernes = Dossier_mipTable::getInstance()->retrieveDossierMIPConcernes($this->transactionToken, $this->strId);


    //Affectation liste innovateurs concernés
    $this->arrDossiersConcernes = $objRequeteDoctrineConcernes->execute();
    $this->arrDossiersDisponibles = $objRequeteDoctrineDisponibles->execute();
  }

  /**
   * Enregistre les modifications en session de manière effective dans le referentiel
   */
  public function enregistrerModifications() {
    $logger = $this->getLogger();
    $logger->debug("{lierDossiers_mipAction} enregistrerModifications DEBUT; session_liaison_dossiers_token = " . $this->transactionToken);


    //parcours des enregistrement support puis enregistrement (en une transaction)
    try {
      Dossier_mip_dossier_bpiTable::getInstance()->enregistrerModificationSession($this->transactionToken, $this->strId, $this->getUser()->getUtilisateur());
    } catch (Exception $ex) {
      $logger->debug("{lierDossiers_mipAction} enregistrerModifications ECHEC; session_liaison_dossiers_token = " . $this->transactionToken . " Erreur :" . $ex->getMessage());
      $this->getUser()->setFlash('erreur', libelle('msg_liaison_dossiers_enregistrer_erreur', array($ex->getMessage())));
      $this->reload();
    }

    //redirection (start = true si réussite)
    $logger->debug("{lierDossiers_mipAction} enregistrerModifications FIN; session_liaison_dossiers_token = " . $this->transactionToken);
    $this->getUser()->setFlash('succes', libelle('msg_liaison_dossiers_enregistrer_succes'));
    $this->reload();
  }

  public function deplacerDossiers($boolAjouter){
    $parametreUtilise = $boolAjouter ? 'disponible' : 'concerne';
    foreach($this->getRequestParameter($parametreUtilise) as $intIdDossierDeplace){
      $objSessionLiaison = Session_liaison_dossiers_bpi_mipTable::getInstance()->getSessionByDossierMIPIdAndToken($intIdDossierDeplace,$this->transactionToken);
      $objSessionLiaison = $objSessionLiaison == false ? new Session_liaison_dossiers_bpi_mip() : $objSessionLiaison[0];
      $objSessionLiaison->setDossierMipId($intIdDossierDeplace);
      $objSessionLiaison->setTransactionToken($this->transactionToken);
      $objSessionLiaison->setEstConcerne($boolAjouter);
      $objSessionLiaison->save();
    }
    $this->reload();
  }

  public function reload(){
    $this->redirect('dossier_bpi/lierDossiers_mip?dossier_bpi=' . $this->getRequestParameter('dossier_bpi'));
  }

}
?>
