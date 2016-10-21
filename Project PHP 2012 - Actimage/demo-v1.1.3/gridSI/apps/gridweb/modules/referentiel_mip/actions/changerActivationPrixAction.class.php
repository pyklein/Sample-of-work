<?php

/**
 * Changement du statut du prix (Activation/Désactivation)
 *
 * @author Actimage
 */
class changerActivationPrixAction extends gridAction{
    public function preExecute() {

  }

  public function execute($request) {
    $this->changerActivation($request->getParameter('id'),'Prix');
  }

  public function postExecute() {

  }
}
?>
