<?php

/**
 * Description of listerDocumentsAction
 *
 * @author JihadS
 */
class listerDocuments_mipsAction extends gridAction
{
  public function execute($objRequeteWeb)
  {
    if ($objRequeteWeb->hasParameter('dossier_mip'))
    {
      $this->strId = $objRequeteWeb->getParameter('dossier_mip');
    }
    else
    {
      $this->redirect("@non_autorise");
    }
    
    $this->strModelContenant = 'dossier_mip';
    $this->idContenant = $objRequeteWeb->getParameter('dossier_mip');
    $this->objContenant = Dossier_mipTable::getInstance()->findOneById($objRequeteWeb->getParameter('dossier_mip'));
    if (!$this->objContenant){
      $this->redirect("@non_autorise");
    }
    
    $this->objDocumentsJoints = Documents_mipTable::getInstance()->retrieveDocumentsByDossier($this->strId,true);
    $this->objDocumentsReferences = Documents_mipTable::getInstance()->retrieveDocumentsByDossier($this->strId,false);

 
  }

}
