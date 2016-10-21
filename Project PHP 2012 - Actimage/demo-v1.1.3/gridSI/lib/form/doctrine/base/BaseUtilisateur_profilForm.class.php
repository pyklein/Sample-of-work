<?php

/**
 * Utilisateur_profil form base class.
 *
 * @method Utilisateur_profil getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseUtilisateur_profilForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'utilisateur_id' => new sfWidgetFormInputHidden(),
      'profil_id'      => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'utilisateur_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('utilisateur_id')), 'empty_value' => $this->getObject()->get('utilisateur_id'), 'required' => false)),
      'profil_id'      => new sfValidatorChoice(array('choices' => array($this->getObject()->get('profil_id')), 'empty_value' => $this->getObject()->get('profil_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('utilisateur_profil[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Utilisateur_profil';
  }

}
