<?php
/**
 * Description of retirerInnovateurAction
 * @author Gabor JAGER
 */
class retirerInvitationAction extends gridAction
{
  private $strNomToken = "session_invitations_token";

  public function execute($request)
  {
    if (!($request->hasParameter('commission')
            && ($request->hasParameter('service')
                  || $request->hasParameter('laboratoire')
                  || $request->hasParameter('invitation'))))
    {
      $this->redirect("@non_autorise");
    }

    $strId = $request->getParameter('commission');
    $strToken = $this->getUser()->getAttribute($this->strNomToken);
    $strLaboratoire = $request->getParameter('laboratoire', null);
    $strService = $request->getParameter('service', null);
    $strInvitation = $request->getParameter('invitation', null);
    
    // test coherance token
    if (strpos($strToken, "u".$this->getUser()->getUtilisateur()->getId()."c".$strId) === false)
    {
      $this->getUser()->setFlash('warning', libelle('msg_dossier_mip_token_incoherant'));
      $this->redirect($this->getModuleName() . '/modifierInvitations?id='.$strId);
    }

    // verification de l'existence de laboratoire
    if ($strLaboratoire != null 
            && !LaboratoireTable::getInstance()->findOneById($strLaboratoire))
    {
      $this->redirect('@non_autorise');
    }

    // verification de l'existence de service
    else if ($strService != null
            && !ServiceTable::getInstance()->findOneById($strService))
    {
      $this->redirect('@non_autorise');
    }

    // verification de l'existence d'invitation
    else if ($strInvitation != null
            && !InvitationTable::getInstance()->findOneById($strInvitation))
    {
      $this->redirect('@non_autorise');
    }

    // creation objet Session_invitation_commission
    // laboratoire
    if ($strLaboratoire != null)
    {
      $objSession = Session_invitation_commissionTable::getInstance()->getSessionByLaboratoireIdAndToken($strLaboratoire, $strToken);
      $objSession = $objSession == false ? new Session_invitation_commission() : $objSession[0];
      $objSession->setLaboratoireId($strLaboratoire);
    }
    // service
    else if ($strService != null)
    {
      $objSession = Session_invitation_commissionTable::getInstance()->getSessionByServiceIdAndToken($strService, $strToken);
      $objSession = $objSession == false ? new Session_invitation_commission() : $objSession[0];
      $objSession->setServiceId($strService);
    }
    // invitation
    else
    {
      $objSession = Session_invitation_commissionTable::getInstance()->getSessionByInvitationIdAndToken($strInvitation, $strToken);
      $objSession = $objSession == false ? new Session_invitation_commission() : $objSession[0];
      $objSession->setInvitationId($strInvitation);
    }

    $objSession->setTransactionToken($strToken);
    $objSession->setEstConcerne(false);

    // sauvegarde objet Session_invitation_commission
    $objSession->save();

    // redirection
    $this->redirect($this->getModuleName().'/modifierInvitations?id='.$strId);
  }
}
