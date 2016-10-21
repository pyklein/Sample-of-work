<?php

/**
 * Classement_invention_inventeur filter form base class.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseClassement_invention_inventeurFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'dossier_bpi_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_bpi'), 'add_empty' => true)),
      'concerne_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Concerne'), 'add_empty' => true)),
      'classement_autorite_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Classement_autorite'), 'add_empty' => true)),
      'classement_hierarchie_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Classement_hierarchie'), 'add_empty' => true)),
      'classement_propose_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Classement_propose'), 'add_empty' => true)),
      'classement_final_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Classement_final'), 'add_empty' => true)),
      'created_at'               => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'               => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'created_by'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'dossier_bpi_id'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Dossier_bpi'), 'column' => 'id')),
      'concerne_id'              => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Concerne'), 'column' => 'id')),
      'classement_autorite_id'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Classement_autorite'), 'column' => 'id')),
      'classement_hierarchie_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Classement_hierarchie'), 'column' => 'id')),
      'classement_propose_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Classement_propose'), 'column' => 'id')),
      'classement_final_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Classement_final'), 'column' => 'id')),
      'created_at'               => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'               => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'created_by'               => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'column' => 'id')),
      'updated_by'               => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('classement_invention_inventeur_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Classement_invention_inventeur';
  }

  public function getFields()
  {
    return array(
      'id'                       => 'Number',
      'dossier_bpi_id'           => 'ForeignKey',
      'concerne_id'              => 'ForeignKey',
      'classement_autorite_id'   => 'ForeignKey',
      'classement_hierarchie_id' => 'ForeignKey',
      'classement_propose_id'    => 'ForeignKey',
      'classement_final_id'      => 'ForeignKey',
      'created_at'               => 'Date',
      'updated_at'               => 'Date',
      'created_by'               => 'ForeignKey',
      'updated_by'               => 'ForeignKey',
    );
  }
}
