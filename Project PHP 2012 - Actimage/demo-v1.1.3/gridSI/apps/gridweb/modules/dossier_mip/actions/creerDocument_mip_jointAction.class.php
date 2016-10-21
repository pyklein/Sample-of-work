<?php
sfContext::getInstance()->getConfiguration()->loadHelpers("Libelle");

/**
 * Creer un document joint d'un dossier MIP
 * @author     Jihad Sahebdin
 */
class creerDocument_mip_jointAction extends gridAction
{
  public function  preExecute()
  {
  }

  public function execute($request)
  {
    $objDocument = new Documents_mip();

    //C'est un document joint
    $objDocument->setEstJoint(true);
    
    $this->idContenant = $request->getParameter('dossier_mip');
    $this->strContenant = 'dossier_mip';
    $objDocument->setDossierMipId(Dossier_mipTable::getInstance()->findOneById($this->idContenant));

    $this->objContenant = Dossier_mipTable::getInstance()->findOneById($this->idContenant);
    if (!$this->objContenant){
      $this->redirect("@non_autorise");
    }
    
    $this->objForm = new Documents_mip_creer_jointForm($objDocument);

   
    if ($request->isMethod('post')) 
    {
      $this->arrFiles = $request->getFiles($this->objForm->getName());
      $this->processForm("creer", "listerDocuments_mips?dossier_mip=".$this->idContenant, true);
    }
  }
}

