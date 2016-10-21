<?php
sfContext::getInstance()->getConfiguration()->loadHelpers("Libelle");

/**
 * Modifier un document joint d'un dossier MIP
 * @author     Jihad Sahebdin
 */
class modifierDocument_mip_jointAction extends gridAction
{
  public function  preExecute()
  {
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
    $this->objContenant = Dossier_mipTable::getInstance()->findOneById($request->getParameter('dossier_mip'));
    if (!$this->objContenant){
      $this->redirect("@non_autorise");
    }
    
    
    $this->objForm = new Documents_mipForm($objDocument);

    if ($request->isMethod('post')) {
      $this->processForm('modifier', 'listerDocuments_mips?dossier_mip='.$request->getParameter('dossier_mip'));
    }
  }

  public function  postExecute()
  {
  }
}
