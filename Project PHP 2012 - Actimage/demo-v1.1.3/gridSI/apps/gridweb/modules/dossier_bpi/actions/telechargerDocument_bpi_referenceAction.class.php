<?php

/**
 * 
 */
class telechargerDocument_bpi_referenceAction extends gridAction
{

  public function preExecute() {
    
  }
  
  public function execute($request)
  {
    if (!$request->hasParameter('id')) {
      $this->redirect('@non_autorise');
    }

    $objDocument = Documents_bpiTable::getInstance()->findOneById($request->getParameter('id'));

    if (!$objDocument) {
      $this->redirect('@non_autorise');
    }

    $this->idContenant = $request->getParameter('dossier_bpi');
    $this->strContenant = 'dossier_bpi';
    $this->objContenant = Dossier_bpiTable::getInstance()->findOneById($objDocument->getDossierBpiId());

    if (!$this->objContenant) {
      $this->redirect("@non_autorise");
    }
    
    $this->numDossier = str_replace('/', '_', $this->objContenant->getNumero());

    $this->redirect("interface/telechargerDocumentReference?fichier=".$objDocument->getFichier()."&fichier_orig=".$objDocument->getFichier()."&numDossier=".$this->objContenant->getRepertoirePartage()."&type=bpi");
  }
 
}
