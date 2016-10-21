<?php
sfContext::getInstance()->getConfiguration()->loadHelpers("Libelle");
sfContext::getInstance()->getConfiguration()->loadHelpers("Format");
/**
 * Modifier la formation d'un étudiant
 * @author     Jihad Sahebdin
 */
class modifierFormationEtudiantAction extends gridAction
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

    $this->objForm = new EtudiantFormationForm($objEtudiant);
    
    if ($request->isMethod('post')) {
      $this->processForm('modifier',null,false);
    }
  }

  public function  postExecute()
  {
  }
}
