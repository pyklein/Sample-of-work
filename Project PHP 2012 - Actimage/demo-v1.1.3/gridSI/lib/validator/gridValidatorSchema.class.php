<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of gridValidatorSchema
 *
 * @author William
 */
class gridValidatorSchema extends sfValidatorSchema{
  public function  __construct($fields = null, $options = array(), $messages = array()) {
    $options["allow_extra_fields"] = true;
    parent::__construct($fields, $options, $messages);
  }
}
?>
