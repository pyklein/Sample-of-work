<?php

/**
 * Valorisation_externe filter form base class.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseValorisation_externeFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'statut_valorisation_externe_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Statut_valorisation_externe'), 'add_empty' => true)),
      'contrat_id'                     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Contrat'), 'add_empty' => true)),
      'organisme_id'                   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme'), 'add_empty' => true)),
      'valorisation_bpi_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Valorisation_bpi'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'statut_valorisation_externe_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Statut_valorisation_externe'), 'column' => 'id')),
      'contrat_id'                     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Contrat'), 'column' => 'id')),
      'organisme_id'                   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Organisme'), 'column' => 'id')),
      'valorisation_bpi_id'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Valorisation_bpi'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('valorisation_externe_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Valorisation_externe';
  }

  public function getFields()
  {
    return array(
      'id'                             => 'Number',
      'statut_valorisation_externe_id' => 'ForeignKey',
      'contrat_id'                     => 'ForeignKey',
      'organisme_id'                   => 'ForeignKey',
      'valorisation_bpi_id'            => 'ForeignKey',
    );
  }
}
