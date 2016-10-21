<?php

/**
 * Avis_mris filter form base class.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseAvis_mrisFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'date_avis'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'date_envoi_lettre'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'est_satisfaisant'      => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'dossier_these_id'      => new sfWidgetFormFilterInput(),
      'dossier_ere_id'        => new sfWidgetFormFilterInput(),
      'dossier_postdoc_id'    => new sfWidgetFormFilterInput(),
      'created_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'created_by'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
      'dossier_theses_list'   => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Dossier_these')),
      'dossier_eres_list'     => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Dossier_ere')),
      'dossier_postdocs_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Dossier_postdoc')),
    ));

    $this->setValidators(array(
      'date_avis'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'date_envoi_lettre'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'est_satisfaisant'      => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'dossier_these_id'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'dossier_ere_id'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'dossier_postdoc_id'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'created_by'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'column' => 'id')),
      'updated_by'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'column' => 'id')),
      'dossier_theses_list'   => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Dossier_these', 'required' => false)),
      'dossier_eres_list'     => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Dossier_ere', 'required' => false)),
      'dossier_postdocs_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Dossier_postdoc', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('avis_mris_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addDossierThesesListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.Avis_mris_dossier_these Avis_mris_dossier_these')
      ->andWhereIn('Avis_mris_dossier_these.dossier_these_id', $values)
    ;
  }

  public function addDossierEresListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.Avis_mris_dossier_ere Avis_mris_dossier_ere')
      ->andWhereIn('Avis_mris_dossier_ere.dossier_ere_id', $values)
    ;
  }

  public function addDossierPostdocsListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.Avis_mris_dossier_postdoc Avis_mris_dossier_postdoc')
      ->andWhereIn('Avis_mris_dossier_postdoc.dossier_postdoc_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Avis_mris';
  }

  public function getFields()
  {
    return array(
      'id'                    => 'Number',
      'date_avis'             => 'Date',
      'date_envoi_lettre'     => 'Date',
      'est_satisfaisant'      => 'Boolean',
      'dossier_these_id'      => 'Number',
      'dossier_ere_id'        => 'Number',
      'dossier_postdoc_id'    => 'Number',
      'created_at'            => 'Date',
      'updated_at'            => 'Date',
      'created_by'            => 'ForeignKey',
      'updated_by'            => 'ForeignKey',
      'dossier_theses_list'   => 'ManyKey',
      'dossier_eres_list'     => 'ManyKey',
      'dossier_postdocs_list' => 'ManyKey',
    );
  }
}
