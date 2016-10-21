<?php

/**
 * Evaluation filter form base class.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseEvaluationFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'note_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Note'), 'add_empty' => true)),
      'valeur_note_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Valeur_note'), 'add_empty' => true)),
      'est_preselection'   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'est_globale'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'est_actif'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'est_finale'         => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'invitation_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Invitation'), 'add_empty' => true)),
      'dossier_these_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_these'), 'add_empty' => true)),
      'dossier_ere_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_ere'), 'add_empty' => true)),
      'dossier_postdoc_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_postdoc'), 'add_empty' => true)),
      'created_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'created_by'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'note_id'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Note'), 'column' => 'id')),
      'valeur_note_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Valeur_note'), 'column' => 'id')),
      'est_preselection'   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'est_globale'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'est_actif'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'est_finale'         => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'invitation_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Invitation'), 'column' => 'id')),
      'dossier_these_id'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Dossier_these'), 'column' => 'id')),
      'dossier_ere_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Dossier_ere'), 'column' => 'id')),
      'dossier_postdoc_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Dossier_postdoc'), 'column' => 'id')),
      'created_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'created_by'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'column' => 'id')),
      'updated_by'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('evaluation_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Evaluation';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'note_id'            => 'ForeignKey',
      'valeur_note_id'     => 'ForeignKey',
      'est_preselection'   => 'Boolean',
      'est_globale'        => 'Boolean',
      'est_actif'          => 'Boolean',
      'est_finale'         => 'Boolean',
      'invitation_id'      => 'ForeignKey',
      'dossier_these_id'   => 'ForeignKey',
      'dossier_ere_id'     => 'ForeignKey',
      'dossier_postdoc_id' => 'ForeignKey',
      'created_at'         => 'Date',
      'updated_at'         => 'Date',
      'created_by'         => 'ForeignKey',
      'updated_by'         => 'ForeignKey',
    );
  }
}
