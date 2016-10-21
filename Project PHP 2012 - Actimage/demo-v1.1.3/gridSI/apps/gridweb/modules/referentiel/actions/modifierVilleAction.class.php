<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//require_once dirname(__FILE__) . '\formProcessAction.class.php';
/**
 * Description of modifierVilleAction
 *
 * @author William
 */
class modifierVilleAction extends gridAction{

  public function preExecute() {
    if (!$this->getRequest()->hasParameter('id')) {
      $this->redirect("@non_autorise");
    }
  }
  
  public function execute($request) {
    $objVille = VilleTable::getInstance()->findOneById($request->getParameter('id'));
    if (!$objVille || !$objVille->getDepartement()->getEstActif()){
      $this->redirect("@non_autorise");
    }
    $this->objForm = new VilleForm($objVille);
    if ($request->isMethod('post')) {
      $this->processForm('modifier');
    }
  }
}
?>
