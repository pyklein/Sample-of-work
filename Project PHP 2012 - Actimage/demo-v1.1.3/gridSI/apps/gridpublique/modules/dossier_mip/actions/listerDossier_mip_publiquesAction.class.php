<?php

/**
 * Description of listerDossier_mip
 *
 * @author Jihad
 */
class listerDossier_mip_publiquesAction extends gridAction
{
  public function execute($request) 
  {
    $this->objFormFiltre = new Dossier_mipFormFilter(false,Dossier_mipTable::getInstance()->getDossiersMIPPubliquesQuery());
    $request = $this->processFiltre();
    
    $this->processPager($request, 'Dossier_mip');
    

  }
}
