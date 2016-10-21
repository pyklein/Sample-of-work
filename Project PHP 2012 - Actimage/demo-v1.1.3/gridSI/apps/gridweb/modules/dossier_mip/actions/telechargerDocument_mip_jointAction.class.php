<?php

/**
 * 
 */
class telechargerDocument_mip_jointAction extends gridAction
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
    $utilArbo = new ServiceArborescence();
    $strChemin = $utilArbo->getRepertoireDocumentsDossierMIP($objDocument->getDossier_mip()->getNumero());
    $this->redirect("interface/telechargerDocument?path=". bin2hex($strChemin) . "&fichier=".$objDocument->getFichier()."&fichier_orig=".$objDocument->getFichierOrig());
  }
}
