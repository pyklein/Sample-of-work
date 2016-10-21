<?php

/**
 * Description of ajouterInvitationLaboratoireAction
 * @author Gabor JAGER
 */
class ajouterInvitationLaboratoireAction extends gridAction
{
  private $strNomToken = "session_invitations_token";

  public function execute($request)
  {

    if (!($request->hasParameter('commission') 
            && $request->hasParameter('laboratoire')))
    {
      $this->redirect("@non_autorise");
    }

    $strId = $request->getParameter('commission');
    $strToken = $this->getUser()->getAttribute($this->strNomToken);
    $strLaboratoireId = $request->getParameter('laboratoire');

    // test coherance token
    if (strpos($strToken, "u".$this->getUser()->getUtilisateur()->getId()."c".$strId) === false)
    {
      $this->getUser()->setFlash('warning', libelle('msg_commission_token_incoherant'));
      $this->redirect($this->getModuleName().'/modifierInvitations?id='.$strId);
    }
    
    // verification de l'existence du laboratoire
    if (!LaboratoireTable::getInstance()->findOneById($strLaboratoireId))
    {
      $this->redirect('@non_autorise');
    }

    // creation objet Session_invitation_commission
    $objSession = Session_invitation_commissionTable::getInstance()->getSessionByLaboratoireIdAndToken($strLaboratoireId, $strToken);
    $objSession = $objSession == false ? new Session_invitation_commission() : $objSession[0];
    $objSession->setTransactionToken($strToken);
    $objSession->setLaboratoireId($strLaboratoireId);
    $objSession->setEstConcerne(true);

    // sauvegarde objet session_innovateur_commission
    $objSession->save();

    // redirection
    $this->redirect($this->getModuleName().'/modifierInvitations?id='.$strId);
  }

}
