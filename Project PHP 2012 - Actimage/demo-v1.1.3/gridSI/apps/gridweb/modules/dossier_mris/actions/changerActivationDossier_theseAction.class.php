<?php
/**
 * Changement de l'activation d'un dossier de thèse
 *
 * @author Actimage
 */
class changerActivationDossier_theseAction extends gridAction {
  public function preExecute() {

  }

  public function execute($request) {
    $this->changerActivation($request->getParameter('id'),'Dossier_these');
  }

  public function postExecute() {

  }
}
?>
