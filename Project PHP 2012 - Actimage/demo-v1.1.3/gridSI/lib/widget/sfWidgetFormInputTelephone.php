<?php

/**
 * Input télephone
 * @author Gabor JAGER
 */
class sfWidgetFormInputTelephone extends sfWidgetFormInput {

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
    // on applique la taille d'un numero de téléphone
    $attributes["maxlength"] = 20;

    $attributes["class"] = isset($attributes["class"]) ? $attributes["class"]." phone" : "phone";

    return $this->renderTag('input', array_merge(array('type' => $this->getOption('type'), 'name' => $name, 'value' => $value), $attributes));
  }
}
