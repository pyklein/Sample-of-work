<?php

/**
 * Remise_documents form base class.
 *
 * @method Remise_documents getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseRemise_documentsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                      => new sfWidgetFormInputHidden(),
      'date_reception_ea'       => new sfWidgetFormDateTime(),
      'reference_ea'            => new sfWidgetFormInputText(),
      'date_envoi_ar_ea'        => new sfWidgetFormDateTime(),
      'reference_ar_ea'         => new sfWidgetFormInputText(),
      'mode_transmission_ea'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ModeTransmissionEA'), 'add_empty' => true)),
      'date_reception_cr'       => new sfWidgetFormDateTime(),
      'reference_cr'            => new sfWidgetFormInputText(),
      'date_envoi_ar_cr'        => new sfWidgetFormDateTime(),
      'reference_ar_cr'         => new sfWidgetFormInputText(),
      'mode_transmission_cr'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ModeTransmissionCR'), 'add_empty' => true)),
      'date_reception_video'    => new sfWidgetFormDateTime(),
      'reference_video'         => new sfWidgetFormInputText(),
      'date_envoi_ar_video'     => new sfWidgetFormDateTime(),
      'reference_ar_video'      => new sfWidgetFormInputText(),
      'mode_transmission_video' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ModeTransmissionVideo'), 'add_empty' => true)),
      'date_soutien'            => new sfWidgetFormDateTime(),
      'reference_soutien'       => new sfWidgetFormInputText(),
      'dossier_mip_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_mip'), 'add_empty' => false)),
      'created_at'              => new sfWidgetFormDateTime(),
      'updated_at'              => new sfWidgetFormDateTime(),
      'created_by'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                      => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'date_reception_ea'       => new sfValidatorDateTime(array('required' => false)),
      'reference_ea'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'date_envoi_ar_ea'        => new sfValidatorDateTime(array('required' => false)),
      'reference_ar_ea'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'mode_transmission_ea'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ModeTransmissionEA'), 'required' => false)),
      'date_reception_cr'       => new sfValidatorDateTime(array('required' => false)),
      'reference_cr'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'date_envoi_ar_cr'        => new sfValidatorDateTime(array('required' => false)),
      'reference_ar_cr'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'mode_transmission_cr'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ModeTransmissionCR'), 'required' => false)),
      'date_reception_video'    => new sfValidatorDateTime(array('required' => false)),
      'reference_video'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'date_envoi_ar_video'     => new sfValidatorDateTime(array('required' => false)),
      'reference_ar_video'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'mode_transmission_video' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ModeTransmissionVideo'), 'required' => false)),
      'date_soutien'            => new sfValidatorDateTime(array('required' => false)),
      'reference_soutien'       => new sfValidatorInteger(array('required' => false)),
      'dossier_mip_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_mip'))),
      'created_at'              => new sfValidatorDateTime(),
      'updated_at'              => new sfValidatorDateTime(),
      'created_by'              => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'required' => false)),
      'updated_by'              => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('remise_documents[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Remise_documents';
  }

}
