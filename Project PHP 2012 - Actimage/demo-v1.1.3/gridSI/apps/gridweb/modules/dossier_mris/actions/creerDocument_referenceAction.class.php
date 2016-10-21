<?php

/**
 * Creer un document référencé d'un dossier MIP
 * @author     Jihad Sahebdin
 */
class creerDocument_referenceAction extends gridAction
{
  public function  preExecute()
  {
  }

  public function execute($objRequeteWeb)
  {
    if ($objRequeteWeb->hasParameter('dossier_these')) {
      $this->strIdContenant = $objRequeteWeb->getParameter('dossier_these');
      $this->strModelContenant = 'Dossier_these';
    } elseif ($objRequeteWeb->hasParameter('dossier_ere')){
      $this->strIdContenant = $objRequeteWeb->getParameter('dossier_ere');
      $this->strModelContenant = 'Dossier_ere';
    } elseif ($objRequeteWeb->hasParameter('dossier_postdoc')){
      $this->strIdContenant = $objRequeteWeb->getParameter('dossier_postdoc');
      $this->strModelContenant = 'Dossier_postdoc';
    } else {
      $this->redirect("@non_autorise");
    }
    $this->objContenant = Doctrine_Core::getTable($this->strModelContenant)->findOneById($this->strIdContenant);
    if (!$this->objContenant){
      $this->redirect("@non_autorise");
    }

    $objDocument = new Document_mris();
    $objDocument->setEstJoint(false);
   
    $objDocument[strtolower($this->strModelContenant).'_id'] = $this->strIdContenant;

    $this->objForm = new Document_mris_referenceForm(strtolower($this->strModelContenant),$objDocument);
    if ($objRequeteWeb->isMethod('post'))
    {
      $this->processForm('creer','listerDocuments?'.  strtolower($this->strModelContenant)."=".$this->strIdContenant);
    }
  }

  public function  postExecute()
  {
  }
}

