<?php

if (sfContext::hasInstance())
{
  sfContext::getInstance()->getResponse()->addJavaScript("jquery/jquery-ui-1.8.10.custom.min.js", 'last');
  sfContext::getInstance()->getResponse()->addJavaScript("jquery/jquery.ui.datepicker-fr.js", 'last');
  sfContext::getInstance()->getResponse()->addJavaScript("jquery/jquery.ui.timepicker.js", 'last');
}

/**
 * Description of sfWidgetFormJQueryDateTime
 *
 * @author William
 */
class sfWidgetFormJQueryDateTime extends sfWidgetFormDateTime {

  protected function getDateWidget($attributes = array()) {
    return new sfWidgetFormInputJQueryDate($this->getOptionsFor('date'), $this->getAttributesFor('date', $attributes));
  }

  protected function getTimeWidget($attributes = array()) {
    $options = array_merge(array('hourText'=> 'Heure',
                'minuteText'=> 'Minute',
                'separator' => ':'),$this->getOptionsFor('time'));
    return new sfWidgetFormInputJQueryTime($options, $this->getAttributesFor('time', $attributes));
  }

  function render($name, $value = null, $attributes = array(), $errors = array())
  {
    if (!is_array($value) && $value != ''){
      $value = explode(' ', $value);
      $value = array('date' => $value[0], 'time' => substr($value[1], 0,5));
    }

    $date = $this->getDateWidget($attributes)->render($name.'[date]', $value['date']);

    if (!$this->getOption('with_time'))
    {
      return $date;
    }

    return strtr($this->getOption('format'), array(
      '%date%' => $date,
      '%time%' => $this->getTimeWidget($attributes)->render($name.'[time]', $value['time']),
    ));
  }
}

?>
