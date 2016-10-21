<?php

/**
 * Activer/Desactiver un étudiant
 *
 * @author Jihad Sahebdin
 */
class changerActivationEtudiantAction extends gridAction
{
  public function  preExecute()
  {
    parent::preExecute();
  }

  public function  execute($request)
  {
    if (!$request->hasParameter('id')){
     $this->redirect('@non_autorise');
    }
    
    if (sfContext::hasInstance())
      sfContext::getInstance()->getLogger()->debug('changerActivationEtudiant->execute() Start');

    $this->changerActivation($request->getParameter('id'),'Etudiant');

    if (sfContext::hasInstance())
      sfContext::getInstance()->getLogger()->debug('changerActivationEtudiant->execute() End');
  }

  public function  postExecute()
  {
    parent::postExecute();
  }
}
?>
