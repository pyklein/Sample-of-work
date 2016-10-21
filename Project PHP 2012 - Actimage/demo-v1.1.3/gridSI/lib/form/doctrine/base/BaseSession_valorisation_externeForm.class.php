<?php

/**
 * Session_valorisation_externe form base class.
 *
 * @method Session_valorisation_externe getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseSession_valorisation_externeForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                             => new sfWidgetFormInputHidden(),
      'contrat_id'                     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Contrat'), 'add_empty' => true)),
      'organisme_id'                   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme'), 'add_empty' => false)),
      'statut_valorisation_externe_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('StatutValorisationExterne'), 'add_empty' => false)),
      'transaction_token'              => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'contrat_id'                     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Contrat'), 'required' => false)),
      'organisme_id'                   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme'))),
      'statut_valorisation_externe_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('StatutValorisationExterne'))),
      'transaction_token'              => new sfValidatorString(array('max_length' => 20)),
    ));

    $this->widgetSchema->setNameFormat('session_valorisation_externe[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Session_valorisation_externe';
  }

}
