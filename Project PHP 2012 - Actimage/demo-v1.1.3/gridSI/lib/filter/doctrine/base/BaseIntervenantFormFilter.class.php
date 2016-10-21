<?php

/**
 * Intervenant filter form base class.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseIntervenantFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'civilite_id'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Civilite'), 'add_empty' => true)),
      'nom'                        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'prenom'                     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'titre'                      => new sfWidgetFormFilterInput(),
      'est_participant_commission' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'est_responsable'            => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'email'                      => new sfWidgetFormFilterInput(),
      'email2'                     => new sfWidgetFormFilterInput(),
      'adresse'                    => new sfWidgetFormFilterInput(),
      'adresse2'                   => new sfWidgetFormFilterInput(),
      'adresse3'                   => new sfWidgetFormFilterInput(),
      'code_postal'                => new sfWidgetFormFilterInput(),
      'complement_adresse'         => new sfWidgetFormFilterInput(),
      'ville_id'                   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Ville'), 'add_empty' => true)),
      'telephone_fixe'             => new sfWidgetFormFilterInput(),
      'telephone_mobile'           => new sfWidgetFormFilterInput(),
      'fax'                        => new sfWidgetFormFilterInput(),
      'est_actif'                  => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'adresse_etrangere'          => new sfWidgetFormFilterInput(),
      'pays_id'                    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Pays'), 'add_empty' => true)),
      'organisme_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme'), 'add_empty' => true)),
      'service_id'                 => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Service'), 'add_empty' => true)),
      'laboratoire_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Laboratoire'), 'add_empty' => true)),
      'created_at'                 => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'                 => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'created_by'                 => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'                 => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
      'commission_list'            => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Commission')),
    ));

    $this->setValidators(array(
      'civilite_id'                => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Civilite'), 'column' => 'id')),
      'nom'                        => new sfValidatorPass(array('required' => false)),
      'prenom'                     => new sfValidatorPass(array('required' => false)),
      'titre'                      => new sfValidatorPass(array('required' => false)),
      'est_participant_commission' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'est_responsable'            => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'email'                      => new sfValidatorPass(array('required' => false)),
      'email2'                     => new sfValidatorPass(array('required' => false)),
      'adresse'                    => new sfValidatorPass(array('required' => false)),
      'adresse2'                   => new sfValidatorPass(array('required' => false)),
      'adresse3'                   => new sfValidatorPass(array('required' => false)),
      'code_postal'                => new sfValidatorPass(array('required' => false)),
      'complement_adresse'         => new sfValidatorPass(array('required' => false)),
      'ville_id'                   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Ville'), 'column' => 'id')),
      'telephone_fixe'             => new sfValidatorPass(array('required' => false)),
      'telephone_mobile'           => new sfValidatorPass(array('required' => false)),
      'fax'                        => new sfValidatorPass(array('required' => false)),
      'est_actif'                  => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'adresse_etrangere'          => new sfValidatorPass(array('required' => false)),
      'pays_id'                    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Pays'), 'column' => 'id')),
      'organisme_id'               => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Organisme'), 'column' => 'id')),
      'service_id'                 => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Service'), 'column' => 'id')),
      'laboratoire_id'             => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Laboratoire'), 'column' => 'id')),
      'created_at'                 => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'                 => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'created_by'                 => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'column' => 'id')),
      'updated_by'                 => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'column' => 'id')),
      'commission_list'            => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Commission', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('intervenant_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addCommissionListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->andWhereIn('Commission_intervenant.intervenant_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Intervenant';
  }

  public function getFields()
  {
    return array(
      'id'                         => 'Number',
      'civilite_id'                => 'ForeignKey',
      'nom'                        => 'Text',
      'prenom'                     => 'Text',
      'titre'                      => 'Text',
      'est_participant_commission' => 'Boolean',
      'est_responsable'            => 'Boolean',
      'email'                      => 'Text',
      'email2'                     => 'Text',
      'adresse'                    => 'Text',
      'adresse2'                   => 'Text',
      'adresse3'                   => 'Text',
      'code_postal'                => 'Text',
      'complement_adresse'         => 'Text',
      'ville_id'                   => 'ForeignKey',
      'telephone_fixe'             => 'Text',
      'telephone_mobile'           => 'Text',
      'fax'                        => 'Text',
      'est_actif'                  => 'Boolean',
      'adresse_etrangere'          => 'Text',
      'pays_id'                    => 'ForeignKey',
      'organisme_id'               => 'ForeignKey',
      'service_id'                 => 'ForeignKey',
      'laboratoire_id'             => 'ForeignKey',
      'created_at'                 => 'Date',
      'updated_at'                 => 'Date',
      'created_by'                 => 'ForeignKey',
      'updated_by'                 => 'ForeignKey',
      'commission_list'            => 'ManyKey',
    );
  }
}
