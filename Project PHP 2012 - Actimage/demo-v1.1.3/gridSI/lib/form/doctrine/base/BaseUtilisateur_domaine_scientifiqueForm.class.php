<?php

/**
 * Utilisateur_domaine_scientifique form base class.
 *
 * @method Utilisateur_domaine_scientifique getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseUtilisateur_domaine_scientifiqueForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'utilisateur_id'          => new sfWidgetFormInputHidden(),
      'domaine_scientifique_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'utilisateur_id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('utilisateur_id')), 'empty_value' => $this->getObject()->get('utilisateur_id'), 'required' => false)),
      'domaine_scientifique_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('domaine_scientifique_id')), 'empty_value' => $this->getObject()->get('domaine_scientifique_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('utilisateur_domaine_scientifique[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Utilisateur_domaine_scientifique';
  }

}
