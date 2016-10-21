<?php

/**
 * Session_innovateur_dossier_mip form base class.
 *
 * @method Session_innovateur_dossier_mip getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseSession_innovateur_dossier_mipForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'innovateur_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Innovateur'), 'add_empty' => false)),
      'transaction_token' => new sfWidgetFormInputText(),
      'nouveau_type_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Type_innovateur'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'innovateur_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Innovateur'))),
      'transaction_token' => new sfValidatorString(array('max_length' => 20)),
      'nouveau_type_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Type_innovateur'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('session_innovateur_dossier_mip[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Session_innovateur_dossier_mip';
  }

}
