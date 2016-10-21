<?php

/**
 * Laboratoire filter form base class.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseLaboratoireFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'intitule'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'intitule_ancien'       => new sfWidgetFormFilterInput(),
      'abreviation'           => new sfWidgetFormFilterInput(),
      'evaluation_aers'       => new sfWidgetFormFilterInput(),
      'est_actif'             => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'service_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Service'), 'add_empty' => true)),
      'organisme_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme'), 'add_empty' => true)),
      'created_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'created_by'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
      'dossiers_these_list'   => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Dossier_these')),
      'dossiers_ere_list'     => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Dossier_ere')),
      'dossiers_postdoc_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Dossier_postdoc')),
    ));

    $this->setValidators(array(
      'intitule'              => new sfValidatorPass(array('required' => false)),
      'intitule_ancien'       => new sfValidatorPass(array('required' => false)),
      'abreviation'           => new sfValidatorPass(array('required' => false)),
      'evaluation_aers'       => new sfValidatorPass(array('required' => false)),
      'est_actif'             => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'service_id'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Service'), 'column' => 'id')),
      'organisme_id'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Organisme'), 'column' => 'id')),
      'created_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'created_by'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'column' => 'id')),
      'updated_by'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'column' => 'id')),
      'dossiers_these_list'   => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Dossier_these', 'required' => false)),
      'dossiers_ere_list'     => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Dossier_ere', 'required' => false)),
      'dossiers_postdoc_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Dossier_postdoc', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('laboratoire_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addDossiersTheseListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.Dossier_these_laboratoire Dossier_these_laboratoire')
      ->andWhereIn('Dossier_these_laboratoire.dossier_these_id', $values)
    ;
  }

  public function addDossiersEreListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.Dossier_ere_laboratoire Dossier_ere_laboratoire')
      ->andWhereIn('Dossier_ere_laboratoire.dossier_ere_id', $values)
    ;
  }

  public function addDossiersPostdocListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.Dossier_postdoc_laboratoire Dossier_postdoc_laboratoire')
      ->andWhereIn('Dossier_postdoc_laboratoire.dossier_postdoc_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Laboratoire';
  }

  public function getFields()
  {
    return array(
      'id'                    => 'Number',
      'intitule'              => 'Text',
      'intitule_ancien'       => 'Text',
      'abreviation'           => 'Text',
      'evaluation_aers'       => 'Text',
      'est_actif'             => 'Boolean',
      'service_id'            => 'ForeignKey',
      'organisme_id'          => 'ForeignKey',
      'created_at'            => 'Date',
      'updated_at'            => 'Date',
      'created_by'            => 'ForeignKey',
      'updated_by'            => 'ForeignKey',
      'dossiers_these_list'   => 'ManyKey',
      'dossiers_ere_list'     => 'ManyKey',
      'dossiers_postdoc_list' => 'ManyKey',
    );
  }
}
