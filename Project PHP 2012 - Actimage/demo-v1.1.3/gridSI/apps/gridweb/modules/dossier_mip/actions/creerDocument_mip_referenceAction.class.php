<?php

/**
 * Creer un document référencé d'un dossier MIP
 * @author     Jihad Sahebdin
 */
class creerDocument_mip_referenceAction extends gridAction
{
  public function  preExecute()
  {
  }

  public function execute($request)
  {
    $objDocument = new Documents_mip();
    $objDocument->setEstJoint(false);
   
    $this->idContenant = $request->getParameter('dossier_mip');
    $this->strContenant = 'dossier_mip';
    $objDocument->setDossierMipId(Dossier_mipTable::getInstance()->findOneById($this->idContenant));

    $this->objContenant = Dossier_mipTable::getInstance()->findOneById($this->idContenant);
    if (!$this->objContenant){
      $this->redirect("@non_autorise");
    }
    
    $this->objForm = new Documents_mip_creer_referenceForm($objDocument);

    if ($request->isMethod('post')) 
    {
      $this->processForm('creer', "listerDocuments_mips?dossier_mip=". $this->idContenant);
    }
  }

  public function  postExecute()
  {
  }
}

