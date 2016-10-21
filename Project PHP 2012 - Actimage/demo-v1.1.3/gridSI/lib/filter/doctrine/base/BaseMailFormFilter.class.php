<?php

/**
 * Mail filter form base class.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseMailFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'sujet'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'message'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'destinataire'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'statut_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Mail_statut'), 'add_empty' => true)),
      'nombre_tentative' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'date_envoi'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'created_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'created_by'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'       => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'sujet'            => new sfValidatorPass(array('required' => false)),
      'message'          => new sfValidatorPass(array('required' => false)),
      'destinataire'     => new sfValidatorPass(array('required' => false)),
      'statut_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Mail_statut'), 'column' => 'id')),
      'nombre_tentative' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'date_envoi'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'created_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'created_by'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'column' => 'id')),
      'updated_by'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('mail_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Mail';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'sujet'            => 'Text',
      'message'          => 'Text',
      'destinataire'     => 'Text',
      'statut_id'        => 'ForeignKey',
      'nombre_tentative' => 'Number',
      'date_envoi'       => 'Date',
      'created_at'       => 'Date',
      'updated_at'       => 'Date',
      'created_by'       => 'ForeignKey',
      'updated_by'       => 'Number',
    );
  }
}
