<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of gridValidatorSchemaOrganisme
 *
 * @author William
 */
class gridValidatorSchemaOrganisme extends gridValidatorSchema{

  public function configure($options = array(), $messages = array()){

    $this['intitule'] = new sfValidatorString(array('required' => true));
    $this['abreviation'] = new sfValidatorString(array('required' => true));
    $this['type_organisme_id'] = new sfValidatorInteger(array('required' => true));

    parent::configure();
  }
}
?>
