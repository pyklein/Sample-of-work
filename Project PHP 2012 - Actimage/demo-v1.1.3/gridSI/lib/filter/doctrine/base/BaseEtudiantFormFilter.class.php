<?php

/**
 * Etudiant filter form base class.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseEtudiantFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'civilite_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Civilite'), 'add_empty' => true)),
      'nom'                   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'nom_jeunefille'        => new sfWidgetFormFilterInput(),
      'prenom'                => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'date_naissance'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'lieu_naissance'        => new sfWidgetFormFilterInput(),
      'email'                 => new sfWidgetFormFilterInput(),
      'email2'                => new sfWidgetFormFilterInput(),
      'adresse'               => new sfWidgetFormFilterInput(),
      'adresse2'              => new sfWidgetFormFilterInput(),
      'adresse3'              => new sfWidgetFormFilterInput(),
      'code_postal'           => new sfWidgetFormFilterInput(),
      'complement_adresse'    => new sfWidgetFormFilterInput(),
      'ville_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Ville'), 'add_empty' => true)),
      'telephone_fixe'        => new sfWidgetFormFilterInput(),
      'telephone_mobile'      => new sfWidgetFormFilterInput(),
      'adresse_etrangere'     => new sfWidgetFormFilterInput(),
      'pays_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Pays'), 'add_empty' => true)),
      'nationalite_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Nationalite'), 'add_empty' => true)),
      'autre_cursus'          => new sfWidgetFormFilterInput(),
      'a_master'              => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'mention'               => new sfWidgetFormFilterInput(),
      'description_formation' => new sfWidgetFormFilterInput(),
      'photographie'          => new sfWidgetFormFilterInput(),
      'photographie_orig'     => new sfWidgetFormFilterInput(),
      'type_cursus_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Type_cursus'), 'add_empty' => true)),
      'est_actif'             => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'created_by'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'civilite_id'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Civilite'), 'column' => 'id')),
      'nom'                   => new sfValidatorPass(array('required' => false)),
      'nom_jeunefille'        => new sfValidatorPass(array('required' => false)),
      'prenom'                => new sfValidatorPass(array('required' => false)),
      'date_naissance'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'lieu_naissance'        => new sfValidatorPass(array('required' => false)),
      'email'                 => new sfValidatorPass(array('required' => false)),
      'email2'                => new sfValidatorPass(array('required' => false)),
      'adresse'               => new sfValidatorPass(array('required' => false)),
      'adresse2'              => new sfValidatorPass(array('required' => false)),
      'adresse3'              => new sfValidatorPass(array('required' => false)),
      'code_postal'           => new sfValidatorPass(array('required' => false)),
      'complement_adresse'    => new sfValidatorPass(array('required' => false)),
      'ville_id'              => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Ville'), 'column' => 'id')),
      'telephone_fixe'        => new sfValidatorPass(array('required' => false)),
      'telephone_mobile'      => new sfValidatorPass(array('required' => false)),
      'adresse_etrangere'     => new sfValidatorPass(array('required' => false)),
      'pays_id'               => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Pays'), 'column' => 'id')),
      'nationalite_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Nationalite'), 'column' => 'id')),
      'autre_cursus'          => new sfValidatorPass(array('required' => false)),
      'a_master'              => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'mention'               => new sfValidatorPass(array('required' => false)),
      'description_formation' => new sfValidatorPass(array('required' => false)),
      'photographie'          => new sfValidatorPass(array('required' => false)),
      'photographie_orig'     => new sfValidatorPass(array('required' => false)),
      'type_cursus_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Type_cursus'), 'column' => 'id')),
      'est_actif'             => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'created_by'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'column' => 'id')),
      'updated_by'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('etudiant_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Etudiant';
  }

  public function getFields()
  {
    return array(
      'id'                    => 'Number',
      'civilite_id'           => 'ForeignKey',
      'nom'                   => 'Text',
      'nom_jeunefille'        => 'Text',
      'prenom'                => 'Text',
      'date_naissance'        => 'Date',
      'lieu_naissance'        => 'Text',
      'email'                 => 'Text',
      'email2'                => 'Text',
      'adresse'               => 'Text',
      'adresse2'              => 'Text',
      'adresse3'              => 'Text',
      'code_postal'           => 'Text',
      'complement_adresse'    => 'Text',
      'ville_id'              => 'ForeignKey',
      'telephone_fixe'        => 'Text',
      'telephone_mobile'      => 'Text',
      'adresse_etrangere'     => 'Text',
      'pays_id'               => 'ForeignKey',
      'nationalite_id'        => 'ForeignKey',
      'autre_cursus'          => 'Text',
      'a_master'              => 'Boolean',
      'mention'               => 'Text',
      'description_formation' => 'Text',
      'photographie'          => 'Text',
      'photographie_orig'     => 'Text',
      'type_cursus_id'        => 'ForeignKey',
      'est_actif'             => 'Boolean',
      'created_at'            => 'Date',
      'updated_at'            => 'Date',
      'created_by'            => 'ForeignKey',
      'updated_by'            => 'ForeignKey',
    );
  }
}
