<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of gridValidatorSchemaOrganisme_mindef
 *
 * @author William
 */
class gridValidatorSchemaOrganisme_mindef extends gridValidatorSchema{
    public function configure($options = array(), $messages = array()){

    $this['intitule'] = new sfValidatorString(array('required' => true));
    $this['abreviation'] = new sfValidatorString(array('required' => true));

    parent::configure();
  }
}
?>
