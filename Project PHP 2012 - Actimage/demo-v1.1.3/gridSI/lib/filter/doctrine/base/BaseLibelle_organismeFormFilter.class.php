<?php

/**
 * Libelle_organisme filter form base class.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseLibelle_organismeFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'libelle_simple'      => new sfWidgetFormFilterInput(),
      'libelle_liste'       => new sfWidgetFormFilterInput(),
      'metier_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Metier'), 'add_empty' => true)),
      'organisme_mindef_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme_mindef'), 'add_empty' => true)),
      'created_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'libelle_simple'      => new sfValidatorPass(array('required' => false)),
      'libelle_liste'       => new sfValidatorPass(array('required' => false)),
      'metier_id'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Metier'), 'column' => 'id')),
      'organisme_mindef_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Organisme_mindef'), 'column' => 'id')),
      'created_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('libelle_organisme_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Libelle_organisme';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'libelle_simple'      => 'Text',
      'libelle_liste'       => 'Text',
      'metier_id'           => 'ForeignKey',
      'organisme_mindef_id' => 'ForeignKey',
      'created_at'          => 'Date',
      'updated_at'          => 'Date',
    );
  }
}
