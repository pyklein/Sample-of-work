<?php

/**
 * Remise_documents filter form base class.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseRemise_documentsFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'date_reception_ea'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'reference_ea'            => new sfWidgetFormFilterInput(),
      'date_envoi_ar_ea'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'reference_ar_ea'         => new sfWidgetFormFilterInput(),
      'mode_transmission_ea'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ModeTransmissionEA'), 'add_empty' => true)),
      'date_reception_cr'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'reference_cr'            => new sfWidgetFormFilterInput(),
      'date_envoi_ar_cr'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'reference_ar_cr'         => new sfWidgetFormFilterInput(),
      'mode_transmission_cr'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ModeTransmissionCR'), 'add_empty' => true)),
      'date_reception_video'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'reference_video'         => new sfWidgetFormFilterInput(),
      'date_envoi_ar_video'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'reference_ar_video'      => new sfWidgetFormFilterInput(),
      'mode_transmission_video' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ModeTransmissionVideo'), 'add_empty' => true)),
      'date_soutien'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'reference_soutien'       => new sfWidgetFormFilterInput(),
      'dossier_mip_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_mip'), 'add_empty' => true)),
      'created_at'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'created_by'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'date_reception_ea'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'reference_ea'            => new sfValidatorPass(array('required' => false)),
      'date_envoi_ar_ea'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'reference_ar_ea'         => new sfValidatorPass(array('required' => false)),
      'mode_transmission_ea'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ModeTransmissionEA'), 'column' => 'id')),
      'date_reception_cr'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'reference_cr'            => new sfValidatorPass(array('required' => false)),
      'date_envoi_ar_cr'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'reference_ar_cr'         => new sfValidatorPass(array('required' => false)),
      'mode_transmission_cr'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ModeTransmissionCR'), 'column' => 'id')),
      'date_reception_video'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'reference_video'         => new sfValidatorPass(array('required' => false)),
      'date_envoi_ar_video'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'reference_ar_video'      => new sfValidatorPass(array('required' => false)),
      'mode_transmission_video' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ModeTransmissionVideo'), 'column' => 'id')),
      'date_soutien'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'reference_soutien'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'dossier_mip_id'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Dossier_mip'), 'column' => 'id')),
      'created_at'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'created_by'              => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'column' => 'id')),
      'updated_by'              => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('remise_documents_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Remise_documents';
  }

  public function getFields()
  {
    return array(
      'id'                      => 'Number',
      'date_reception_ea'       => 'Date',
      'reference_ea'            => 'Text',
      'date_envoi_ar_ea'        => 'Date',
      'reference_ar_ea'         => 'Text',
      'mode_transmission_ea'    => 'ForeignKey',
      'date_reception_cr'       => 'Date',
      'reference_cr'            => 'Text',
      'date_envoi_ar_cr'        => 'Date',
      'reference_ar_cr'         => 'Text',
      'mode_transmission_cr'    => 'ForeignKey',
      'date_reception_video'    => 'Date',
      'reference_video'         => 'Text',
      'date_envoi_ar_video'     => 'Date',
      'reference_ar_video'      => 'Text',
      'mode_transmission_video' => 'ForeignKey',
      'date_soutien'            => 'Date',
      'reference_soutien'       => 'Number',
      'dossier_mip_id'          => 'ForeignKey',
      'created_at'              => 'Date',
      'updated_at'              => 'Date',
      'created_by'              => 'ForeignKey',
      'updated_by'              => 'ForeignKey',
    );
  }
}
