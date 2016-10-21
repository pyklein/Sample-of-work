<?php

/**
 * 
 */
class supprimerDocument_mip_jointAction extends gridAction
{

  public function preExecute() {
    
  }
  
  public function execute($request)
  {
    if (!$request->hasParameter('id')){
     $this->redirect('@non_autorise');
    }

    $this->objDocument = Documents_mipTable::getInstance()->findOneById($request->getParameter('id'));
    if (!$this->objDocument){
      $this->redirect('@non_autorise');
    }

    $this->idContenant = $request->getParameter('dossier_mip');
    $this->objContenant = Dossier_mipTable::getInstance()->findOneById($this->idContenant);
    if (!$this->objContenant){
      $this->redirect("@non_autorise");
    }

    if ($request->isMethod("post"))
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

      $this->redirect("dossier_mip/listerDocuments_mips?dossier_mip=".$this->idContenant);
    }


  }

  
}
