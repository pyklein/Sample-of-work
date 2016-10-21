<?php

/**
 * Session_encadrants_dossier_ere filter form base class.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseSession_encadrants_dossier_ereFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'dossier_ere_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DossierEre'), 'add_empty' => true)),
      'intervenant_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Intervenant'), 'add_empty' => true)),
      'role_ere_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('RoleEre'), 'add_empty' => true)),
      'transaction_token' => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'dossier_ere_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('DossierEre'), 'column' => 'id')),
      'intervenant_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Intervenant'), 'column' => 'id')),
      'role_ere_id'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('RoleEre'), 'column' => 'id')),
      'transaction_token' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('session_encadrants_dossier_ere_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Session_encadrants_dossier_ere';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'dossier_ere_id'    => 'ForeignKey',
      'intervenant_id'    => 'ForeignKey',
      'role_ere_id'       => 'ForeignKey',
      'transaction_token' => 'Text',
    );
  }
}
