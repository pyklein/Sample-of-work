<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of gridValidatorSchemaLaboratoire
 *
 * @author William
 */
class gridValidatorSchemaLaboratoire extends gridValidatorSchema{

   public function configure($options = array(), $messages = array()){

    $this['intitule'] = new sfValidatorString(array('required' => true));

    parent::configure();
  }

}
?>
