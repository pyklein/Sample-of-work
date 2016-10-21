<?php

/**
 * Description of ajouterInvitationServiceAction
 * @author Gabor JAGER
 */
class ajouterInvitationServiceAction extends gridAction
{
  private $strNomToken = "session_invitations_token";

  public function execute($request)
  {

    if (!($request->hasParameter('commission') 
            && $request->hasParameter('service')))
    {
      $this->redirect("@non_autorise");
    }

    $strId = $request->getParameter('commission');
    $strToken = $this->getUser()->getAttribute($this->strNomToken);
    $strServiceId = $request->getParameter('service');

    // test coherance token
    if (strpos($strToken, "u".$this->getUser()->getUtilisateur()->getId()."c".$strId) === false)
    {
      $this->getUser()->setFlash('warning', libelle('msg_commission_token_incoherant'));
      $this->redirect($this->getModuleName().'/modifierInvitations?id='.$strId);
    }
    
    // verification de l'existence du laboratoire
    if (!ServiceTable::getInstance()->findOneById($strServiceId))
    {
      $this->redirect('@non_autorise');
    }

    // creation objet Session_invitation_commission
    $objSession = Session_invitation_commissionTable::getInstance()->getSessionByServiceIdAndToken($strServiceId, $strToken);
    $objSession = $objSession == false ? new Session_invitation_commission() : $objSession[0];
    $objSession->setTransactionToken($strToken);
    $objSession->setServiceId($strServiceId);
    $objSession->setEstConcerne(true);

    // sauvegarde objet Session_invitation_commission
    $objSession->save();

    // redirection
    $this->redirect($this->getModuleName().'/modifierInvitations?id='.$strId);
  }

}
