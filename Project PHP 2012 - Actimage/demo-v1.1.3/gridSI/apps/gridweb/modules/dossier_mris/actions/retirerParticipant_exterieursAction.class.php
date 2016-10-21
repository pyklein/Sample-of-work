<?php
/**
 * Description of retirerParticipant_exterieurs
 *
 * @author Jihad
 */
class retirerParticipant_exterieursAction extends gridAction{

  public function execute($request) {

    if (! ($request->hasParameter('commission') && $request->hasParameter('participant'))){
      $this->redirect("@non_autorise");
    }

    $strId = $request->getParameter('commission');
    $strToken = $this->getUser()->getAttribute('session_participants_exterieurs_token');
    $strInnovateur = $request->getParameter('participant');
    //test coherance token
    if (strpos($strToken,"u".$this->getUser()->getUtilisateur()->getId()."c".$strId) === false){
      $this->getUser()->setFlash('warning', libelle('msg_dossier_mip_token_incoherant'));
      $this->redirect($this->getModuleName() . '/modifierParticipants_exterieurs?commission='.$strId);
    }
    //verification de l'existence de l'innovateur
    if (!IntervenantTable::getInstance()->findOneById($strInnovateur)){
      $this->redirect('@non_autorise');
    }
    //creation objet session_participant_mindef_commission
    $objSessionParticipant = Session_participant_exterieurs_commissionTable::getInstance()->getSessionByParticipantIdAndToken($strInnovateur,$strToken);
    $objSessionParticipant = $objSessionParticipant == false ? new Session_participant_exterieurs_commission() : $objSessionParticipant[0];
    $objSessionParticipant->setTransactionToken($strToken);
    $objSessionParticipant->setIntervenantId($strInnovateur);
    $objSessionParticipant->setEstConcerne(false);

    //sauvegarde objet session_participant_mindef_commission
    $objSessionParticipant->save();

    //redirection
    $this->redirect($this->getModuleName() . '/modifierParticipants_exterieurs?commission='.$strId);
  }
}
?>
