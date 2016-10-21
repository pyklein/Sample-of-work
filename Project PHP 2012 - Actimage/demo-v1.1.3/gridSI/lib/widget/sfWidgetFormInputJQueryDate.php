<?php

if (sfContext::hasInstance())
{
  sfContext::getInstance()->getConfiguration()->loadHelpers("Format");
  sfContext::getInstance()->getResponse()->addJavaScript("jquery/jquery-ui-1.8.10.custom.min.js", 'last');
  sfContext::getInstance()->getResponse()->addJavaScript("jquery/jquery.ui.datepicker-fr.js", 'last');
}

/**
 * JQuery date widget
 * @author Gabor JAGER
 */
class sfWidgetFormInputJQueryDate extends sfWidgetFormDate {

  /**
   * Constructor.
   *
   * Available options:
   *
   *  * type: The widget type
   *
   * @param array $options     An array of options
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
    $attributes["maxlength"] = 10;

    $attributes["class"] = isset($attributes["class"]) ? $attributes["class"]." date" : "date";

    $attributes["type"] = "text";

    // on render notre input tag
    if($value == null){
      $dateFormatee = "";
    } else{
      $dateFormatee = formatDate($value) != '01/01/1970' ? formatDate($value) : $value;
    }
    $strTextHtml = $this->renderTag('input', array_merge(array('type' => $this->getOption('type'), 'name' => $name, 'value' => $dateFormatee), $attributes));

    // on rajoute JQuery datepicker
    $strTextHtml .= '
<script type="text/javascript">
  $(document).ready(function() {
    $( "#'.$this->generateId($name).'" ).datepicker();
  });
</script>
';
    
    return $strTextHtml;
  }
}
