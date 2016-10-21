<?php

/**
 * Session_situation_inventeurs form base class.
 *
 * @method Session_situation_inventeurs getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseSession_situation_inventeursForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'inventeur_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Inventeur'), 'add_empty' => false)),
      'transaction_token' => new sfWidgetFormInputText(),
      'part_inventive'    => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'inventeur_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Inventeur'))),
      'transaction_token' => new sfValidatorString(array('max_length' => 20)),
      'part_inventive'    => new sfValidatorInteger(),
    ));

    $this->widgetSchema->setNameFormat('session_situation_inventeurs[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Session_situation_inventeurs';
  }

}
