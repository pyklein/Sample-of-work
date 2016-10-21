<?php

/**
 * Commission_intervenant form base class.
 *
 * @method Commission_intervenant getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCommission_intervenantForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'commission_id'  => new sfWidgetFormInputHidden(),
      'intervenant_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'commission_id'  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('commission_id')), 'empty_value' => $this->getObject()->get('commission_id'), 'required' => false)),
      'intervenant_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('intervenant_id')), 'empty_value' => $this->getObject()->get('intervenant_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('commission_intervenant[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Commission_intervenant';
  }

}
