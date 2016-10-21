<?php

/**
 * Description of changerActivationContratAction
 *
 * @author Simeon Petev
 */
class changerActivationContratAction extends gridAction
{
  public function  preExecute()
  {
    if (sfContext::hasInstance())
    {
      sfContext::getInstance()->getLogger()->debug('changerActivationContratAction->preexecute() Start');
    }

    $idContrat = $this->getRequest()->getParameter('id');

    $this->objContrat = ContratTable::getInstance()->findOneById(($idContrat) ? $idContrat : 0);

    if (($this->objContrat == null) || ($this->objContrat->getId()==0))
    {
      if ($idContrat != null)
      {
        $this->getUser()->setFlash("erreur", libelle('msg_contrat_droit'));
      }

      $this->redirect(url_for('dossier_bpi/listerDossier_bpis'));
    }

    parent::preExecute();

    if (sfContext::hasInstance())
    {
      sfContext::getInstance()->getLogger()->debug('changerActivationContratAction->preexecute() Fin');
    }
  }

  public function  execute($request)
  {
    if (sfContext::hasInstance())
    {
      sfContext::getInstance()->getLogger()->debug('changerActivationContratAction->execute() Start');
    }

    $this->changerActivation($this->objContrat->getId(), 'Contrat', $this->objContrat->getDossierBpiId(), 'dossier_bpi_id');

    if (sfContext::hasInstance())
    {
      sfContext::getInstance()->getLogger()->debug('changerActivationContratAction->execute() Fin');
    }
  }

  public function  postExecute()
  {
    if (sfContext::hasInstance())
    {
      sfContext::getInstance()->getLogger()->debug('changerActivationContratAction->postExecute() Start');
    }

    parent::postExecute();

    if (sfContext::hasInstance())
    {
      sfContext::getInstance()->getLogger()->debug('changerActivationContratAction->postExecute() Fin');
    }
  }
}
?>
