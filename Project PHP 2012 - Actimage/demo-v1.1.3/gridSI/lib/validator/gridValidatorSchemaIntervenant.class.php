<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of gridValidatorSchemaIntervenant
 *
 * @author William
 */
class gridValidatorSchemaIntervenant extends gridValidatorSchema{
public function configure($options = array(), $messages = array()){

    $this['civilite_id'] = new sfValidatorInteger(array('required' => true));
    $this['nom'] = new sfValidatorString(array('required' => true));
    $this['prenom'] = new sfValidatorString(array('required' => true));
    $this['email'] = new sfValidatorEmail(array('required' => true));

    parent::configure();
  }
}
?>
