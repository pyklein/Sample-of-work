<?php

/**
 * Commission filter form base class.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseCommissionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'ordre_jour'           => new sfWidgetFormFilterInput(),
      'est_selection'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'est_suivi'            => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'est_analyse'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'date_debut'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'date_fin'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'est_actif'            => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'type_dossier_mris_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Type_dossier_mris'), 'add_empty' => true)),
      'created_at'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'created_by'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
      'utilisateurs_list'    => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Utilisateur')),
      'intervenants_list'    => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Intervenant')),
    ));

    $this->setValidators(array(
      'ordre_jour'           => new sfValidatorPass(array('required' => false)),
      'est_selection'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'est_suivi'            => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'est_analyse'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'date_debut'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'date_fin'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'est_actif'            => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'type_dossier_mris_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Type_dossier_mris'), 'column' => 'id')),
      'created_at'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'created_by'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'column' => 'id')),
      'updated_by'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'column' => 'id')),
      'utilisateurs_list'    => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Utilisateur', 'required' => false)),
      'intervenants_list'    => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Intervenant', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('commission_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addUtilisateursListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.Commission_utilisateur Commission_utilisateur')
      ->andWhereIn('Commission_utilisateur.commission_id', $values)
    ;
  }

  public function addIntervenantsListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.Commission_intervenant Commission_intervenant')
      ->andWhereIn('Commission_intervenant.commission_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Commission';
  }

  public function getFields()
  {
    return array(
      'id'                   => 'Number',
      'ordre_jour'           => 'Text',
      'est_selection'        => 'Boolean',
      'est_suivi'            => 'Boolean',
      'est_analyse'          => 'Boolean',
      'date_debut'           => 'Date',
      'date_fin'             => 'Date',
      'est_actif'            => 'Boolean',
      'type_dossier_mris_id' => 'ForeignKey',
      'created_at'           => 'Date',
      'updated_at'           => 'Date',
      'created_by'           => 'ForeignKey',
      'updated_by'           => 'ForeignKey',
      'utilisateurs_list'    => 'ManyKey',
      'intervenants_list'    => 'ManyKey',
    );
  }
}
