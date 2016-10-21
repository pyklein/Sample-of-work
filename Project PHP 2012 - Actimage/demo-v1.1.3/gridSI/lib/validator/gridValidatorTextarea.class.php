<?php

/**
 * Validateur pour un champ de type textaera
 *
 * @author Alexandre WETTA
 */
class gridValidatorTextarea extends sfValidatorRegex {

  public function __construct($options = array(), $messages = array()) {

    //set des options
    $options['pattern'] = '#<\s*script#i';
    $options['must_match'] = false;

    //set des messages
    $messages['invalid'] = libelle('msg_libelle_texte_invalide') ;
    
    parent::__construct($options, $messages);
  }

}
?>
