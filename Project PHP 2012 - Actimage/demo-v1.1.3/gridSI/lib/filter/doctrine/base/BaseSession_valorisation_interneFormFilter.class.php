<?php

/**
 * Session_valorisation_interne filter form base class.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseSession_valorisation_interneFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'organisme_mindef_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('OrganismeMindef'), 'add_empty' => true)),
      'transaction_token'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'date_debut_exploitation' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'organisme_mindef_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('OrganismeMindef'), 'column' => 'id')),
      'transaction_token'       => new sfValidatorPass(array('required' => false)),
      'date_debut_exploitation' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('session_valorisation_interne_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Session_valorisation_interne';
  }

  public function getFields()
  {
    return array(
      'id'                      => 'Number',
      'organisme_mindef_id'     => 'ForeignKey',
      'transaction_token'       => 'Text',
      'date_debut_exploitation' => 'Date',
    );
  }
}
