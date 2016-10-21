<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of gridValidatorSchemaEtudiant
 *
 * @author William
 */
class gridValidatorSchemaEtudiant extends gridValidatorSchema{
    public function configure($options = array(), $messages = array()){

    $this['civilite_id'] = new sfValidatorInteger(array('required' => true));
    $this['nom'] = new sfValidatorString(array('required' => true));
    $this['prenom'] = new sfValidatorString(array('required' => true));
    $this['email'] = new sfValidatorEmail(array('required' => true));
    $this['adresse'] = new sfValidatorString(array('required' => false));
    $this['adresse2'] = new sfValidatorString(array('required' => false));
    $this['adresse3'] = new sfValidatorString(array('required' => false));
    $this['code_postal'] = new gridValidatorCodePostal(array('required' => false));
    $this['email'] = new sfValidatorEmail(array('required' => false));
    $this['type_cursus_id'] = new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'Type_cursus'));
    $this['a_master'] = new sfValidatorBoolean(array('required' => false));

    parent::configure();
  }
}
?>
