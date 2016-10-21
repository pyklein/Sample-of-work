<?php

/**
 * Session_situation_inventeurs filter form base class.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseSession_situation_inventeursFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'inventeur_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Inventeur'), 'add_empty' => true)),
      'transaction_token' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'part_inventive'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'inventeur_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Inventeur'), 'column' => 'id')),
      'transaction_token' => new sfValidatorPass(array('required' => false)),
      'part_inventive'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('session_situation_inventeurs_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Session_situation_inventeurs';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'inventeur_id'      => 'ForeignKey',
      'transaction_token' => 'Text',
      'part_inventive'    => 'Number',
    );
  }
}
