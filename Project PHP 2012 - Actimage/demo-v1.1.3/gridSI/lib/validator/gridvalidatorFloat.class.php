<?php

/**
 * Validateurs pour les chiffres à virgules
 *
 * @author Jihad
 */
class gridValidatorFloat extends sfValidatorRegex{
  public function  __construct($options = array(), $messages = array()) {
    $options['pattern'] = '/^[0-9]+\.?[0-9]{0,2}$/';
    parent::__construct($options, $messages);
  }
}
?>
