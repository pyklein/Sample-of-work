<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ajouterParticipant_exterieursAction
 *
 * @author Jihad
 */
class ajouterParticipant_exterieursAction extends gridAction {

  public function execute($request) {

    if (!($request->hasParameter('commission') && $request->hasParameter('participant'))) {
      $this->redirect("@non_autorise");
    }

    $strId = $request->getParameter('commission');
    $strToken = $this->getUser()->getAttribute('session_participants_exterieurs_token');
    $strParticipantId = $request->getParameter('participant');
    //test coherance token
    if (strpos($strToken, "u" . $this->getUser()->getUtilisateur()->getId() . "c" . $strId) === false) {
      $this->getUser()->setFlash('warning', libelle('msg_commission_token_incoherant'));
      $this->redirect($this->getModuleName() . '/modifierParticipants_exterieurs?commission=' . $strId);
    }
    //verification de l'existence de l'innovateur
    if (!IntervenantTable::getInstance()->findOneById($strParticipantId)) {
      $this->redirect('@non_autorise');
    }
    //creation objet session_innovateur_commission
    $objSessionParticipant = Session_participant_exterieurs_commissionTable::getInstance()->getSessionByParticipantIdAndToken($strInnovateur, $strToken);
    $objSessionParticipant = $objSessionParticipant == false ? new Session_participant_exterieurs_commission() : $objSessionParticipant[0];
    $objSessionParticipant->setTransactionToken($strToken);
    $objSessionParticipant->setIntervenantId($strParticipantId);
    $objSessionParticipant->setEstConcerne(true);

    //sauvegarde objet session_innovateur_commission
    $objSessionParticipant->save();

    //redirection
    $this->redirect($this->getModuleName() . '/modifierParticipants_exterieurs?commission=' . $strId);
  }

}

?>
