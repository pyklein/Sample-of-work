<?php

/**
 * Description of listerPaiementDossier_mipsAction
 *
 * @author Simeon Petev
 */
class listerPaiementDossier_mipsAction extends gridAction
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
      $this->getUser()->setFlash('erreur', libelle('msg_dossier_mip_paiement_droit'));

      $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN AVANT REDIRECTION; ");

      $this->redirect(url_for('dossier_mip/listerDossier_mipsAction'));
    }

    parent::preExecute();

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }

  public function execute($request)
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    $this->arrPaiements = PaiementTable::getInstance()->retrevePaiementsOrdreDescDate($this->objDossier->getId());

    //recherche des engagement
    $this->arrEngagementParAnnee = $this->objDossier->getEngagementsGlobauxParAnnees();
    $this->floatEngagementTotal  = end($this->arrEngagementParAnnee);

//    $this->arrFinancementParAnnee = $this->objDossier->getFinancementsGlobauxParAnnees();

    $this->arrPaiementParAnnee = $this->objDossier->getPaiementsGlobauxParAnnees();

    //Le total est celui de la derniere année
    $this->floatPaiementTotal = end($this->arrPaiementParAnnee);

    $this->floatBudgetGlobal = $this->objDossier->getBudgetTotalGlobal();

    $this->floatReserveGlobal = $this->floatBudgetGlobal - $this->floatPaiementTotal;

    if ($this->floatReserveGlobal < 0)
    {
      $this->getUser()->setFlash('warning', libelle('msg_dossier_mip_financement_reserve_negatif'));
    }

    if(($this->floatEngagementTotal - $this->floatPaiementTotal) < 0){
      $this->getUser()->setFlash('warning', libelle('msg_dossier_mip_paiement_superieur_engagement'));
    }

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }

}
?>
