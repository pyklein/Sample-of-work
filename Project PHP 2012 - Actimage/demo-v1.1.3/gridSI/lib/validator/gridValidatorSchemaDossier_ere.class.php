<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of gridValidatorSchemaDossier_ere
 *
 * @author William
 */
class gridValidatorSchemaDossier_ere extends gridValidatorSchema{
    public function configure($options = array(), $messages = array()){

    $this['titre'] = new sfValidatorString(array('required' => true));
    $this['numero_provisoire'] = new sfValidatorString(array('required' => true));

    parent::configure();
  }
}
?>
