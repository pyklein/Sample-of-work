<?php

/**
 * Session_invitation_commission form base class.
 *
 * @method Session_invitation_commission getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseSession_invitation_commissionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'invitation_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Invitation'), 'add_empty' => true)),
      'service_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Service'), 'add_empty' => true)),
      'laboratoire_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Laboratoire'), 'add_empty' => true)),
      'transaction_token' => new sfWidgetFormInputText(),
      'est_concerne'      => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'invitation_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Invitation'), 'required' => false)),
      'service_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Service'), 'required' => false)),
      'laboratoire_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Laboratoire'), 'required' => false)),
      'transaction_token' => new sfValidatorString(array('max_length' => 20)),
      'est_concerne'      => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('session_invitation_commission[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Session_invitation_commission';
  }

}
