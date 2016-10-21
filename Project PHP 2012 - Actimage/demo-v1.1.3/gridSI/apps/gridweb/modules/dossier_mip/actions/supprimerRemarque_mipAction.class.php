<?php
/**
 * Description of supprimerRemarque_mipAction
 *
 * @author William
 */
class supprimerRemarque_mipAction extends gridAction {

  public function execute($objRequeteWeb) {
    if (!$objRequeteWeb->hasParameter('id')) {
      $this->redirect("@non_autorise");
    }
    $objRemarque = Remarque_mipTable::getInstance()->findOneById($objRequeteWeb->getParameter('id'));
    if (!$objRemarque) {
      $this->redirect('@non_autorise');
    }

    $this->strContenant = 'dossier_mip';
    $this->idContenant = $objRemarque->getDossierMipId();

    $this->objDossierMip = $objRemarque->getDossier_mip();

    if ($objRequeteWeb->isMethod('post')){
      $objRemarque->delete();
      $this->getUser()->setFlash('success', libelle("msg_remarque_suppression_reussie"));
      $this->redirect('dossier_mip/listerRemarque_mips?dossier_mip='.$this->idContenant);
    }
  }

}

?>
