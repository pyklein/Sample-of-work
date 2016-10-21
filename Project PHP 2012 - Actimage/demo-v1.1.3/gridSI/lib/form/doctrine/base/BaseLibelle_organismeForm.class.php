<?php

/**
 * Libelle_organisme form base class.
 *
 * @method Libelle_organisme getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseLibelle_organismeForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'libelle_simple'      => new sfWidgetFormInputText(),
      'libelle_liste'       => new sfWidgetFormInputText(),
      'metier_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Metier'), 'add_empty' => false)),
      'organisme_mindef_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme_mindef'), 'add_empty' => false)),
      'created_at'          => new sfWidgetFormDateTime(),
      'updated_at'          => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'libelle_simple'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'libelle_liste'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'metier_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Metier'))),
      'organisme_mindef_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme_mindef'))),
      'created_at'          => new sfValidatorDateTime(),
      'updated_at'          => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('libelle_organisme[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Libelle_organisme';
  }

}
