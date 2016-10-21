<?php

/**
 * Widget Et/ou
 * @author Gabor JAGER
 */
class gridWidgetFormEtOu extends sfWidgetFormChoice {

  /**
   * Constructeur
   * @param array $options
   * @param array $attributes
   */
  public function __construct($options = array(), $attributes = array()) {
    
    if (!array_key_exists('choices', $options)) {
      $options['choices'] = EnumEtOu::getEnums();
    }
    parent::__construct($options, $attributes);
  }

  public function render($name, $value = null, $attributes = array(), $errors = array()) 
  {
    $attributes["class"] = isset($attributes["class"]) ? $attributes["class"]." etou" : "etou";

    $strRetour = parent::render($name, $value, $attributes, $errors);

    return $strRetour;
  }

}
