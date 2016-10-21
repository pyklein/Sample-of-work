<?php
/**
 * Description of creerCommission
 *
 * @author William RICHARDS
 */
class creerCommissionAction extends gridAction{
    public function  execute($objRequeteWeb) {
    $objCommission = new Commission();
    $this->objForm = new CommissionForm($objCommission);
    if ($objRequeteWeb->isMethod('post')) {
      $this->processForm('creer');
    }
  }
}
?>
