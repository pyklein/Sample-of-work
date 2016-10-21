<?php

/**
 * Description of modifierParticipants_mindefAction
 * @author Gabor JAGER
 */
class modifierInvitationsAction extends gridAction
{
  private $strNomToken = "session_invitations_token";

  public function execute($request)
  {
    $this->strId = $request->getParameter('id');
    if (!CommissionTable::getInstance()->findOneById($this->strId))
    {
      $this->redirect("@non_autorise");
    }

    // Récupération ou création session_participants_mindef_token en session
    if ($this->getUser()->hasAttribute($this->strNomToken)
            && $this->getUser()->getFlash('warning', '') == ''
            && $request->getParameter('start') != 'true')
    {

      $this->transactionToken = $this->getUser()->getAttribute($this->strNomToken);

      // cas POST 'Enregistrer les modifications'
      if ($request->isMethod('post') 
              && !(($request->hasParameter('resultats1') 
                      || ($request->hasParameter('resultats2'))
                      || ($request->hasParameter('resultats3')))))
      {
        $this->enregistrerModifications();
      }
    } 
    
    // cas GET ou POST pagination
    else
    {
      // nettoyer base pour ancien token
      $strAncienToken = $this->getUser()->getAttribute($this->strNomToken, '');
      if ($strAncienToken != '')
      {
        Session_invitation_commissionTable::getInstance()->nettoyerAncienneSession($strAncienToken);
      }

      // création nouveau token
      $this->transactionToken = "u".$this->getUser()->getUtilisateur()->getId()."c".$this->strId."r".rand(1000, 9999);
      $this->getUser()->setAttribute($this->strNomToken, $this->transactionToken);
      if ($request->getParameter('start') == 'true')
      {
        $this->redirect($this->getModuleName().'/modifierInvitations?id='.$this->strId);
      }
    }
 
    // Génération requête liste services disponibles
    $objRequeteDoctrineDisponibleService = ServiceTable::getInstance()->retrieveServicesDisponibles($this->transactionToken, $this->strId);

    // Génération requête liste laboratoires disponibles
    $objRequeteDoctrineDisponibleLaboratoire = LaboratoireTable::getInstance()->retrieveLaboratoiresDisponibles($this->transactionToken, $this->strId);

    // Initialisation pager
    $this->objPager1 = $this->processPager($objRequeteDoctrineDisponibleService, 'Service', true, 1);
    $this->objPager2 = $this->processPager($objRequeteDoctrineDisponibleLaboratoire, 'Laboratoire', true, 2);
    $this->arrInvites = InvitationTable::getInstance()->retrieveCommissionInvites($this->transactionToken, $this->strId);
  }

  /**
   * Enregistre les modifications en session de manière effective dans le referentiel
   */
  public function enregistrerModifications()
  {
    $logger = $this->getLogger();

    $logger->debug("{".__CLASS__."} ".__FUNCTION__." DEBUT; ".$this->strNomToken."=".$this->transactionToken);

    // parcours des enregistrement support puis enregistrement (en une transaction)
    try
    {
      InvitationTable::getInstance()->enregistrerModificationSession($this->transactionToken, $this->strId, $this->getUser()->getUtilisateur());
    }
    catch (Exception $ex)
    {
      $logger->err("{".__CLASS__."} ".__FUNCTION__." ECHEC; ".$this->strNomToken."=".$this->transactionToken." Erreur : ".$ex->getMessage());
      $this->getUser()->setFlash('erreur', libelle('msg_invitations_enregistrer_erreur', array($ex->getMessage())));
      $this->redirect($this->getModuleName().'/'.$this->getActionName().'?id='.$this->strId);
    }

    // redirection (start = true si réussite)
    $logger->debug("{".__CLASS__."} ".__FUNCTION__." FIN; ".$this->strNomToken."=".$this->transactionToken);
    $this->getUser()->setFlash('succes', libelle('msg_invitations_enregistrer_succes'));
    $this->redirect($this->getModuleName().'/'.$this->getActionName().'?id='.$this->strId);
  }
}
