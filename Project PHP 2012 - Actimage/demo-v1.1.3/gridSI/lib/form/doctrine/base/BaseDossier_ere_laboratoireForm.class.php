<?php

/**
 * Dossier_ere_laboratoire form base class.
 *
 * @method Dossier_ere_laboratoire getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseDossier_ere_laboratoireForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'dossier_ere_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_ere'), 'add_empty' => false)),
      'laboratoire_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Laboratoire'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'dossier_ere_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_ere'))),
      'laboratoire_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Laboratoire'))),
    ));

    $this->widgetSchema->setNameFormat('dossier_ere_laboratoire[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Dossier_ere_laboratoire';
  }

}
