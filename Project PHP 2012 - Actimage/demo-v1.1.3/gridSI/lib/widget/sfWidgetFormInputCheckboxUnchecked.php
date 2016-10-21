<?php

/**
 * sfWidgetFormInputCheckbox avec la case unchecked par défaut
 *
 * @author Alexandre WETTA
 */
class sfWidgetFormInputCheckboxUnchecked extends sfWidgetFormInputCheckbox {

  /**
   * Override render method due to symfony bug 
   */
  public function render($name, $value = null, $attributes = array(), $errors = array()) {
    if (!is_null($value) && $value !== false && $value != 0) {
      $attributes['checked'] = 'checked';
    }

    if (!isset($attributes['value']) && !is_null($this->getOption('value_attribute_value'))) {
      $attributes['value'] = $this->getOption('value_attribute_value');
    }

    return parent::render($name, null, $attributes, $errors);
  }

}
?>
