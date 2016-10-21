<?php

/**
 * Part_inventive form base class.
 *
 * @method Part_inventive getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasePart_inventiveForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'inventeur_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Inventeur'), 'add_empty' => false)),
      'dossier_bpi_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_bpi'), 'add_empty' => false)),
      'part_inventive' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'inventeur_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Inventeur'))),
      'dossier_bpi_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_bpi'))),
      'part_inventive' => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('part_inventive[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Part_inventive';
  }

}
