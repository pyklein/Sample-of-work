<?php

/**
 * Encadrant_postdoc form base class.
 *
 * @method Encadrant_postdoc getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseEncadrant_postdocForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'dossier_postdoc_id' => new sfWidgetFormInputHidden(),
      'intervenant_id'     => new sfWidgetFormInputHidden(),
      'role_postdoc_id'    => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'dossier_postdoc_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('dossier_postdoc_id')), 'empty_value' => $this->getObject()->get('dossier_postdoc_id'), 'required' => false)),
      'intervenant_id'     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('intervenant_id')), 'empty_value' => $this->getObject()->get('intervenant_id'), 'required' => false)),
      'role_postdoc_id'    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('role_postdoc_id')), 'empty_value' => $this->getObject()->get('role_postdoc_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('encadrant_postdoc[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Encadrant_postdoc';
  }

}
