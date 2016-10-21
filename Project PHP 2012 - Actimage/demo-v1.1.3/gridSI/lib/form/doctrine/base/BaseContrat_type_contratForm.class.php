<?php

/**
 * Contrat_type_contrat form base class.
 *
 * @method Contrat_type_contrat getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseContrat_type_contratForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'contrat_id'      => new sfWidgetFormInputHidden(),
      'type_contrat_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'contrat_id'      => new sfValidatorChoice(array('choices' => array($this->getObject()->get('contrat_id')), 'empty_value' => $this->getObject()->get('contrat_id'), 'required' => false)),
      'type_contrat_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('type_contrat_id')), 'empty_value' => $this->getObject()->get('type_contrat_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('contrat_type_contrat[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Contrat_type_contrat';
  }

}
