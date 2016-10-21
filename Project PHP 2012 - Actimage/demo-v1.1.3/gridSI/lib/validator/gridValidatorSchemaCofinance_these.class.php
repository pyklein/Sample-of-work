<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of gridValidatorSchemaCofinance_these
 *
 * @author William
 */
class gridValidatorSchemaCofinance_these extends gridValidatorSchema{
    public function configure($options = array(), $messages = array()){

    $this['part_cofinance'] = new sfValidatorInteger(array('required' => true,'min' => 0, 'max' => 100));

    parent::configure();
    }
}
?>
