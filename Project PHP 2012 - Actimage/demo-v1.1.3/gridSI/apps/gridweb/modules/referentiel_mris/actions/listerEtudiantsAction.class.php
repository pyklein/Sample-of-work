<?php

/**
 * Listes des étudiants
 *
 * @author JihadS
 */
class listerEtudiantsAction extends gridAction
{
  public function  preExecute()
  {
    parent::preExecute();
  }
  
  public function execute($objRequete)
  {
    $this->objFormFiltre = new EtudiantFormFilter();

    $this->boolReinitialiser = true;

    $objRequeteDoctrine = $this->processFiltre();
    
    $this->processPager($objRequeteDoctrine->orderBy('nom ASC'), 'Etudiant');
  }

  public function  postExecute()
  {
    parent::postExecute();
  }
    
}