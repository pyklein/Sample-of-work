<?php

/**
 * Contact_se form base class.
 *
 * @method Contact_se getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseContact_seForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'nom'                => new sfWidgetFormInputText(),
      'prenom'             => new sfWidgetFormInputText(),
      'email'              => new sfWidgetFormInputText(),
      'email2'             => new sfWidgetFormInputText(),
      'telephone'          => new sfWidgetFormInputText(),
      'fax'                => new sfWidgetFormInputText(),
      'adresse'            => new sfWidgetFormInputText(),
      'adresse2'           => new sfWidgetFormInputText(),
      'adresse3'           => new sfWidgetFormInputText(),
      'code_postal'        => new sfWidgetFormInputText(),
      'complement_adresse' => new sfWidgetFormInputText(),
      'information_libre'  => new sfWidgetFormTextarea(),
      'ville_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Ville'), 'add_empty' => true)),
      'entite_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Entite'), 'add_empty' => false)),
      'metier_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Metier'), 'add_empty' => false)),
      'created_at'         => new sfWidgetFormDateTime(),
      'updated_at'         => new sfWidgetFormDateTime(),
      'created_by'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'nom'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'prenom'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'email'              => new sfValidatorString(array('max_length' => 255)),
      'email2'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'telephone'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'fax'                => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'adresse'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'adresse2'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'adresse3'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'code_postal'        => new sfValidatorString(array('max_length' => 5, 'required' => false)),
      'complement_adresse' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'information_libre'  => new sfValidatorString(array('required' => false)),
      'ville_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Ville'), 'required' => false)),
      'entite_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Entite'))),
      'metier_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Metier'))),
      'created_at'         => new sfValidatorDateTime(),
      'updated_at'         => new sfValidatorDateTime(),
      'created_by'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'required' => false)),
      'updated_by'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('contact_se[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Contact_se';
  }

}
