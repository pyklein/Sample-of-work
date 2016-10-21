<?php

/**
 * Description of sfWidgetFormChoiceBooleanRadio
 *  Widget affichant plusieurs radio buttons en une ligne (utilise une classe css)
 * @author William
 */
class gridWidgetFormChoiceRadioAligne extends sfWidgetFormChoice{
  public function  __construct($options = array(), $attributes = array()) {
    if (!array_key_exists('expanded', $options)){
      $options['expanded'] = true;
    }
    if (!array_key_exists('renderer_options', $options)){
      $options['renderer_options'] = array('class' => 'radio_liste_horizontale');
    }
    
    parent::__construct($options, $attributes);
  }

}
?>
