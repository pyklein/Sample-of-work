<?php


/**
 * Description of gridValidatorSchemaService
 *
 * @author William
 */
class gridValidatorSchemaService extends gridValidatorSchema{
    public function configure($options = array(), $messages = array()){

    $this['intitule'] = new sfValidatorString(array('required' => true));

    parent::configure();
  }
}
?>
