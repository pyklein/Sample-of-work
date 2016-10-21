<?php

/**
 * Creer un document référencé d'un dossier BPI
 * @author     Jihad Sahebdin
 */
class creerDocument_bpi_referenceAction extends gridAction
{
  public function  preExecute()
  {
  }

  public function execute($request)
  {
    $objDocument = new Documents_bpi();
    $objDocument->setEstJoint(false);
   
    $this->idContenant = $request->getParameter('dossier_bpi');
    $this->strContenant = 'dossier_bpi';
    $objDocument->setDossierBpiId(Dossier_bpiTable::getInstance()->findOneById($this->idContenant));

    $this->objContenant = Dossier_bpiTable::getInstance()->findOneById($this->idContenant);
    if (!$this->objContenant){
      $this->redirect("@non_autorise");
    }
    
    $this->objForm = new Documents_bpiForm($objDocument);

    if ($request->isMethod('post')) 
    {
      $this->processForm('creer', "listerDocuments_bpis?dossier_bpi=". $this->idContenant);
    }
  }

  public function  postExecute()
  {
  }
}

