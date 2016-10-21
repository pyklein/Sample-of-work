<?php
/**
 * Changement de l'activation d'un dossier de stage ERE
 *
 * @author Jihad
 */
class changerActivationDossier_ereAction extends gridAction {
  public function preExecute() {

  }

  public function execute($request) {
    $this->changerActivation($request->getParameter('id'),'Dossier_ere');
  }

  public function postExecute() {

  }
}
?>
