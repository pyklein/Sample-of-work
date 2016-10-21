<?php

/**
 * Liaison_mip_bpi form base class.
 *
 * @method Liaison_mip_bpi getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseLiaison_mip_bpiForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'dossier_mip_id' => new sfWidgetFormInputHidden(),
      'dossier_bpi_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'dossier_mip_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('dossier_mip_id')), 'empty_value' => $this->getObject()->get('dossier_mip_id'), 'required' => false)),
      'dossier_bpi_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('dossier_bpi_id')), 'empty_value' => $this->getObject()->get('dossier_bpi_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('liaison_mip_bpi[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Liaison_mip_bpi';
  }

}
