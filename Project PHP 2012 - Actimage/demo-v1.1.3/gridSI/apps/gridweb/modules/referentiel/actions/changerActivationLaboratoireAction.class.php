<?php
class changerActivationLaboratoireAction extends gridAction {

  /**
   */
  public function preExecute() {
    if (!$this->getRequest()->hasParameter('id')) {
      $this->redirect("@non_autorise");
    }
  }

  public function execute($request) {
    if ($request->hasParameter('organisme')){
      $strModeleParent = 'organisme';
    } else {
      $strModeleParent = 'service';
    }
    $this->changerActivation($request->getParameter("id"),'Laboratoire',$request->getParameter($strModeleParent),$strModeleParent);
  }

  /**
   */
  public function postExecute() {

  }
}
?>
