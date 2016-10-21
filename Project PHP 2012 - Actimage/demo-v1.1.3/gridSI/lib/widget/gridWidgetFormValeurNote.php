<?php

/**
 * Widget valeur note
 * @author Gabor JAGER
 */
class gridWidgetFormValeurNote extends sfWidgetFormDoctrineChoice
{

  /**
   * Constructeur
   * @param array $options
   * @param array $attributes
   */
  public function __construct($options = array(), $attributes = array()) {

    $options["model"]     = isset($options["model"]) ? $options["model"] : 'Valeur_note';
    $options["method"]    = isset($options["method"]) ? $options["method"] : 'getIntitule';
    $options["add_empty"] = isset($options["add_empty"]) ? $options["add_empty"] : '-';
    
    $attributes["class"]  = isset($attributes["class"]) ? $attributes["class"]." note" : "note";

    parent::__construct($options, $attributes);
  }
}
