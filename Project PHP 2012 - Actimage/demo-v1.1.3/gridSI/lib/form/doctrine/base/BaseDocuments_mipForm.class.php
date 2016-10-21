<?php

/**
 * Documents_mip form base class.
 *
 * @method Documents_mip getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseDocuments_mipForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'fichier'               => new sfWidgetFormInputText(),
      'fichier_orig'          => new sfWidgetFormInputText(),
      'titre'                 => new sfWidgetFormInputText(),
      'est_joint'             => new sfWidgetFormInputCheckbox(),
      'autre_type'            => new sfWidgetFormInputText(),
      'dossier_mip_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_mip'), 'add_empty' => false)),
      'documents_mip_type_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Documents_mip_type'), 'add_empty' => true)),
      'created_at'            => new sfWidgetFormDateTime(),
      'updated_at'            => new sfWidgetFormDateTime(),
      'created_by'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'fichier'               => new sfValidatorString(array('max_length' => 255)),
      'fichier_orig'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'titre'                 => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'est_joint'             => new sfValidatorBoolean(array('required' => false)),
      'autre_type'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'dossier_mip_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_mip'))),
      'documents_mip_type_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Documents_mip_type'), 'required' => false)),
      'created_at'            => new sfValidatorDateTime(),
      'updated_at'            => new sfValidatorDateTime(),
      'created_by'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'required' => false)),
      'updated_by'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('documents_mip[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Documents_mip';
  }

}
