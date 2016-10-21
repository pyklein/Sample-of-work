<?php

/**
 * Suivi_dossier_these form base class.
 *
 * @method Suivi_dossier_these getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseSuivi_dossier_theseForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'descriptif'          => new sfWidgetFormTextarea(),
      'date_demande'        => new sfWidgetFormDate(),
      'date_reception'      => new sfWidgetFormDate(),
      'dossier_these_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_these'), 'add_empty' => false)),
      'type_suivi_these_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Type_suivi_these'), 'add_empty' => false)),
      'created_at'          => new sfWidgetFormDateTime(),
      'updated_at'          => new sfWidgetFormDateTime(),
      'created_by'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'descriptif'          => new sfValidatorString(array('required' => false)),
      'date_demande'        => new sfValidatorDate(array('required' => false)),
      'date_reception'      => new sfValidatorDate(array('required' => false)),
      'dossier_these_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_these'))),
      'type_suivi_these_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Type_suivi_these'))),
      'created_at'          => new sfValidatorDateTime(),
      'updated_at'          => new sfValidatorDateTime(),
      'created_by'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'required' => false)),
      'updated_by'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('suivi_dossier_these[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Suivi_dossier_these';
  }

}
