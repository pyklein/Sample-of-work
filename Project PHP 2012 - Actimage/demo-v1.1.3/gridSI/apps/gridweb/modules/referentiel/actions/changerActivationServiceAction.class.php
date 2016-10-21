<?php

class changerActivationServiceAction extends gridAction {

  public function preExecute() {
    if (!$this->getRequest()->hasParameter('id')) {
      $this->redirect("@non_autorise");
    }
  }


  public function execute($request) {
    $this->changerActivation($request->getParameter("id"), 'Service', $request->getParameter('organisme'), 'organisme');
  }

  /**
   */
  public function postExecute() {
    
  }

}

?>
