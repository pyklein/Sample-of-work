<?php
sfContext::getInstance()->getConfiguration()->loadHelpers("Libelle");
sfContext::getInstance()->getConfiguration()->loadHelpers("Format");
/**
 * Modifier la photo  d'un étudiant
 * @author     Jihad Sahebdin
 */
class modifierPhotoEtudiantAction extends gridAction
{
  public function  preExecute()
  {
  }

  public function execute($request)
  {
    if (!$request->hasParameter('etudiant')){
     $this->redirect('@non_autorise');
    }

    $this->strId = $request->getParameter('etudiant');
    $objEtudiant = EtudiantTable::getInstance()->findOneById($this->strId); 
    if(!$objEtudiant)
    {
      $this->redirect("@non_autorise");
    }

    $this->objForm = new EtudiantPhotoForm($objEtudiant);
    
    $this->arrFiles = $request->getFiles($this->objForm->getName());

    if ($request->isMethod('post'))
    {
      $this->processForm('modifier', null,false);

      $this->redirect($this->getModuleName()."/".$this->getActionName()."?etudiant=".$this->strId);
    }
  }

  public function  postExecute()
  {
  }
}
