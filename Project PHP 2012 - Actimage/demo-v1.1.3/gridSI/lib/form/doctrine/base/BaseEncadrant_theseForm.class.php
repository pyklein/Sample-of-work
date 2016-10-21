<?php

/**
 * Encadrant_these form base class.
 *
 * @method Encadrant_these getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseEncadrant_theseForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'dossier_these_id' => new sfWidgetFormInputHidden(),
      'intervenant_id'   => new sfWidgetFormInputHidden(),
      'role_these_id'    => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'dossier_these_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('dossier_these_id')), 'empty_value' => $this->getObject()->get('dossier_these_id'), 'required' => false)),
      'intervenant_id'   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('intervenant_id')), 'empty_value' => $this->getObject()->get('intervenant_id'), 'required' => false)),
      'role_these_id'    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('role_these_id')), 'empty_value' => $this->getObject()->get('role_these_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('encadrant_these[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Encadrant_these';
  }

}
