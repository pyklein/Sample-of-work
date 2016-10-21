<?php
/**
 * Description of gridValidatorSchemaPoint_contact
 *
 * @author William
 */
class gridValidatorSchemaPoint_contact extends gridValidatorSchema{
  
   public function configure($options = array(), $messages = array()){

    $this['telephone'] = new gridValidatorTelephone(array('required' => false));
    $this['adresse'] = new sfValidatorString(array('required' => false));
    $this['adresse2'] = new sfValidatorString(array('required' => false));
    $this['adresse3'] = new sfValidatorString(array('required' => false));
    $this['code_postal'] = new gridValidatorCodePostal(array('required' => false));
    $this['email'] = new sfValidatorEmail(array('required' => false));

    $this->setPostValidator(new sfValidatorCallback(array('callback' => array($this,  'trouveUneInfo'))));

    parent::configure();
  }

  public function trouveUneInfo($validator, $values){
    if ($values['telephone'] == ''  && $values['adresse'] == ''  && $values['email'] == ''){
      throw new sfValidatorError($validator,'aucune_info');
    }
  }
}
?>
