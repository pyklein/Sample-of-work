<?php

/**
 * Activer/Desactiver un statut
 * @author Jihad Sahebdin
 */
class changerActivationStatutDossiermipAction extends gridAction {

  /**
   */
  public function preExecute() {

  }

  public function execute($request) {
    $this->changerActivation($request->getParameter('id'),'Statut_Dossier_mip');
  }

  /**
   */
  public function postExecute() {
    
  }

}

