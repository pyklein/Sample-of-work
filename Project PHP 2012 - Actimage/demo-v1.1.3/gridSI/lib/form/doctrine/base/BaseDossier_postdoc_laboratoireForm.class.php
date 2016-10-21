<?php

/**
 * Dossier_postdoc_laboratoire form base class.
 *
 * @method Dossier_postdoc_laboratoire getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseDossier_postdoc_laboratoireForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'dossier_postdoc_id' => new sfWidgetFormInputHidden(),
      'laboratoire_id'     => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'dossier_postdoc_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('dossier_postdoc_id')), 'empty_value' => $this->getObject()->get('dossier_postdoc_id'), 'required' => false)),
      'laboratoire_id'     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('laboratoire_id')), 'empty_value' => $this->getObject()->get('laboratoire_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('dossier_postdoc_laboratoire[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Dossier_postdoc_laboratoire';
  }

}
