<?php

/**
 * Document_mris form base class.
 *
 * @method Document_mris getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseDocument_mrisForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                       => new sfWidgetFormInputHidden(),
      'fichier'                  => new sfWidgetFormInputText(),
      'fichier_orig'             => new sfWidgetFormInputText(),
      'est_joint'                => new sfWidgetFormInputCheckbox(),
      'titre'                    => new sfWidgetFormInputText(),
      'autre_type'               => new sfWidgetFormInputText(),
      'dossier_these_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_these'), 'add_empty' => true)),
      'dossier_ere_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_ere'), 'add_empty' => true)),
      'dossier_postdoc_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_postdoc'), 'add_empty' => true)),
      'type_document_these_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Type_document_these'), 'add_empty' => true)),
      'type_document_ere_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Type_document_ere'), 'add_empty' => true)),
      'type_document_postdoc_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Type_document_postdoc'), 'add_empty' => true)),
      'created_at'               => new sfWidgetFormDateTime(),
      'updated_at'               => new sfWidgetFormDateTime(),
      'created_by'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                       => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'fichier'                  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'fichier_orig'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'est_joint'                => new sfValidatorBoolean(array('required' => false)),
      'titre'                    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'autre_type'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'dossier_these_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_these'), 'required' => false)),
      'dossier_ere_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_ere'), 'required' => false)),
      'dossier_postdoc_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_postdoc'), 'required' => false)),
      'type_document_these_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Type_document_these'), 'required' => false)),
      'type_document_ere_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Type_document_ere'), 'required' => false)),
      'type_document_postdoc_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Type_document_postdoc'), 'required' => false)),
      'created_at'               => new sfValidatorDateTime(),
      'updated_at'               => new sfValidatorDateTime(),
      'created_by'               => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'required' => false)),
      'updated_by'               => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('document_mris[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Document_mris';
  }

}
