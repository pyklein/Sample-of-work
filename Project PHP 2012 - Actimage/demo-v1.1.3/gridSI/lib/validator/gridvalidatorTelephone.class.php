<?php

/**
 * Description of validatorTelephone
 *
 * @author William
 */
class gridValidatorTelephone extends sfValidatorRegex{
  public function  __construct($options = array(), $messages = array()) {
    $options['pattern'] = '/^\(?\+?[\-\d\s()]*$/';
    parent::__construct($options, $messages);
  }
}
?>
