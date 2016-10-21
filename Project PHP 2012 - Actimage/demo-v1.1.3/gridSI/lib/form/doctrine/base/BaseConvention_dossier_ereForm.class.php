<?php

/**
 * Convention_dossier_ere form base class.
 *
 * @method Convention_dossier_ere getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseConvention_dossier_ereForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                           => new sfWidgetFormInputHidden(),
      'numero_convention'            => new sfWidgetFormInputText(),
      'type_convention_organisme_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TypeConventionOrganisme'), 'add_empty' => true)),
      'dossier_ere_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DossierEre'), 'add_empty' => false)),
      'montant'                      => new sfWidgetFormInputText(),
      'date_signature'               => new sfWidgetFormDate(),
      'date_notification'            => new sfWidgetFormDate(),
      'date_prise_effet'             => new sfWidgetFormDate(),
      'date_fin_effet'               => new sfWidgetFormDate(),
      'date_archivage'               => new sfWidgetFormDate(),
      'fichier'                      => new sfWidgetFormInputText(),
      'fichier_orig'                 => new sfWidgetFormInputText(),
      'created_at'                   => new sfWidgetFormDateTime(),
      'updated_at'                   => new sfWidgetFormDateTime(),
      'created_by'                   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'                   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'numero_convention'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'type_convention_organisme_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TypeConventionOrganisme'), 'required' => false)),
      'dossier_ere_id'               => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('DossierEre'))),
      'montant'                      => new sfValidatorInteger(array('required' => false)),
      'date_signature'               => new sfValidatorDate(array('required' => false)),
      'date_notification'            => new sfValidatorDate(array('required' => false)),
      'date_prise_effet'             => new sfValidatorDate(),
      'date_fin_effet'               => new sfValidatorDate(array('required' => false)),
      'date_archivage'               => new sfValidatorDate(array('required' => false)),
      'fichier'                      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'fichier_orig'                 => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'                   => new sfValidatorDateTime(),
      'updated_at'                   => new sfValidatorDateTime(),
      'created_by'                   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'required' => false)),
      'updated_by'                   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('convention_dossier_ere[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Convention_dossier_ere';
  }

}
