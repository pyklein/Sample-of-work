<?php

/**
 * Valorisation_interne filter form base class.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseValorisation_interneFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'date_debut_exploitation' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'organisme_mindef_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme_mindef'), 'add_empty' => true)),
      'valorisation_bpi_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Valorisation_bpi'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'date_debut_exploitation' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'organisme_mindef_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Organisme_mindef'), 'column' => 'id')),
      'valorisation_bpi_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Valorisation_bpi'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('valorisation_interne_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Valorisation_interne';
  }

  public function getFields()
  {
    return array(
      'id'                      => 'Number',
      'date_debut_exploitation' => 'Date',
      'organisme_mindef_id'     => 'ForeignKey',
      'valorisation_bpi_id'     => 'ForeignKey',
    );
  }
}
