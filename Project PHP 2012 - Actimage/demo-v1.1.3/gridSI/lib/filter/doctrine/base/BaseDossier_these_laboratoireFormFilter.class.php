<?php

/**
 * Dossier_these_laboratoire filter form base class.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseDossier_these_laboratoireFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'dossier_these_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_these'), 'add_empty' => true)),
      'laboratoire_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Laboratoire'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'dossier_these_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Dossier_these'), 'column' => 'id')),
      'laboratoire_id'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Laboratoire'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('dossier_these_laboratoire_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Dossier_these_laboratoire';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'dossier_these_id' => 'ForeignKey',
      'laboratoire_id'   => 'ForeignKey',
    );
  }
}
