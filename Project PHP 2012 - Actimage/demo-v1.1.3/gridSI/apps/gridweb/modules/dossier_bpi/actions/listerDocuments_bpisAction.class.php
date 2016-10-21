<?php

/**
 * Description of listerDocumentsAction
 *
 * @author JihadS
 */
class listerDocuments_bpisAction extends gridAction
{
  public function execute($objRequeteWeb)
  {
    if ($objRequeteWeb->hasParameter('dossier_bpi'))
    {
      $this->strId = $objRequeteWeb->getParameter('dossier_bpi');
    }
    else
    {
      $this->redirect("@non_autorise");
    }
    
    $this->strModelContenant = 'dossier_bpi';
    $this->idContenant = $objRequeteWeb->getParameter('dossier_bpi');
    
    $this->objContenant = Dossier_bpiTable::getInstance()->findOneById($objRequeteWeb->getParameter('dossier_bpi'));
    if (!$this->objContenant){
      $this->redirect("@non_autorise");
    }
    
    $this->objDocumentsJoints = Documents_bpiTable::getInstance()->retrieveDocumentsByDossier($this->strId,true);
    $this->objDocumentsReferences = Documents_bpiTable::getInstance()->retrieveDocumentsByDossier($this->strId,false);

 
  }

}
