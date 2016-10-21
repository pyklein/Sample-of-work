<?php

/**
 * Session_dossier_these_laboratoire form base class.
 *
 * @method Session_dossier_these_laboratoire getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseSession_dossier_these_laboratoireForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'dossier_these_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DossierThese'), 'add_empty' => true)),
      'laboratoire_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Laboratoire'), 'add_empty' => true)),
      'transaction_token' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'dossier_these_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('DossierThese'), 'required' => false)),
      'laboratoire_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Laboratoire'), 'required' => false)),
      'transaction_token' => new sfValidatorString(array('max_length' => 20)),
    ));

    $this->widgetSchema->setNameFormat('session_dossier_these_laboratoire[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Session_dossier_these_laboratoire';
  }

}
