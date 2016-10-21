<?php
/**
 * Description of retirerInnovateurAction
 *
 * @author William
 */
class retirerParticipant_mindefAction extends gridAction{

  public function execute($request) {

    if (! ($request->hasParameter('commission') && $request->hasParameter('participant'))){
      $this->redirect("@non_autorise");
    }

    $strId = $request->getParameter('commission');
    $strToken = $this->getUser()->getAttribute('session_participants_mindef_token');
    $strInnovateur = $request->getParameter('participant');
    //test coherance token
    if (strpos($strToken,"u".$this->getUser()->getUtilisateur()->getId()."c".$strId) === false){
      $this->getUser()->setFlash('warning', libelle('msg_dossier_mip_token_incoherant'));
      $this->redirect($this->getModuleName() . '/modifierParticipants_mindef?commission='.$strId);
    }
    //verification de l'existence de l'innovateur
    if (!UtilisateurTable::getInstance()->findOneById($strInnovateur)){
      $this->redirect('@non_autorise');
    }
    //creation objet session_participant_mindef_commission
    $objSessionParticipant = Session_participant_mindef_commissionTable::getInstance()->getSessionByParticipantIdAndToken($strInnovateur,$strToken);
    $objSessionParticipant = $objSessionParticipant == false ? new Session_innovateur_dossier_mip() : $objSessionParticipant[0];
    $objSessionParticipant->setTransactionToken($strToken);
    $objSessionParticipant->setParticipantId($strInnovateur);
    $objSessionParticipant->setEstConcerne(false);

    //sauvegarde objet session_participant_mindef_commission
    $objSessionParticipant->save();

    //redirection
    $this->redirect($this->getModuleName() . '/modifierParticipants_mindef?commission='.$strId);
  }
}
?>
