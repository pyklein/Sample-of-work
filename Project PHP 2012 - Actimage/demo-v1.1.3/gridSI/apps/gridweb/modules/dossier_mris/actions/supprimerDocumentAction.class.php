<?php

/**
 *
 */
class supprimerDocumentAction extends gridAction
{

  public function preExecute() {

  }

  public function execute($objRequeteWeb)
  {
   if (!$objRequeteWeb->hasParameter('id')){
     $this->redirect('@non_autorise');
    }

    $this->objDocument = Document_mrisTable::getInstance()->findOneById($objRequeteWeb->getParameter('id'));
    if (!$this->objDocument){
      $this->redirect('@non_autorise');
    }
    $this->strModelContenant = 'dossier_'.$this->objDocument->getTypeDossier();
    $this->strIdContenant = $this->objDocument['Dossier_'.$this->objDocument->getTypeDossier()]->getId();
    $this->objContenant = Doctrine_Core::getTable($this->strModelContenant)->findOneById($this->strIdContenant);
    if (!$this->objContenant){
      $this->redirect("@non_autorise");
    }
    if ($objRequeteWeb->isMethod("post"))
    {
      try
      {

        $this->objDocument->delete();

        $this->getUser()->setFlash("succes", libelle("msg_suppression_document_mip_joint_succes", array($this->objDocument->getTitre())));

      }
      catch(Exception $ex)
      {
        $this->getUser()->setFlash("erreur", libelle("msg_suppression_document_mip_joint_erreur",array($this->objDocument->getTitre(),$ex->getMessage())));
      }

      $this->redirect("dossier_mris/listerDocuments?".  strtolower($this->strModelContenant)."=".$this->strIdContenant);
    }


  }


}
