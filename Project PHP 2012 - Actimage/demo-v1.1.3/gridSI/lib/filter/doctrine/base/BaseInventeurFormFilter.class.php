<?php

/**
 * Inventeur filter form base class.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseInventeurFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'civilite_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Civilite'), 'add_empty' => true)),
      'nom'                      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'prenom'                   => new sfWidgetFormFilterInput(),
      'date_naissance'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'date_deces'               => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'date_retraite'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'email'                    => new sfWidgetFormFilterInput(),
      'email2'                   => new sfWidgetFormFilterInput(),
      'telephone_fixe'           => new sfWidgetFormFilterInput(),
      'telephone_mobile'         => new sfWidgetFormFilterInput(),
      'telephone_autre'          => new sfWidgetFormFilterInput(),
      'fax'                      => new sfWidgetFormFilterInput(),
      'email_perso'              => new sfWidgetFormFilterInput(),
      'adresse_perso'            => new sfWidgetFormFilterInput(),
      'adresse_perso2'           => new sfWidgetFormFilterInput(),
      'adresse_perso3'           => new sfWidgetFormFilterInput(),
      'code_postal_perso'        => new sfWidgetFormFilterInput(),
      'complement_adresse_perso' => new sfWidgetFormFilterInput(),
      'ville_id'                 => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Ville'), 'add_empty' => true)),
      'telephone_fixe_perso'     => new sfWidgetFormFilterInput(),
      'telephone_mobile_perso'   => new sfWidgetFormFilterInput(),
      'est_exterieur'            => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'est_actif'                => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'organisme_mindef_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme_mindef'), 'add_empty' => true)),
      'entite_id'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Entite'), 'add_empty' => true)),
      'grade_id'                 => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Grade'), 'add_empty' => true)),
      'organisme_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme'), 'add_empty' => true)),
      'service_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Service'), 'add_empty' => true)),
      'created_at'               => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'               => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'created_by'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
      'dossier_bpis_list'        => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Dossier_bpi')),
    ));

    $this->setValidators(array(
      'civilite_id'              => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Civilite'), 'column' => 'id')),
      'nom'                      => new sfValidatorPass(array('required' => false)),
      'prenom'                   => new sfValidatorPass(array('required' => false)),
      'date_naissance'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'date_deces'               => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'date_retraite'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'email'                    => new sfValidatorPass(array('required' => false)),
      'email2'                   => new sfValidatorPass(array('required' => false)),
      'telephone_fixe'           => new sfValidatorPass(array('required' => false)),
      'telephone_mobile'         => new sfValidatorPass(array('required' => false)),
      'telephone_autre'          => new sfValidatorPass(array('required' => false)),
      'fax'                      => new sfValidatorPass(array('required' => false)),
      'email_perso'              => new sfValidatorPass(array('required' => false)),
      'adresse_perso'            => new sfValidatorPass(array('required' => false)),
      'adresse_perso2'           => new sfValidatorPass(array('required' => false)),
      'adresse_perso3'           => new sfValidatorPass(array('required' => false)),
      'code_postal_perso'        => new sfValidatorPass(array('required' => false)),
      'complement_adresse_perso' => new sfValidatorPass(array('required' => false)),
      'ville_id'                 => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Ville'), 'column' => 'id')),
      'telephone_fixe_perso'     => new sfValidatorPass(array('required' => false)),
      'telephone_mobile_perso'   => new sfValidatorPass(array('required' => false)),
      'est_exterieur'            => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'est_actif'                => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'organisme_mindef_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Organisme_mindef'), 'column' => 'id')),
      'entite_id'                => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Entite'), 'column' => 'id')),
      'grade_id'                 => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Grade'), 'column' => 'id')),
      'organisme_id'             => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Organisme'), 'column' => 'id')),
      'service_id'               => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Service'), 'column' => 'id')),
      'created_at'               => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'               => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'created_by'               => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'column' => 'id')),
      'updated_by'               => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'column' => 'id')),
      'dossier_bpis_list'        => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Dossier_bpi', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('inventeur_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addDossierBpisListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.Part_inventive Part_inventive')
      ->andWhereIn('Part_inventive.dossier_bpi_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Inventeur';
  }

  public function getFields()
  {
    return array(
      'id'                       => 'Number',
      'civilite_id'              => 'ForeignKey',
      'nom'                      => 'Text',
      'prenom'                   => 'Text',
      'date_naissance'           => 'Date',
      'date_deces'               => 'Date',
      'date_retraite'            => 'Date',
      'email'                    => 'Text',
      'email2'                   => 'Text',
      'telephone_fixe'           => 'Text',
      'telephone_mobile'         => 'Text',
      'telephone_autre'          => 'Text',
      'fax'                      => 'Text',
      'email_perso'              => 'Text',
      'adresse_perso'            => 'Text',
      'adresse_perso2'           => 'Text',
      'adresse_perso3'           => 'Text',
      'code_postal_perso'        => 'Text',
      'complement_adresse_perso' => 'Text',
      'ville_id'                 => 'ForeignKey',
      'telephone_fixe_perso'     => 'Text',
      'telephone_mobile_perso'   => 'Text',
      'est_exterieur'            => 'Boolean',
      'est_actif'                => 'Boolean',
      'organisme_mindef_id'      => 'ForeignKey',
      'entite_id'                => 'ForeignKey',
      'grade_id'                 => 'ForeignKey',
      'organisme_id'             => 'ForeignKey',
      'service_id'               => 'ForeignKey',
      'created_at'               => 'Date',
      'updated_at'               => 'Date',
      'created_by'               => 'ForeignKey',
      'updated_by'               => 'ForeignKey',
      'dossier_bpis_list'        => 'ManyKey',
    );
  }
}
