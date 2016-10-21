<?php

/**
 * Activer/desactiver un Dossier MIP
 * @author Gabor JAGER
 */
class changerActivationDossier_mipAction extends gridAction {

  /**
   */
  public function preExecute() {

  }

  public function execute($request) {
    $this->changerActivation($request->getParameter('id'),'Dossier_mip');
  }

  /**
   */
  public function postExecute() {

  }

}

