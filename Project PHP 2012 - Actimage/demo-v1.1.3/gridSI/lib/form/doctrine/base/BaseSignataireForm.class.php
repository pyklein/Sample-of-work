<?php

/**
 * Signataire form base class.
 *
 * @method Signataire getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseSignataireForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'contrat_id'   => new sfWidgetFormInputHidden(),
      'organisme_id' => new sfWidgetFormInputHidden(),
      'service_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Service'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'contrat_id'   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('contrat_id')), 'empty_value' => $this->getObject()->get('contrat_id'), 'required' => false)),
      'organisme_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('organisme_id')), 'empty_value' => $this->getObject()->get('organisme_id'), 'required' => false)),
      'service_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Service'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('signataire[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Signataire';
  }

}
