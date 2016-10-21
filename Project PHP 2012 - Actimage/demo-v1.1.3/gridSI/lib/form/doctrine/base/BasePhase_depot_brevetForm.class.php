<?php

/**
 * Phase_depot_brevet form base class.
 *
 * @method Phase_depot_brevet getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasePhase_depot_brevetForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'intitule'              => new sfWidgetFormInputText(),
      'abreviation'           => new sfWidgetFormInputText(),
      'est_actif'             => new sfWidgetFormInputCheckbox(),
      'est_actif_pere'        => new sfWidgetFormInputCheckbox(),
      'phase_depot_brevet_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('PhaseDepotBrevet'), 'add_empty' => true)),
      'created_at'            => new sfWidgetFormDateTime(),
      'updated_at'            => new sfWidgetFormDateTime(),
      'created_by'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'intitule'              => new sfValidatorString(array('max_length' => 255)),
      'abreviation'           => new sfValidatorString(array('max_length' => 255)),
      'est_actif'             => new sfValidatorBoolean(array('required' => false)),
      'est_actif_pere'        => new sfValidatorBoolean(array('required' => false)),
      'phase_depot_brevet_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('PhaseDepotBrevet'), 'required' => false)),
      'created_at'            => new sfValidatorDateTime(),
      'updated_at'            => new sfValidatorDateTime(),
      'created_by'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'required' => false)),
      'updated_by'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('phase_depot_brevet[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Phase_depot_brevet';
  }

}
