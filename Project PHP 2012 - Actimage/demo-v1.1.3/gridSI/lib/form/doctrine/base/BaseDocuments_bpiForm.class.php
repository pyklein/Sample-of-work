<?php

/**
 * Documents_bpi form base class.
 *
 * @method Documents_bpi getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseDocuments_bpiForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'fichier'               => new sfWidgetFormInputText(),
      'fichier_orig'          => new sfWidgetFormInputText(),
      'titre'                 => new sfWidgetFormInputText(),
      'est_joint'             => new sfWidgetFormInputCheckbox(),
      'est_invisible'         => new sfWidgetFormInputCheckbox(),
      'dossier_bpi_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_bpi'), 'add_empty' => false)),
      'statut_dossier_bpi_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Statut_dossier_bpi'), 'add_empty' => true)),
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
      'est_invisible'         => new sfValidatorBoolean(array('required' => false)),
      'dossier_bpi_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_bpi'))),
      'statut_dossier_bpi_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Statut_dossier_bpi'), 'required' => false)),
      'created_at'            => new sfValidatorDateTime(),
      'updated_at'            => new sfValidatorDateTime(),
      'created_by'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'required' => false)),
      'updated_by'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('documents_bpi[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Documents_bpi';
  }

}
