<?php

/**
 * Description of supprimerFinancementDossier_mipAction
 *
 * @author Simeon Petev
 */
class supprimerFinancementDossier_mipAction extends gridAction
{
  public function  preExecute()
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    $idFinancement = $this->getRequest()->getParameter('financement_id');

    if ($idFinancement)
    {
      $this->objFinancement = FinancementTable::getInstance()->findOneById($idFinancement);
    }

    if (!$idFinancement ||
        !$this->objFinancement ||
        ($this->getUser()->getUtilisateur()->getId() != $this->objFinancement->getDossier_mip()->getPiloteId() &&
         !$this->getUser()->getUtilisateur()->hasProfil(ProfilTable::SUP_MIP)       
        )
       )
    {
      $this->getUser()->setFlash('erreur', libelle('msg_dossier_mip_financement_modifier_droit'));

      $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN AVANT REDIRECTION; ");

      $this->redirect(url_for('dossier_mip/listerDossier_mips'));
    }

    parent::preExecute();

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }

  public function execute($request)
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");


    if ($this->getRequest()->isMethod('post'))
    {
      try {
        $this->objFinancement->delete();

        $this->getUser()->setFlash('succes', libelle("msg_dossier_mip_financement_suppression_success"));
      } catch (Exception $exc) {
        $this->getUser()->setFlash('erreur', libelle("msg_dossier_mip_financement_suppression_error"));
        $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ Erreur: suppression de financement - id: ".$this->objFinancement->getId());
      }
      
      $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN AVENT REDIRECTION; ");

      $this->redirect(url_for('dossier_mip/listerFinancementDossier_mips?dossier_mip='.$this->objFinancement->getDossier_mip()->getId()));
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
