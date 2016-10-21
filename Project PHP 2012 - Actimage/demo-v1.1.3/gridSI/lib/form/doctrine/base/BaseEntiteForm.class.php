<?php

/**
 * Entite form base class.
 *
 * @method Entite getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseEntiteForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'intitule'            => new sfWidgetFormInputText(),
      'abreviation'         => new sfWidgetFormInputText(),
      'lieu'                => new sfWidgetFormInputText(),
      'ville_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Ville'), 'add_empty' => true)),
      'organisme_mindef_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme_mindef'), 'add_empty' => false)),
      'entite_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Entite'), 'add_empty' => true)),
      'est_actif'           => new sfWidgetFormInputCheckbox(),
      'parents'             => new sfWidgetFormInputText(),
      'parents_arbo'        => new sfWidgetFormInputText(),
      'est_executant'       => new sfWidgetFormInputCheckbox(),
      'code_executant'      => new sfWidgetFormInputText(),
      'created_at'          => new sfWidgetFormDateTime(),
      'updated_at'          => new sfWidgetFormDateTime(),
      'created_by'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'intitule'            => new sfValidatorString(array('max_length' => 255)),
      'abreviation'         => new sfValidatorString(array('max_length' => 255)),
      'lieu'                => new sfValidatorString(array('max_length' => 255)),
      'ville_id'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Ville'), 'required' => false)),
      'organisme_mindef_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme_mindef'))),
      'entite_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Entite'), 'required' => false)),
      'est_actif'           => new sfValidatorBoolean(array('required' => false)),
      'parents'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'parents_arbo'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'est_executant'       => new sfValidatorBoolean(),
      'code_executant'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'          => new sfValidatorDateTime(),
      'updated_at'          => new sfValidatorDateTime(),
      'created_by'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'required' => false)),
      'updated_by'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('entite[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Entite';
  }

}
