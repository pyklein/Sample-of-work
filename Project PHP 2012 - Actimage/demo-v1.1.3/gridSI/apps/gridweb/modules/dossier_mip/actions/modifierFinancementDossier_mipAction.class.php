<?php

/**
 * Description of modifierFinancementDossier_mipAction
 *
 * @author Simeon Petev
 */
class modifierFinancementDossier_mipAction extends gridAction
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

    $this->objForm = new FinancementForm($this->objFinancement);

    if ($this->getRequest()->isMethod('post'))
    {
      $arrValeursSubmites = $this->getRequest()->getParameter($this->objForm->getName());

      $arrValeursSubmites['dossier_mip_id'] = $this->objFinancement->getDossier_mip()->getId();

      $this->getRequest()->offsetUnset($this->objForm->getName());

      $this->getRequest()->setParameter($this->objForm->getName(),$arrValeursSubmites);

      if ($this->processForm('modifier', '', false))
      {
        $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN AVENT REDIRECTION; ");

        $this->redirect(url_for('dossier_mip/listerFinancementDossier_mips?dossier_mip='.$this->objFinancement->getDossier_mip()->getId()));
      }
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
