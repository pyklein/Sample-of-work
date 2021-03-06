<?php

/**
 * Echeance form base class.
 *
 * @method Echeance getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseEcheanceForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'date_echeance_ea' => new sfWidgetFormDateTime(),
      'date_echeance_cr' => new sfWidgetFormDateTime(),
      'dossier_mip_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_mip'), 'add_empty' => false)),
      'created_at'       => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
      'created_by'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'date_echeance_ea' => new sfValidatorDateTime(array('required' => false)),
      'date_echeance_cr' => new sfValidatorDateTime(array('required' => false)),
      'dossier_mip_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_mip'))),
      'created_at'       => new sfValidatorDateTime(),
      'updated_at'       => new sfValidatorDateTime(),
      'created_by'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'required' => false)),
      'updated_by'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('echeance[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Echeance';
  }

}
