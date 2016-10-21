<?php

/**
 * Tache form base class.
 *
 * @method Tache getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseTacheForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'cle'      => new sfWidgetFormInputHidden(),
      'debut'    => new sfWidgetFormDateTime(),
      'fin'      => new sfWidgetFormDateTime(),
      'pid'      => new sfWidgetFormInputText(),
      'erreur'   => new sfWidgetFormInputCheckbox(),
      'resultat' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'cle'      => new sfValidatorChoice(array('choices' => array($this->getObject()->get('cle')), 'empty_value' => $this->getObject()->get('cle'), 'required' => false)),
      'debut'    => new sfValidatorDateTime(array('required' => false)),
      'fin'      => new sfValidatorDateTime(array('required' => false)),
      'pid'      => new sfValidatorInteger(array('required' => false)),
      'erreur'   => new sfValidatorBoolean(),
      'resultat' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tache[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Tache';
  }

}
