<?php

/**
 * Valorisation_interne form base class.
 *
 * @method Valorisation_interne getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseValorisation_interneForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                      => new sfWidgetFormInputHidden(),
      'date_debut_exploitation' => new sfWidgetFormDate(),
      'organisme_mindef_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme_mindef'), 'add_empty' => false)),
      'valorisation_bpi_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Valorisation_bpi'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'                      => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'date_debut_exploitation' => new sfValidatorDate(array('required' => false)),
      'organisme_mindef_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme_mindef'))),
      'valorisation_bpi_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Valorisation_bpi'))),
    ));

    $this->widgetSchema->setNameFormat('valorisation_interne[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Valorisation_interne';
  }

}
