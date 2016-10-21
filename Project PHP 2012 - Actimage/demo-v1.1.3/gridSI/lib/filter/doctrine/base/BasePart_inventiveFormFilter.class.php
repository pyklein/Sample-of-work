<?php

/**
 * Part_inventive filter form base class.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasePart_inventiveFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'inventeur_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Inventeur'), 'add_empty' => true)),
      'dossier_bpi_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_bpi'), 'add_empty' => true)),
      'part_inventive' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'inventeur_id'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Inventeur'), 'column' => 'id')),
      'dossier_bpi_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Dossier_bpi'), 'column' => 'id')),
      'part_inventive' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('part_inventive_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Part_inventive';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'inventeur_id'   => 'ForeignKey',
      'dossier_bpi_id' => 'ForeignKey',
      'part_inventive' => 'Number',
    );
  }
}
