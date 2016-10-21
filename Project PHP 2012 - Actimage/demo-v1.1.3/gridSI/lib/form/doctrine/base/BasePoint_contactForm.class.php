<?php

/**
 * Point_contact form base class.
 *
 * @method Point_contact getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasePoint_contactForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'email'              => new sfWidgetFormInputText(),
      'email2'             => new sfWidgetFormInputText(),
      'telephone'          => new sfWidgetFormInputText(),
      'fax'                => new sfWidgetFormInputText(),
      'adresse'            => new sfWidgetFormInputText(),
      'adresse2'           => new sfWidgetFormInputText(),
      'adresse3'           => new sfWidgetFormInputText(),
      'complement_adresse' => new sfWidgetFormInputText(),
      'ville_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Ville'), 'add_empty' => true)),
      'code_postal'        => new sfWidgetFormInputText(),
      'adresse_etrangere'  => new sfWidgetFormTextarea(),
      'pays_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Pays'), 'add_empty' => true)),
      'metier_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Metier'), 'add_empty' => false)),
      'organisme_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme'), 'add_empty' => true)),
      'laboratoire_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Laboratoire'), 'add_empty' => true)),
      'service_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Service'), 'add_empty' => true)),
      'created_at'         => new sfWidgetFormDateTime(),
      'updated_at'         => new sfWidgetFormDateTime(),
      'created_by'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'email'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'email2'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'telephone'          => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'fax'                => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'adresse'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'adresse2'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'adresse3'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'complement_adresse' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'ville_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Ville'), 'required' => false)),
      'code_postal'        => new sfValidatorString(array('max_length' => 5, 'required' => false)),
      'adresse_etrangere'  => new sfValidatorString(array('required' => false)),
      'pays_id'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Pays'), 'required' => false)),
      'metier_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Metier'))),
      'organisme_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme'), 'required' => false)),
      'laboratoire_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Laboratoire'), 'required' => false)),
      'service_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Service'), 'required' => false)),
      'created_at'         => new sfValidatorDateTime(),
      'updated_at'         => new sfValidatorDateTime(),
      'created_by'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'required' => false)),
      'updated_by'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('point_contact[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Point_contact';
  }

}
