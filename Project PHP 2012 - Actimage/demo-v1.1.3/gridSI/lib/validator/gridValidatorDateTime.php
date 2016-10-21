<?php

/**
 * Description of gridValidatorDateTime
 *
 * @author William
 */
class gridValidatorDateTime extends gridValidatorDate{
  public function __construct($options = array(), $messages = array()) {
    $options =  array_merge($options,array('with_time' => 'true'));
    $messages = array_merge($messages, array('bad_format' => libelle('msg_form_error_champ_date_time'),
                                             'required' => libelle('msg_form_error_champ_obligatoire')));
    parent::__construct($options, $messages);
  }


  public function doClean($value) {
      $value = $value['date'].' '.$value['time'];
      return  parent::doClean($value);
  }
    
}
?>
