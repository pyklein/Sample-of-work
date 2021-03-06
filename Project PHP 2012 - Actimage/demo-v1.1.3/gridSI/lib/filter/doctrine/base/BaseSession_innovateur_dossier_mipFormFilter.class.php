<?php

/**
 * Session_innovateur_dossier_mip filter form base class.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseSession_innovateur_dossier_mipFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'innovateur_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Innovateur'), 'add_empty' => true)),
      'transaction_token' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'nouveau_type_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Type_innovateur'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'innovateur_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Innovateur'), 'column' => 'id')),
      'transaction_token' => new sfValidatorPass(array('required' => false)),
      'nouveau_type_id'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Type_innovateur'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('session_innovateur_dossier_mip_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Session_innovateur_dossier_mip';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'innovateur_id'     => 'ForeignKey',
      'transaction_token' => 'Text',
      'nouveau_type_id'   => 'ForeignKey',
    );
  }
}
