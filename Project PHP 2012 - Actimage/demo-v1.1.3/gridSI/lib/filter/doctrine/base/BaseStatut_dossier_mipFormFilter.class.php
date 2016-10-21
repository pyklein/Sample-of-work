<?php

/**
 * Statut_dossier_mip filter form base class.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseStatut_dossier_mipFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'intitule'                        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'abreviation'                     => new sfWidgetFormFilterInput(),
      'precedent_statut_dossier_mip_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Precedent'), 'add_empty' => true)),
      'est_actif'                       => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'                      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'                      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'created_by'                      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'                      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'intitule'                        => new sfValidatorPass(array('required' => false)),
      'abreviation'                     => new sfValidatorPass(array('required' => false)),
      'precedent_statut_dossier_mip_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Precedent'), 'column' => 'id')),
      'est_actif'                       => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'                      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'                      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'created_by'                      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'column' => 'id')),
      'updated_by'                      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('statut_dossier_mip_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Statut_dossier_mip';
  }

  public function getFields()
  {
    return array(
      'id'                              => 'Number',
      'intitule'                        => 'Text',
      'abreviation'                     => 'Text',
      'precedent_statut_dossier_mip_id' => 'ForeignKey',
      'est_actif'                       => 'Boolean',
      'created_at'                      => 'Date',
      'updated_at'                      => 'Date',
      'created_by'                      => 'ForeignKey',
      'updated_by'                      => 'ForeignKey',
    );
  }
}
