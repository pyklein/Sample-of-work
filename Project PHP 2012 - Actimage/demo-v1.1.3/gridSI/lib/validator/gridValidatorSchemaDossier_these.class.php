<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of gridValidatorSchemaDossier_these
 *
 * @author William
 */
class gridValidatorSchemaDossier_these extends gridValidatorSchema{
  
  public function configure($options = array(), $messages = array()){

    $this['titre'] = new sfValidatorString(array('required' => true));
    $this['numero'] = new sfValidatorString(array('required' => true));

    parent::configure();
  }
}
?>
