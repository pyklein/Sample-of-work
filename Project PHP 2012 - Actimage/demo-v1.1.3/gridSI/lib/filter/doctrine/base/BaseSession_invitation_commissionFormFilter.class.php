<?php

/**
 * Session_invitation_commission filter form base class.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseSession_invitation_commissionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'invitation_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Invitation'), 'add_empty' => true)),
      'service_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Service'), 'add_empty' => true)),
      'laboratoire_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Laboratoire'), 'add_empty' => true)),
      'transaction_token' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'est_concerne'      => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'invitation_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Invitation'), 'column' => 'id')),
      'service_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Service'), 'column' => 'id')),
      'laboratoire_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Laboratoire'), 'column' => 'id')),
      'transaction_token' => new sfValidatorPass(array('required' => false)),
      'est_concerne'      => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('session_invitation_commission_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Session_invitation_commission';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'invitation_id'     => 'ForeignKey',
      'service_id'        => 'ForeignKey',
      'laboratoire_id'    => 'ForeignKey',
      'transaction_token' => 'Text',
      'est_concerne'      => 'Boolean',
    );
  }
}
