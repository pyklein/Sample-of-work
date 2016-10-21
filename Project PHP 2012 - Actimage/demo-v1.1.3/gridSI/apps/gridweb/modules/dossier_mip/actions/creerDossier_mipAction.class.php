<?php

class creerDossier_mipAction extends gridAction {

  public function  preExecute() {
    if (!$this->getUser()->hasAttribute('statut_projet')){
      $this->redirect('dossier_mip/creerProjet_mip');
    }
  }


  public function execute($request) {
    $objDossier = new Dossier_mip();
    $objDossier->setStatutProjetMipId($this->getUser()->getAttribute('statut_projet'));
    $objDossier['Statut_dossier_mip'] = Statut_dossier_mipTable::getInstance()->findRoot();
    $this->objForm = new Dossier_mipForm($objDossier);
    $this->arrFiles = $request->getFiles("dossier_mip");
    if ($request->isMethod('post')) {

      if ($this->processForm('creer', "", false))
      {
        $utilFichier = new UtilFichier();
        $serviceArbo = new ServiceArborescence();
        try {
          $utilFichier->isExiste($serviceArbo->getRepertoirePartageDocumentsMip($objDossier->getRepertoirePartage()));
        } catch (Exception $e){
          $this->getUser()->setFlash('warning', libelle("msg_erreur_creation_dossier_partage"));
        }
        $this->redirect(url_for('dossier_mip/modifierDossier_mip?id='.$this->objForm->getObject()->getId()));
      }

    }
  }

}

