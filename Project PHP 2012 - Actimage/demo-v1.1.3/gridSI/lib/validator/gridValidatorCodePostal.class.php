<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of gridValidatorCodePostal
 *
 * @author William
 */
class gridValidatorCodePostal extends sfValidatorRegex{
  public function  __construct($options = array(), $messages = array()) {
    $options['pattern'] = '/^[0-9]{5}$/';
    parent::__construct($options, $messages);
  }
}
?>
