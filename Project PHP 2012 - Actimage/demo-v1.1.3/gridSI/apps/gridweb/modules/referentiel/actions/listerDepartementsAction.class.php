<?php

/**
 * Liste des départements
 * @author Gabor JAGER
 */
class listerDepartementsAction extends gridAction
{
  /**
   */
  public function preExecute()
  {
  }

    
  public function execute($objRequete)
  {
    $this->processPager(DepartementTable::getInstance()->retrieveDepartements(), 'Departement', $objRequete);
  }


  /**
   */
  public function postExecute()
  {
  }
}

