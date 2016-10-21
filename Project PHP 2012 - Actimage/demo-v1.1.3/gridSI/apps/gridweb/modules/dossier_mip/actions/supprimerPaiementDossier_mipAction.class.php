<?php
/**
 * Description of supprimerPaiementDossier_mipAction
 *
 * @author Simeon Petev
 */
class supprimerPaiementDossier_mipAction extends gridAction
{
  public function  preExecute()
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    $idPaiement = $this->getRequest()->getParameter('paiement_id');

    if ($idPaiement)
    {
      $this->objPaiement = PaiementTable::getInstance()->findOneById($idPaiement);
    }

    if (!$idPaiement ||
        !$this->objPaiement ||
        ($this->getUser()->getUtilisateur()->getId() != $this->objPaiement->getDossier_mip()->getPiloteId() &&
         !$this->getUser()->getUtilisateur()->hasProfil(ProfilTable::SUP_MIP)
        )
       )
    {
      $this->getUser()->setFlash('erreur', libelle('msg_dossier_mip_paiement_modifier_droit'));

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
        $this->objPaiement->delete();

        $this->getUser()->setFlash('succes', libelle("msg_dossier_mip_paiement_suppression_success"));
      } catch (Exception $exc) {
        $this->getUser()->setFlash('erreur', libelle("msg_dossier_mip_paiement_suppression_error"));
        $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ Erreur: suppression de paiement - id: ".$this->objPaiement->getId());
      }

      $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN AVENT REDIRECTION; ");

      $this->redirect(url_for('dossier_mip/listerPaiementDossier_mips?dossier_mip='.$this->objPaiement->getDossier_mip()->getId()));
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
