<?php

if (sfContext::hasInstance())
{
  sfContext::getInstance()->getResponse()->addJavaScript("jquery/jquery.ui.timepicker.js", 'last');
}

/**
 * JQuery time widget
 * @author Gabor JAGER
 */
class sfWidgetFormInputJQueryTime extends sfWidgetFormTime {

  public function __construct($options = array(), $attributes = array())
  {
    $this->addOption('hourText', null);
    $this->addOption('minuteText', null);
    $this->addOption('separator', null);

    parent::__construct($options, $attributes);
  }

  /**
   * Constructor.
   *
   * Available options:
   *
   *  * type: The widget type
   *
   * @param array $options     An array of options
   *              $options["hourText"]      label of hour text
   *              $options["minuteText"]    label of minute text
   *              $options["timeSeparator"] time separator
   * @param array $attributes  An array of default HTML attributes
   *
   * @see sfWidgetForm
   */
  protected function configure($options = array(), $attributes = array())
  {
    parent::configure($options, $attributes);
  }

  /**
   * Renders the widget.
   *
   * @param  string $name        The element name
   * @param  string $value       The value displayed in this widget
   * @param  array  $attributes  An array of HTML attributes to be merged with the default HTML attributes
   * @param  array  $errors      An array of errors for the field
   *
   * @return string An HTML tag string
   *
   * @see sfWidgetForm
   */
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    // on applique la taille d'une date
    $attributes["maxlength"] = 5;

    $attributes["class"] = isset($attributes["class"]) ? $attributes["class"]." time" : "time";

    $attributes["type"] = "text";

    // on render notre input tag
    $strTextHtml = $this->renderTag('input', array_merge(array('type' => $this->getOption('type'), 'name' => $name, 'value' => $value), $attributes));

    // on rajoute JQuery datepicker
    $strTextHtml .= '
<script type="text/javascript">
  $(document).ready(function() {
    $( "#'.$this->generateId($name).'" ).timepicker({';

    if ($this->getOption("hourText"))
    {
      $strTextHtml .= 'hourText: "'.$this->options["hourText"].'",';
    }
    if ($this->getOption("minuteText") )
    {
      $strTextHtml .= 'minuteText: "'.$this->options["minuteText"].'",';
    }
    if ($this->getOption("timeSeparator") )
    {
      $strTextHtml .= 'timeSeparator: "'.$this->options["timeSeparator"].'",';
    }

    $strTextHtml .= '
      showPeriodLabels: false
    });
  });
</script>
';
    
    return $strTextHtml;
  }
}
