<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of listerDocumentsAction
 *
 * @author JihadS
 */
class listerDocumentsAction extends gridAction {

  public function execute($objRequeteWeb) {
    if ($objRequeteWeb->hasParameter('dossier_these')) {
      $this->strId = $objRequeteWeb->getParameter('dossier_these');
      $this->strModelContenant = 'Dossier_these';
    } elseif ($objRequeteWeb->hasParameter('dossier_ere')){
      $this->strId = $objRequeteWeb->getParameter('dossier_ere');
      $this->strModelContenant = 'Dossier_ere';
    } elseif ($objRequeteWeb->hasParameter('dossier_postdoc')){
      $this->strId = $objRequeteWeb->getParameter('dossier_postdoc');
      $this->strModelContenant = 'Dossier_postdoc';
    } else {
      $this->redirect("@non_autorise");
    }
    $this->objContenant = Doctrine_Core::getTable($this->strModelContenant)->findOneById($this->strId);

    if (!$this->objContenant){
      $this->redirect("@non_autorise");
    }
    $this->objDocumentsJoints = Document_mrisTable::getInstance()->retrieveDocumentsByDossier($this->strId, strtolower($this->strModelContenant), true);
    $this->objDocumentsReferences = Document_mrisTable::getInstance()->retrieveDocumentsByDossier($this->strId, strtolower($this->strModelContenant), false);
  }

}
