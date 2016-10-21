<?php

/**
 * Description of listerDossier_mip
 *
 * @author William
 */
class listerDossier_mipsAction extends gridAction
{
  public function execute($request) 
  {
    $this->objFormFiltre = new Dossier_mipFormFilter(true,null,array('dossier_vivant' => 'on'));
    $this->credentials = $this->getUser()->getAttribute('credentials');
    $objRequeteDoctrine = $this->processFiltre();
    $objRequeteDoctrine = Dossier_mipTable::getInstance()->getRequeteListeParUtilisateur($objRequeteDoctrine,$this->getUser());
    $this->processPager($objRequeteDoctrine->orderBy('numero DESC'), 'Dossier_mip');

    //nettoyage session
    $this->getUser()->offsetUnset('statut_projet');
  }
}