<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of gridWidgetClassementChoice
 *
 * @author William
 */
class gridWidgetClassementChoice extends sfWidgetFormDoctrineChoice{

  public function  __construct($options = array(), $attributes = array()) {
    $options['model'] = 'Classement';
    $options['add_empty'] = false;
    parent::__construct($options, $attributes);
  }
}
?>
