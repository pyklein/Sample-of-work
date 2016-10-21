<?php

/**
 * Invitation form base class.
 *
 * @method Invitation getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseInvitationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'commission_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Commission'), 'add_empty' => true)),
      'service_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Service'), 'add_empty' => true)),
      'laboratoire_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Laboratoire'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'commission_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Commission'), 'required' => false)),
      'service_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Service'), 'required' => false)),
      'laboratoire_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Laboratoire'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('invitation[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Invitation';
  }

}
