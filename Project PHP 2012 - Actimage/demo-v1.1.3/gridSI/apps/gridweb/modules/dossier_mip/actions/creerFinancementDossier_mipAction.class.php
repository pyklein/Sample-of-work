<?php

/**
 * Description of creerFinancementDossier_mip
 *
 * @author Simeon Petev
 */
class creerFinancementDossier_mipAction extends gridAction
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

      $this->redirect(url_for('dossier_mip/listerDossier_mips'));
    }

    parent::preExecute();

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }

  public function execute($request)
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    $this->objForm = new FinancementForm();

    if ($this->getRequest()->isMethod('post'))
    {
      $arrValeursSubmites = $this->getRequest()->getParameter($this->objForm->getName());

      $arrValeursSubmites['dossier_mip_id'] = $this->objDossier->getId();

      $this->getRequest()->offsetUnset($this->objForm->getName());

      $this->getRequest()->setParameter($this->objForm->getName(),$arrValeursSubmites);

      if ($this->processForm('creer', '', false))
      {
        $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN AVENT REDIRECTION; ");

        $this->redirect(url_for('dossier_mip/listerFinancementDossier_mips?dossier_mip='.$this->objDossier->getId()));
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
