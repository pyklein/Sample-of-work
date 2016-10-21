<?php

/**
 * Session_valorisation_externe filter form base class.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseSession_valorisation_externeFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'contrat_id'                     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Contrat'), 'add_empty' => true)),
      'organisme_id'                   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme'), 'add_empty' => true)),
      'statut_valorisation_externe_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('StatutValorisationExterne'), 'add_empty' => true)),
      'transaction_token'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'contrat_id'                     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Contrat'), 'column' => 'id')),
      'organisme_id'                   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Organisme'), 'column' => 'id')),
      'statut_valorisation_externe_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('StatutValorisationExterne'), 'column' => 'id')),
      'transaction_token'              => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('session_valorisation_externe_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Session_valorisation_externe';
  }

  public function getFields()
  {
    return array(
      'id'                             => 'Number',
      'contrat_id'                     => 'ForeignKey',
      'organisme_id'                   => 'ForeignKey',
      'statut_valorisation_externe_id' => 'ForeignKey',
      'transaction_token'              => 'Text',
    );
  }
}
