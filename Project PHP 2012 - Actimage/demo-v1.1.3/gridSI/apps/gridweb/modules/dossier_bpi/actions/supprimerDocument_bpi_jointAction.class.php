<?php

/**
 * 
 */
class supprimerDocument_bpi_jointAction extends gridAction
{

  public function preExecute() {
    
  }
  
  public function execute($request)
  {
    if (!$request->hasParameter('id')){
     $this->redirect('@non_autorise');
    }

    $this->objDocument = Documents_bpiTable::getInstance()->findOneById($request->getParameter('id'));

    if (!$this->objDocument){
      $this->redirect('@non_autorise');
    }
    
    $this->idContenant = $request->getParameter('dossier_bpi');
    $this->objContenant = Dossier_bpiTable::getInstance()->findOneById($this->idContenant);
    
    if (!$this->objContenant){
      $this->redirect("@non_autorise");
    }

    if ($request->isMethod("post"))
    {
      try
      {
        $this->objDocument->delete();
        $this->getUser()->setFlash("succes", libelle("msg_suppression_document_bpi_joint_succes", array($this->objDocument->getTitre())));
      }
      catch(Exception $ex)
      {
        $this->getUser()->setFlash("erreur", libelle("msg_suppression_document_bpi_joint_erreur",array($this->objDocument->getTitre(),$ex->getMessage())));
      }

      $this->redirect("dossier_bpi/listerDocuments_bpis?dossier_bpi=".$this->idContenant);
    }


  }

  
}
