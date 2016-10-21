<?php
/**
 * Action pour le changement d'activation d'un dossier bpi
 *
 * @author Actimage
 */
class changerActivationDossier_bpiAction extends gridAction{
    public function preExecute() {

  }

  public function execute($request) {
    $this->changerActivation($request->getParameter('id'),'Dossier_bpi');
  }

  public function postExecute() {

  }
}
?>
