<?php

/**
 * Session_encadrants_dossier_ere form base class.
 *
 * @method Session_encadrants_dossier_ere getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseSession_encadrants_dossier_ereForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'dossier_ere_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DossierEre'), 'add_empty' => true)),
      'intervenant_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Intervenant'), 'add_empty' => true)),
      'role_ere_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('RoleEre'), 'add_empty' => true)),
      'transaction_token' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'dossier_ere_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('DossierEre'), 'required' => false)),
      'intervenant_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Intervenant'), 'required' => false)),
      'role_ere_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('RoleEre'), 'required' => false)),
      'transaction_token' => new sfValidatorString(array('max_length' => 20)),
    ));

    $this->widgetSchema->setNameFormat('session_encadrants_dossier_ere[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Session_encadrants_dossier_ere';
  }

}
