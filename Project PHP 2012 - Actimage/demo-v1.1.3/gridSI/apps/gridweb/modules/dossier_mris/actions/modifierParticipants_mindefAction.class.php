<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of modifierParticipants_mindefAction
 *
 * @author William
 */
class modifierParticipants_mindefAction extends gridAction {

  public function execute($request) {

    $this->strId = $request->getParameter('commission');
    if (!CommissionTable::getInstance()->findOneById($this->strId)){
      $this->redirect("@non_autorise");
    }
    //Récupération ou création session_participants_mindef_token en session
    if ($this->getUser()->hasAttribute('session_participants_mindef_token') && $this->getUser()->getFlash('warning', '') == '' && $request->getParameter('start') != 'true') {
      $this->transactionToken = $this->getUser()->getAttribute('session_participants_mindef_token');
      //cas POST 'Enregistrer les modifications'
      if ($request->isMethod('post') && !(($request->hasParameter('resultats1') || ($request->hasParameter('resultats2'))))) {
        $this->enregistrerModifications();
      }
      //cas GET ou POST pagination
    } else {
      //nettoyer base pour ancien token
      $strAncienToken = $this->getUser()->getAttribute('session_participants_mindef_token', '');
      if ($strAncienToken != '') {
        Session_participant_mindef_commissionTable::getInstance()->nettoyerAncienneSession($strAncienToken);
      }
      //création nouveau token
      $this->transactionToken = "u" . $this->getUser()->getUtilisateur()->getId() . "c" . $this->strId . "r" . rand(1000, 9999);
      $this->getUser()->setAttribute('session_participants_mindef_token', $this->transactionToken);
      if ($request->getParameter('start') == 'true') {
        $this->redirect($this->getModuleName().'/modifierParticipants_mindef?commission=' . $request->getParameter('commission'));
      }
    }
 


    //Génération requête liste innovateurs disponibles
    $objRequeteDoctrineDisponible = UtilisateurTable::getInstance()->retrieveParticipantsCommissionDisponibles($this->transactionToken, $this->strId);
    //Génération requête innovateurs concernés
    $objRequeteDoctrineConcernes = UtilisateurTable::getInstance()->retrieveParticipantsCommissionConcernes($this->transactionToken, $this->strId);

    //Initialisation pager
    $this->objPager1 = $this->processPager($objRequeteDoctrineDisponible, 'Utilisateur',true,1);
    $this->objPager2 = $this->processPager($objRequeteDoctrineConcernes, 'Utilisateur',true,2);


  }

  /**
   * Enregistre les modifications en session de manière effective dans le referentiel
   */
  public function enregistrerModifications() {
    $logger = $this->getLogger();
    $logger->debug("{modifierParticipants_mindefAction} enregistrerModifications DEBUT; session_participants_mindef_token = " . $this->transactionToken);


    //parcours des enregistrement support puis enregistrement (en une transaction)
    try {
      Commission_utilisateurTable::getInstance()->enregistrerModificationSession($this->transactionToken, $this->strId, $this->getUser()->getUtilisateur());
    } catch (Exception $ex) {
      $logger->debug("{modifierParticipants_mindefAction} enregistrerModifications ECHEC; session_participants_mindef_token = " . $this->transactionToken . " Erreur :" . $ex->getMessage());
      $this->getUser()->setFlash('erreur', libelle('msg_participants_mindef_enregistrer_erreur', array($ex->getMessage())));
      $this->redirect('dossier_mris/modifierParticipants_mindef?commission=' . $this->getRequestParameter('commission'));
    }

    //redirection (start = true si réussite)
    $logger->debug("{modifierParticipants_mindefAction} enregistrerModifications FIN; session_participants_mindef_token = " . $this->transactionToken);
    $this->getUser()->setFlash('succes', libelle('msg_participants_mindef_enregistrer_succes'));
    $this->redirect('dossier_mris/modifierParticipants_mindef?commission=' . $this->getRequestParameter('commission'));
  }

}

?>
