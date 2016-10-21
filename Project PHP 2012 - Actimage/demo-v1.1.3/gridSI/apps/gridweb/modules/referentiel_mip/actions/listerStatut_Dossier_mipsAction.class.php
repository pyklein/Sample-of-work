<?php


/**
 * Description of listerStatutDossierMIP
 *
 * @author JihadS/WilliamR
 */
class listerStatut_Dossier_mipsAction extends gridAction
{
  public function execute($objRequete)
  {
    $this->objStatuts = Statut_dossier_mipTable::getInstance()->retrieveStatutsParOrdre();
  }
    
}