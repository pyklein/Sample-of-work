<?php
/**
 * Changement de l'activation d'un dossier de stage postdoc
 *
 * @author Jihad
 */
class changerActivationDossier_postdocAction extends gridAction {
  public function preExecute() {

  }

  public function execute($request) {
    $this->changerActivation($request->getParameter('id'),'Dossier_postdoc');
  }

  public function postExecute() {

  }
}
?>
