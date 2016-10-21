<?php
sfContext::getInstance()->getConfiguration()->loadHelpers("Libelle");

/**
 * Creer un document joint d'un dossier BPI
 * @author     Jihad Sahebdin
 */
class creerDocument_bpi_jointAction extends gridAction
{
  public function  preExecute()
  {
  }

  public function execute($request)
  {
    if (!$request->hasParameter("dossier_bpi")){
       $this->redirect("@non_autorise");
    }
    $this->idContenant = $request->getParameter('dossier_bpi');
    $this->objContenant = Dossier_bpiTable::getInstance()->findOneById($this->idContenant);
    if (!$this->objContenant){
      $this->redirect("@non_autorise");
    }
    $this->strContenant = 'dossier_bpi';

    $objDocument = new Documents_bpi();
    //C'est un document joint
    $objDocument->setEstJoint(true);
    $objDocument->setDossierBpiId($this->idContenant);

    $this->objForm = new Documents_bpi_jointForm($objDocument);

    if ($request->isMethod('post')) 
    {
      $this->arrFiles = $request->getFiles($this->objForm->getName());
      $this->processForm("creer", "listerDocuments_bpis?dossier_bpi=".$this->idContenant, true);
    }
  }
}

