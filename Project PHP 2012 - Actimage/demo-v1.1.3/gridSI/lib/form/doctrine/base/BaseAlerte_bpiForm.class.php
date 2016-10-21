<?php

/**
 * Alerte_bpi form base class.
 *
 * @method Alerte_bpi getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseAlerte_bpiForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'type_alerte_bpi_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TypeAlerteBpi'), 'add_empty' => false)),
      'date_alerte'        => new sfWidgetFormDate(),
      'date_echeance'      => new sfWidgetFormDate(),
      'dossier_bpi_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DossierBpi'), 'add_empty' => false)),
      'brevet_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Brevet'), 'add_empty' => true)),
      'action_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Action'), 'add_empty' => true)),
      'deja_passe'         => new sfWidgetFormInputCheckbox(),
      'created_at'         => new sfWidgetFormDateTime(),
      'updated_at'         => new sfWidgetFormDateTime(),
      'created_by'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'type_alerte_bpi_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TypeAlerteBpi'))),
      'date_alerte'        => new sfValidatorDate(),
      'date_echeance'      => new sfValidatorDate(),
      'dossier_bpi_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('DossierBpi'))),
      'brevet_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Brevet'), 'required' => false)),
      'action_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Action'), 'required' => false)),
      'deja_passe'         => new sfValidatorBoolean(array('required' => false)),
      'created_at'         => new sfValidatorDateTime(),
      'updated_at'         => new sfValidatorDateTime(),
      'created_by'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'required' => false)),
      'updated_by'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('alerte_bpi[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Alerte_bpi';
  }

}
