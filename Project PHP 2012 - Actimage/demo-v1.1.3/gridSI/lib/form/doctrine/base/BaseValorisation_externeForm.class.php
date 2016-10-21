<?php

/**
 * Valorisation_externe form base class.
 *
 * @method Valorisation_externe getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseValorisation_externeForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                             => new sfWidgetFormInputHidden(),
      'statut_valorisation_externe_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Statut_valorisation_externe'), 'add_empty' => false)),
      'contrat_id'                     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Contrat'), 'add_empty' => true)),
      'organisme_id'                   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme'), 'add_empty' => false)),
      'valorisation_bpi_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Valorisation_bpi'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'                             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'statut_valorisation_externe_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Statut_valorisation_externe'))),
      'contrat_id'                     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Contrat'), 'required' => false)),
      'organisme_id'                   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme'))),
      'valorisation_bpi_id'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Valorisation_bpi'))),
    ));

    $this->widgetSchema->setNameFormat('valorisation_externe[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Valorisation_externe';
  }

}
