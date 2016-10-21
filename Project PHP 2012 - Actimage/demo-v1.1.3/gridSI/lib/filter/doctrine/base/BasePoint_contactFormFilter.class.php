<?php

/**
 * Point_contact filter form base class.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasePoint_contactFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'email'              => new sfWidgetFormFilterInput(),
      'email2'             => new sfWidgetFormFilterInput(),
      'telephone'          => new sfWidgetFormFilterInput(),
      'fax'                => new sfWidgetFormFilterInput(),
      'adresse'            => new sfWidgetFormFilterInput(),
      'adresse2'           => new sfWidgetFormFilterInput(),
      'adresse3'           => new sfWidgetFormFilterInput(),
      'complement_adresse' => new sfWidgetFormFilterInput(),
      'ville_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Ville'), 'add_empty' => true)),
      'code_postal'        => new sfWidgetFormFilterInput(),
      'adresse_etrangere'  => new sfWidgetFormFilterInput(),
      'pays_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Pays'), 'add_empty' => true)),
      'metier_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Metier'), 'add_empty' => true)),
      'organisme_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme'), 'add_empty' => true)),
      'laboratoire_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Laboratoire'), 'add_empty' => true)),
      'service_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Service'), 'add_empty' => true)),
      'created_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'created_by'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'email'              => new sfValidatorPass(array('required' => false)),
      'email2'             => new sfValidatorPass(array('required' => false)),
      'telephone'          => new sfValidatorPass(array('required' => false)),
      'fax'                => new sfValidatorPass(array('required' => false)),
      'adresse'            => new sfValidatorPass(array('required' => false)),
      'adresse2'           => new sfValidatorPass(array('required' => false)),
      'adresse3'           => new sfValidatorPass(array('required' => false)),
      'complement_adresse' => new sfValidatorPass(array('required' => false)),
      'ville_id'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Ville'), 'column' => 'id')),
      'code_postal'        => new sfValidatorPass(array('required' => false)),
      'adresse_etrangere'  => new sfValidatorPass(array('required' => false)),
      'pays_id'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Pays'), 'column' => 'id')),
      'metier_id'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Metier'), 'column' => 'id')),
      'organisme_id'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Organisme'), 'column' => 'id')),
      'laboratoire_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Laboratoire'), 'column' => 'id')),
      'service_id'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Service'), 'column' => 'id')),
      'created_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'created_by'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'column' => 'id')),
      'updated_by'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('point_contact_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Point_contact';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'email'              => 'Text',
      'email2'             => 'Text',
      'telephone'          => 'Text',
      'fax'                => 'Text',
      'adresse'            => 'Text',
      'adresse2'           => 'Text',
      'adresse3'           => 'Text',
      'complement_adresse' => 'Text',
      'ville_id'           => 'ForeignKey',
      'code_postal'        => 'Text',
      'adresse_etrangere'  => 'Text',
      'pays_id'            => 'ForeignKey',
      'metier_id'          => 'ForeignKey',
      'organisme_id'       => 'ForeignKey',
      'laboratoire_id'     => 'ForeignKey',
      'service_id'         => 'ForeignKey',
      'created_at'         => 'Date',
      'updated_at'         => 'Date',
      'created_by'         => 'ForeignKey',
      'updated_by'         => 'ForeignKey',
    );
  }
}
