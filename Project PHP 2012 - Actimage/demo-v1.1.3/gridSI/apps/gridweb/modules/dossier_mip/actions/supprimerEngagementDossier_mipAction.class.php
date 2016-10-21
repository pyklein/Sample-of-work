<?php

/**
 * Description of supprimerEngagementDossier_mipAction
 *
 * @author Simeon Petev
 */
class supprimerEngagementDossier_mipAction extends gridAction
{
  public function  preExecute()
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    $idEngagement = $this->getRequest()->getParameter('engagement_id');

    if ($idEngagement)
    {
      $this->objEngagement = EngagementTable::getInstance()->findOneById($idEngagement);
    }

    if (!$idEngagement ||
        !$this->objEngagement ||
        ($this->getUser()->getUtilisateur()->getId() != $this->objEngagement->getDossier_mip()->getPiloteId() &&
         !$this->getUser()->getUtilisateur()->hasProfil(ProfilTable::SUP_MIP)
        )
       )
    {
      $this->getUser()->setFlash('erreur', libelle('msg_dossier_mip_engagement_modifier_droit'));

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
        $this->objEngagement->delete();

        $this->getUser()->setFlash('succes', libelle("msg_dossier_mip_engagement_suppression_success"));
      } catch (Exception $exc) {
        $this->getUser()->setFlash('erreur', libelle("msg_dossier_mip_engagement_suppression_error"));
        $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ Erreur: suppression de engagement - id: ".$this->objEngagement->getId());
      }

      $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN AVENT REDIRECTION; ");

      $this->redirect(url_for('dossier_mip/listerEngagementDossier_mips?dossier_mip='.$this->objEngagement->getDossier_mip()->getId()));
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
