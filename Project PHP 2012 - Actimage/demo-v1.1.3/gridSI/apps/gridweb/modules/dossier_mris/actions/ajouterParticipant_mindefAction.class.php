<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ajouterParticipant_mindefAction
 *
 * @author William
 */
class ajouterParticipant_mindefAction extends gridAction {

  public function execute($request) {

    if (!($request->hasParameter('commission') && $request->hasParameter('participant'))) {
      $this->redirect("@non_autorise");
    }

    $strId = $request->getParameter('commission');
    $strToken = $this->getUser()->getAttribute('session_participants_mindef_token');
    $strParticipantId = $request->getParameter('participant');
    //test coherance token
    if (strpos($strToken, "u" . $this->getUser()->getUtilisateur()->getId() . "c" . $strId) === false) {
      $this->getUser()->setFlash('warning', libelle('msg_commission_token_incoherant'));
      $this->redirect($this->getModuleName() . '/modifierParticipants_mindef?commission=' . $strId);
    }
    //verification de l'existence de l'innovateur
    if (!UtilisateurTable::getInstance()->findOneById($strParticipantId)) {
      $this->redirect('@non_autorise');
    }
    //creation objet session_innovateur_commission
    $objSessionParticipant = Session_participant_mindef_commissionTable::getInstance()->getSessionByParticipantIdAndToken($strInnovateur, $strToken);
    $objSessionParticipant = $objSessionParticipant == false ? new Session_participant_mindef_commission() : $objSessionParticipant[0];
    $objSessionParticipant->setTransactionToken($strToken);
    $objSessionParticipant->setParticipantId($strParticipantId);
    $objSessionParticipant->setEstConcerne(true);

    //sauvegarde objet session_innovateur_commission
    $objSessionParticipant->save();

    //redirection
    $this->redirect($this->getModuleName() . '/modifierParticipants_mindef?commission=' . $strId);
  }

}

?>
