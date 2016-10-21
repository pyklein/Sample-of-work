<?php
//require_once dirname(__FILE__) . '\formProcessAction.class.php';

class creerDepartementAction extends gridAction {

  public function execute($request) {
    $objDepartement = new Departement();
    $this->objForm = new DepartementForm($objDepartement);
    if ($request->isMethod('post')) {
      $this->processForm('creer');
    }
  }

}

