<?php

/**
 * Session_encadrants_dossier_postdoc form base class.
 *
 * @method Session_encadrants_dossier_postdoc getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseSession_encadrants_dossier_postdocForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'dossier_postdoc_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DossierPostdoc'), 'add_empty' => true)),
      'intervenant_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Intervenant'), 'add_empty' => true)),
      'role_postdoc_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('RolePostdoc'), 'add_empty' => true)),
      'transaction_token'  => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'dossier_postdoc_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('DossierPostdoc'), 'required' => false)),
      'intervenant_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Intervenant'), 'required' => false)),
      'role_postdoc_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('RolePostdoc'), 'required' => false)),
      'transaction_token'  => new sfValidatorString(array('max_length' => 20)),
    ));

    $this->widgetSchema->setNameFormat('session_encadrants_dossier_postdoc[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Session_encadrants_dossier_postdoc';
  }

}
