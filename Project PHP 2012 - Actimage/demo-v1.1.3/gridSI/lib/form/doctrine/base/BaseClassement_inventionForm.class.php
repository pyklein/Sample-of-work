<?php

/**
 * Classement_invention form base class.
 *
 * @method Classement_invention getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseClassement_inventionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'dossier_bpi_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_bpi'), 'add_empty' => false)),
      'concerne_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Concerne'), 'add_empty' => false)),
      'propose_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Propose'), 'add_empty' => true)),
      'classement_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Classement'), 'add_empty' => false)),
      'hierarchie_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Hierarchie'), 'add_empty' => true)),
      'autorite_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Autorite'), 'add_empty' => true)),
      'created_by'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
      'est_final'      => new sfWidgetFormInputCheckbox(),
      'created_at'     => new sfWidgetFormDateTime(),
      'updated_at'     => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'dossier_bpi_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_bpi'))),
      'concerne_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Concerne'))),
      'propose_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Propose'), 'required' => false)),
      'classement_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Classement'))),
      'hierarchie_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Hierarchie'), 'required' => false)),
      'autorite_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Autorite'), 'required' => false)),
      'created_by'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'required' => false)),
      'updated_by'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'required' => false)),
      'est_final'      => new sfValidatorBoolean(array('required' => false)),
      'created_at'     => new sfValidatorDateTime(),
      'updated_at'     => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('classement_invention[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Classement_invention';
  }

}
