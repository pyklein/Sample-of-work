<?php

/**
 * Contact_se filter form base class.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseContact_seFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'nom'                => new sfWidgetFormFilterInput(),
      'prenom'             => new sfWidgetFormFilterInput(),
      'email'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'email2'             => new sfWidgetFormFilterInput(),
      'telephone'          => new sfWidgetFormFilterInput(),
      'fax'                => new sfWidgetFormFilterInput(),
      'adresse'            => new sfWidgetFormFilterInput(),
      'adresse2'           => new sfWidgetFormFilterInput(),
      'adresse3'           => new sfWidgetFormFilterInput(),
      'code_postal'        => new sfWidgetFormFilterInput(),
      'complement_adresse' => new sfWidgetFormFilterInput(),
      'information_libre'  => new sfWidgetFormFilterInput(),
      'ville_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Ville'), 'add_empty' => true)),
      'entite_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Entite'), 'add_empty' => true)),
      'metier_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Metier'), 'add_empty' => true)),
      'created_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'created_by'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'nom'                => new sfValidatorPass(array('required' => false)),
      'prenom'             => new sfValidatorPass(array('required' => false)),
      'email'              => new sfValidatorPass(array('required' => false)),
      'email2'             => new sfValidatorPass(array('required' => false)),
      'telephone'          => new sfValidatorPass(array('required' => false)),
      'fax'                => new sfValidatorPass(array('required' => false)),
      'adresse'            => new sfValidatorPass(array('required' => false)),
      'adresse2'           => new sfValidatorPass(array('required' => false)),
      'adresse3'           => new sfValidatorPass(array('required' => false)),
      'code_postal'        => new sfValidatorPass(array('required' => false)),
      'complement_adresse' => new sfValidatorPass(array('required' => false)),
      'information_libre'  => new sfValidatorPass(array('required' => false)),
      'ville_id'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Ville'), 'column' => 'id')),
      'entite_id'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Entite'), 'column' => 'id')),
      'metier_id'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Metier'), 'column' => 'id')),
      'created_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'created_by'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'column' => 'id')),
      'updated_by'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('contact_se_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Contact_se';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'nom'                => 'Text',
      'prenom'             => 'Text',
      'email'              => 'Text',
      'email2'             => 'Text',
      'telephone'          => 'Text',
      'fax'                => 'Text',
      'adresse'            => 'Text',
      'adresse2'           => 'Text',
      'adresse3'           => 'Text',
      'code_postal'        => 'Text',
      'complement_adresse' => 'Text',
      'information_libre'  => 'Text',
      'ville_id'           => 'ForeignKey',
      'entite_id'          => 'ForeignKey',
      'metier_id'          => 'ForeignKey',
      'created_at'         => 'Date',
      'updated_at'         => 'Date',
      'created_by'         => 'ForeignKey',
      'updated_by'         => 'ForeignKey',
    );
  }
}
