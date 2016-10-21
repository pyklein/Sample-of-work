<?php

/**
 * Statut_declaration form base class.
 *
 * @method Statut_declaration getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseStatut_declarationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'intitule'              => new sfWidgetFormInputText(),
      'abreviation'           => new sfWidgetFormInputText(),
      'est_actif'             => new sfWidgetFormInputCheckbox(),
      'statut_declaration_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Statut_declaration'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'intitule'              => new sfValidatorString(array('max_length' => 255)),
      'abreviation'           => new sfValidatorString(array('max_length' => 255)),
      'est_actif'             => new sfValidatorBoolean(array('required' => false)),
      'statut_declaration_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Statut_declaration'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('statut_declaration[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Statut_declaration';
  }

}
