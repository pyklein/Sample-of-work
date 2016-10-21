<?php

/**
 * Dossier_mip filter form base class.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseDossier_mipFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'numero'                => new sfWidgetFormFilterInput(),
      'titre'                 => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'acronyme'              => new sfWidgetFormFilterInput(),
      'descriptif'            => new sfWidgetFormFilterInput(),
      'etat_partage_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Etat_partage'), 'add_empty' => true)),
      'est_publie'            => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'dossier_vivant'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'photographie'          => new sfWidgetFormFilterInput(),
      'photographie_orig'     => new sfWidgetFormFilterInput(),
      'repertoire_partage'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'statut_dossier_mip_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Statut_dossier_mip'), 'add_empty' => true)),
      'niveau_protection_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Niveau_protection'), 'add_empty' => true)),
      'pilote_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Pilote'), 'add_empty' => true)),
      'organisme_mindef_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme_mindef'), 'add_empty' => true)),
      'statut_projet_mip_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Statut_projet_mip'), 'add_empty' => true)),
      'est_actif'             => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'necessite_controle'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'date_bascule'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'created_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'created_by'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
      'dossiers_bpi_list'     => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Dossier_bpi')),
      'innovateurs_list'      => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Utilisateur')),
    ));

    $this->setValidators(array(
      'numero'                => new sfValidatorPass(array('required' => false)),
      'titre'                 => new sfValidatorPass(array('required' => false)),
      'acronyme'              => new sfValidatorPass(array('required' => false)),
      'descriptif'            => new sfValidatorPass(array('required' => false)),
      'etat_partage_id'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Etat_partage'), 'column' => 'id')),
      'est_publie'            => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'dossier_vivant'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'photographie'          => new sfValidatorPass(array('required' => false)),
      'photographie_orig'     => new sfValidatorPass(array('required' => false)),
      'repertoire_partage'    => new sfValidatorPass(array('required' => false)),
      'statut_dossier_mip_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Statut_dossier_mip'), 'column' => 'id')),
      'niveau_protection_id'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Niveau_protection'), 'column' => 'id')),
      'pilote_id'             => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Pilote'), 'column' => 'id')),
      'organisme_mindef_id'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Organisme_mindef'), 'column' => 'id')),
      'statut_projet_mip_id'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Statut_projet_mip'), 'column' => 'id')),
      'est_actif'             => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'necessite_controle'    => new sfValidatorPass(array('required' => false)),
      'date_bascule'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'created_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'created_by'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'column' => 'id')),
      'updated_by'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'column' => 'id')),
      'dossiers_bpi_list'     => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Dossier_bpi', 'required' => false)),
      'innovateurs_list'      => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Utilisateur', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('dossier_mip_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addDossiersBPIListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.Dossier_mip_dossier_bpi Dossier_mip_dossier_bpi')
      ->andWhereIn('Dossier_mip_dossier_bpi.dossier_mip_id', $values)
    ;
  }

  public function addInnovateursListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.Innovateur_dossier_mip Innovateur_dossier_mip')
      ->andWhereIn('Innovateur_dossier_mip.utilisateur_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Dossier_mip';
  }

  public function getFields()
  {
    return array(
      'id'                    => 'Number',
      'numero'                => 'Text',
      'titre'                 => 'Text',
      'acronyme'              => 'Text',
      'descriptif'            => 'Text',
      'etat_partage_id'       => 'ForeignKey',
      'est_publie'            => 'Boolean',
      'dossier_vivant'        => 'Boolean',
      'photographie'          => 'Text',
      'photographie_orig'     => 'Text',
      'repertoire_partage'    => 'Text',
      'statut_dossier_mip_id' => 'ForeignKey',
      'niveau_protection_id'  => 'ForeignKey',
      'pilote_id'             => 'ForeignKey',
      'organisme_mindef_id'   => 'ForeignKey',
      'statut_projet_mip_id'  => 'ForeignKey',
      'est_actif'             => 'Boolean',
      'necessite_controle'    => 'Text',
      'date_bascule'          => 'Date',
      'created_at'            => 'Date',
      'updated_at'            => 'Date',
      'created_by'            => 'ForeignKey',
      'updated_by'            => 'ForeignKey',
      'dossiers_bpi_list'     => 'ManyKey',
      'innovateurs_list'      => 'ManyKey',
    );
  }
}
