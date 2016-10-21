<?php

/**
 * Evaluation form base class.
 *
 * @method Evaluation getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseEvaluationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'note_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Note'), 'add_empty' => true)),
      'valeur_note_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Valeur_note'), 'add_empty' => true)),
      'est_preselection'   => new sfWidgetFormInputCheckbox(),
      'est_globale'        => new sfWidgetFormInputCheckbox(),
      'est_actif'          => new sfWidgetFormInputCheckbox(),
      'est_finale'         => new sfWidgetFormInputCheckbox(),
      'invitation_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Invitation'), 'add_empty' => true)),
      'dossier_these_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_these'), 'add_empty' => true)),
      'dossier_ere_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_ere'), 'add_empty' => true)),
      'dossier_postdoc_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_postdoc'), 'add_empty' => true)),
      'created_at'         => new sfWidgetFormDateTime(),
      'updated_at'         => new sfWidgetFormDateTime(),
      'created_by'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'note_id'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Note'), 'required' => false)),
      'valeur_note_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Valeur_note'), 'required' => false)),
      'est_preselection'   => new sfValidatorBoolean(array('required' => false)),
      'est_globale'        => new sfValidatorBoolean(array('required' => false)),
      'est_actif'          => new sfValidatorBoolean(array('required' => false)),
      'est_finale'         => new sfValidatorBoolean(array('required' => false)),
      'invitation_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Invitation'), 'required' => false)),
      'dossier_these_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_these'), 'required' => false)),
      'dossier_ere_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_ere'), 'required' => false)),
      'dossier_postdoc_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_postdoc'), 'required' => false)),
      'created_at'         => new sfValidatorDateTime(),
      'updated_at'         => new sfValidatorDateTime(),
      'created_by'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'required' => false)),
      'updated_by'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('evaluation[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Evaluation';
  }

}
