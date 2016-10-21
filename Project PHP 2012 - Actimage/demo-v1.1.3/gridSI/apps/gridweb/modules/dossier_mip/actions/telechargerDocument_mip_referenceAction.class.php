<?php

/**
 * 
 */
class telechargerDocument_mip_referenceAction extends gridAction
{

  public function preExecute() {
    
  }
  
  public function execute($request)
  {
    if (!$request->hasParameter('id')){
     $this->redirect('@non_autorise');
    }

    $objDocument = Documents_mipTable::getInstance()->findOneById($request->getParameter('id'));
    if (!$objDocument){
      $this->redirect('@non_autorise');
    }

    $this->idContenant = $request->getParameter('dossier_mip');
    $this->strContenant = 'dossier_mip';
    $this->objContenant = Dossier_mipTable::getInstance()->findOneById($objDocument->getDossierMipId());
    if (!$this->objContenant){
      $this->redirect("@non_autorise");
    }
    
    $this->numDossier = $this->objContenant->getRepertoire_partage();

    $this->redirect("interface/telechargerDocumentReference?fichier=".$objDocument->getFichier()."&fichier_orig=".$objDocument->getFichier()."&numDossier=".$this->numDossier."&type=mip");
  }
 
}
