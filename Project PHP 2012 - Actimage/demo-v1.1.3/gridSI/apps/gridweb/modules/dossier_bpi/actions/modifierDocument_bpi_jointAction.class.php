<?php
sfContext::getInstance()->getConfiguration()->loadHelpers("Libelle");

/**
 * Modifier un document joint d'un dossier BPI
 * @author     Jihad Sahebdin
 */
class modifierDocument_bpi_jointAction extends gridAction
{
  public function  preExecute()
  {
  }

  public function execute($request)
  {
    if (!$request->hasParameter('id')){
     $this->redirect('@non_autorise');
    }

    $objDocument = Documents_bpiTable::getInstance()->findOneById($request->getParameter('id'));
    if (!$objDocument){
      $this->redirect('@non_autorise');
    }

    $this->idContenant = $request->getParameter('dossier_bpi');
    $this->strContenant = 'dossier_bpi';
    $this->objContenant = Dossier_bpiTable::getInstance()->findOneById($request->getParameter('dossier_bpi'));

    if (!$this->objContenant){
      $this->redirect("@non_autorise");
    }
    
    $this->objForm = new Documents_bpi_jointForm($objDocument);

    if ($request->isMethod('post')) {
      $this->processForm('modifier', 'listerDocuments_bpis?dossier_bpi='.$request->getParameter('dossier_bpi'));
    }
  }

  public function  postExecute()
  {
  }
}
