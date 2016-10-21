<?php

/**
 * Evenement form base class.
 *
 * @method Evenement getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseEvenementForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                        => new sfWidgetFormInputHidden(),
      'date_evenement'            => new sfWidgetFormDate(),
      'description'               => new sfWidgetFormTextarea(),
      'dossier_these_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_these'), 'add_empty' => true)),
      'dossier_ere_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_ere'), 'add_empty' => true)),
      'dossier_postdoc_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_postdoc'), 'add_empty' => true)),
      'type_evenement_these_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Type_evenement_these'), 'add_empty' => true)),
      'type_evenement_ere_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Type_evenement_ere'), 'add_empty' => true)),
      'type_evenement_postdoc_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Type_evenement_postdoc'), 'add_empty' => true)),
      'created_by'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
      'created_at'                => new sfWidgetFormDateTime(),
      'updated_at'                => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                        => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'date_evenement'            => new sfValidatorDate(array('required' => false)),
      'description'               => new sfValidatorString(array('required' => false)),
      'dossier_these_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_these'), 'required' => false)),
      'dossier_ere_id'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_ere'), 'required' => false)),
      'dossier_postdoc_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_postdoc'), 'required' => false)),
      'type_evenement_these_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Type_evenement_these'), 'required' => false)),
      'type_evenement_ere_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Type_evenement_ere'), 'required' => false)),
      'type_evenement_postdoc_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Type_evenement_postdoc'), 'required' => false)),
      'created_by'                => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'required' => false)),
      'updated_by'                => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'required' => false)),
      'created_at'                => new sfValidatorDateTime(),
      'updated_at'                => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('evenement[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Evenement';
  }

}
