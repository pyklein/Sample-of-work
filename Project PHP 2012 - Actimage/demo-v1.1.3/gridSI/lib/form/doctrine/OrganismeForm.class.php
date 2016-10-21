<?php

/**
 * Organisme form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class OrganismeForm extends BaseOrganismeForm {

  private $boolPopup;

  public function  __construct($boolPopup = null, $object = null, $options = array(), $CSRFSecret = null)
  {
    $this->boolPopup = $boolPopup;
    parent::__construct($object, $options, $CSRFSecret);
  }

  public function configure() {
    $this->useFields(array(
        'intitule', 'intitule_ancien', 'abreviation', 'type_organisme_id'));

    if ($this->getObject()->getTypeOrganismeId() != false) {
      $this->widgetSchema['type_organisme_id'] = new sfWidgetFormReadOnly(array('content' => array('model' => 'Type_organisme')));
    } else {
      $this->widgetSchema['type_organisme_id'] = new sfWidgetFormDoctrineChoiceParametered(array(
                  'model' => $this->getRelatedModelName('Type_organisme'),
                  'add_empty' => false,
                  'order_by' => array('intitule', 'asc')));
    }

    $this->widgetSchema->setLabels(array(
        'intitule' => libelle('msg_organisme_libelle_intitule'),
        'abreviation' => libelle('msg_organisme_libelle_abreviation'),
        'type_organisme_id' => libelle('msg_organisme_libelle_type_org'),
        'intitule_ancien' => libelle('msg_organisme_libelle_intitule_ancien')));


    $this->validatorSchema['type_organisme_id'] = new sfValidatorDoctrineChoice(
                    array('required' => 'true', 'model' => $this->getRelatedModelName('Type_organisme')),
                    array('required' => libelle('msg_organisme_type_organisme_requis')));

    $this->validatorSchema['intitule'] = new sfValidatorString(array('required' => 'true'),
                    array('required' => libelle('msg_referentiel_intitule_requis')));

    if($this->boolPopup === true)
    {
      unset($this['intitule_ancien']);
    }

    $this->disableCSRFProtection();
    parent::configure();
  }

}
