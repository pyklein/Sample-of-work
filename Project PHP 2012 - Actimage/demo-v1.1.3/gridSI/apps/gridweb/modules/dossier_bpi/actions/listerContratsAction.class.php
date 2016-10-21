<?php

/**
 * Description of listerContratsAction
 *
 * @author Simeon Petev
 */
class listerContratsAction extends gridAction
{
  public function  preExecute()
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    $idDossier = $this->getRequest()->getParameter('dossier_bpi_id');

    $this->objDossier = Dossier_bpiTable::getInstance()->findOneById(($idDossier) ? $idDossier : 0);

    if (($this->objDossier == null) || ($this->objDossier->getId()==0))
    {
      if ($idDossier != null)
      {
        $this->getUser()->setFlash("erreur", libelle('msg_dossier_bpi_droit'));
      }

      $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN AVANT REDIRECTION; ");
      
      $this->redirect(url_for('dossier_bpi/listerDossier_bpis'));
    }

    parent::preExecute();

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }

  public function  execute($request)
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    $objQuery = ContratTable::getInstance()->buildQueryListContratsParDossierOrdreDscDate($this->objDossier->getId());

    $this->processPager($objQuery,'Contrat');
    
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }

  public function  postExecute()
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    parent::postExecute();

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }
}
?>
