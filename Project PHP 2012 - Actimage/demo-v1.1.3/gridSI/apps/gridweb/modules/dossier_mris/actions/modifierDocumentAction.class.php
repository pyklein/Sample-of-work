<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of modifierDocument_JointAction
 *
 * @author William
 */
class modifierDocumentAction extends gridAction{
   public function  execute($objRequeteWeb) {
    if (!$objRequeteWeb->hasParameter('id')){
     $this->redirect('@non_autorise');
    }

    $objDocument = Document_mrisTable::getInstance()->findOneById($objRequeteWeb->getParameter('id'));
    if (!$objDocument){
      $this->redirect('@non_autorise');
    }
    $this->strModelContenant = 'dossier_'.$objDocument->getTypeDossier();
    $this->strIdContenant = $objDocument['Dossier_'.$objDocument->getTypeDossier()]->getId();
    $this->objContenant = Doctrine_Core::getTable($this->strModelContenant)->findOneById($this->strIdContenant);
    if (!$this->objContenant){
      $this->redirect("@non_autorise");
    }

    
    if ($objDocument->getEstJoint()){
      $this->objForm = new Document_mris_jointForm('dossier_'.$objDocument->getTypeDossier(),$objDocument);
    } else {
      $this->objForm = new Document_mris_referenceForm('dossier_'.$objDocument->getTypeDossier(),$objDocument);
    }

    if ($objRequeteWeb->isMethod('post')){
        $this->processForm('modifier','listerDocuments?'.  strtolower($this->strModelContenant)."=".$this->strIdContenant);
    }
  }
}
?>
