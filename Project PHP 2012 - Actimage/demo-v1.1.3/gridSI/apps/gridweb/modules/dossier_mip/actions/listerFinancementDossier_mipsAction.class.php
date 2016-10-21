<?php

/**
 * Description of listerFinancementDossier_mipsAction
 *
 * @author Simeon Petev
 */
class listerFinancementDossier_mipsAction extends gridAction
{
  public function  preExecute()
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    $idDossier = $this->getRequest()->getParameter('dossier_mip');

    if ($idDossier)
    {
      $this->objDossier = Dossier_mipTable::getInstance()->findOneById($idDossier);
    }

    if (!$idDossier ||
        !$this->objDossier ||
        ($this->getUser()->getUtilisateur()->getId() != $this->objDossier->getPiloteId() &&
         !$this->getUser()->getUtilisateur()->hasProfil(ProfilTable::SUP_MIP)
        )
       )
    {
      $this->getUser()->setFlash('erreur', libelle('msg_dossier_mip_financement_droit'));

      $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN AVANT REDIRECTION; ");

      $this->redirect(url_for('dossier_mip/listerDossier_mipsAction'));
    }

    parent::preExecute();

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }
  
  public function execute($request)
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    $this->arrFinancements = FinancementTable::getInstance()->retreveFinancementsOrdreDescDate($this->objDossier->getId());

    $this->arrFinancementParAnnee = $this->objDossier->getFinancementsGlobauxParAnnees();

    //Le total est celui de la derniere année
    $this->floatFinancementTotal = end($this->arrFinancementParAnnee);

    $this->floatBudgetGlobal = $this->objDossier->getBudgetTotalGlobal();

    $this->floatReserveGlobal = $this->floatBudgetGlobal - $this->floatFinancementTotal;

    if ($this->floatReserveGlobal < 0)
    {
      $this->getUser()->setFlash('warning', libelle('msg_dossier_mip_financement_reserve_negatif'));
    }

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
