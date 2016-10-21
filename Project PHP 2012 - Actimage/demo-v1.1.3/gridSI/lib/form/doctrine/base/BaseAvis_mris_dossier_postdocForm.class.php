<?php

/**
 * Avis_mris_dossier_postdoc form base class.
 *
 * @method Avis_mris_dossier_postdoc getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseAvis_mris_dossier_postdocForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'avis_mris_id'       => new sfWidgetFormInputHidden(),
      'dossier_postdoc_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'avis_mris_id'       => new sfValidatorChoice(array('choices' => array($this->getObject()->get('avis_mris_id')), 'empty_value' => $this->getObject()->get('avis_mris_id'), 'required' => false)),
      'dossier_postdoc_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('dossier_postdoc_id')), 'empty_value' => $this->getObject()->get('dossier_postdoc_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('avis_mris_dossier_postdoc[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Avis_mris_dossier_postdoc';
  }

}
