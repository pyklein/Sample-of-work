<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of listerCommissionsAction
 *
 * @author William
 */
class listerCommissionsAction extends gridAction{
  public function  execute($objRequeteWeb) {
    $this->objFormFiltre = new CommissionFormFilter();
    $objRequeteDoctrine = $this->processFiltre();
    $this->processPager($objRequeteDoctrine->orderBy('date_debut DESC'), 'Commission');
  }
}
?>
