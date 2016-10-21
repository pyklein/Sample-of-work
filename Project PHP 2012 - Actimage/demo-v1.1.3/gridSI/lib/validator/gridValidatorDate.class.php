<?php
/**
 * Description of gridValidatorDate
 *
 * @author William
 */
class gridValidatorDate extends sfValidatorDate{
    public function  __construct($options = array(), $messages = array()) {
    if (array_key_exists('with_time',$options)){
    $options =  array_merge($options,array(
                        'date_format' => '~(?P<day>\d{2})/(?P<month>\d{2})/(?P<year>\d{4}) (?P<hour>\d{2}):(?P<minute>\d{2})~ '
                    ));
    } else {
      $options =  array_merge($options,array(
                        'date_format' => '~(?P<day>\d{2})/(?P<month>\d{2})/(?P<year>\d{4})~'
                    ));
    }
    if (!array_key_exists('bad_format', $messages)){
      $messages = array_merge($messages, array('bad_format' => libelle('msg_form_error_champ_date')));
    }
    parent::__construct($options, $messages);
  }
}
?>
