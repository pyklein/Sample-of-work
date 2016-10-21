<?php

/**
 * Session_valorisation_interne form base class.
 *
 * @method Session_valorisation_interne getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseSession_valorisation_interneForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                      => new sfWidgetFormInputHidden(),
      'organisme_mindef_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('OrganismeMindef'), 'add_empty' => false)),
      'transaction_token'       => new sfWidgetFormInputText(),
      'date_debut_exploitation' => new sfWidgetFormDate(),
    ));

    $this->setValidators(array(
      'id'                      => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'organisme_mindef_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('OrganismeMindef'))),
      'transaction_token'       => new sfValidatorString(array('max_length' => 20)),
      'date_debut_exploitation' => new sfValidatorDate(),
    ));

    $this->widgetSchema->setNameFormat('session_valorisation_interne[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Session_valorisation_interne';
  }

}
