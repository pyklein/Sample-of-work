<?php
/**
 * Description of supprimerDossier_mipAction
 *
 * @author William
 */
class supprimerDossier_mipAction extends gridAction
{

  public function  execute($objRequeteWeb)
  {
    if(!$objRequeteWeb->hasParameter('id'))
    {
      $this->redirect('@non_autorise');
    }

    $this->objDossierMip = Dossier_mipTable::getInstance()->findOneById($objRequeteWeb->getParameter('id'));
    if (!$this->objDossierMip)
    {
      $this->redirect('@non_autorise');
    }

    if ($objRequeteWeb->isMethod('post'))
    {
      try
      {
        $this->objDossierMip->delete();
        $this->getUser()->setFlash('succes', libelle("msg_dossier_mip_supprimer_succes",array($this->objDossierMip->getNumero())));
      } 
      catch (Exception $ex)
      {
        $this->getUser()->setFlash('erreur', libelle("msg_dossier_mip_supprimer_erreur",array($this->objDossierMip->getNumero(),$ex->getMessage())));
      }
      $this->redirect("dossier_mip/listerDossier_mips");
    }
  }
}
?>
