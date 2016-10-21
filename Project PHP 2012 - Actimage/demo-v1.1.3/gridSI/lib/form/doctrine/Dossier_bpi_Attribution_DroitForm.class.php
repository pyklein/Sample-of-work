<?php

/**
 *
 * @author Jihad
 */
class Dossier_bpi_Attribution_DroitForm extends BaseDossier_bpiForm
{

  public $arrClassement;

  public function __construct($arrClassement,$object = null, $options = array(), $CSRFSecret = null) {
    $this->arrClassement = $arrClassement;
    parent::__construct($object, $options, $CSRFSecret);
  }
  
  public function  configure() {

    $this->useFields(array());
    $this->embedRelation('Attribution_droit','Attribution_droitForm',array(null,null,$this->arrClassement));

    $this->widgetSchema->setNameFormat('dossier_bpi_attribution_droit_forms[%s]');
    parent::configure();
  }
}
?>
