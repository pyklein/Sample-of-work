<?php

/**
 * Domaine_scientifique form base class.
 *
 * @method Domaine_scientifique getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseDomaine_scientifiqueForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'intitule'          => new sfWidgetFormInputText(),
      'est_actif'         => new sfWidgetFormInputCheckbox(),
      'utilisateurs_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Utilisateur')),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'intitule'          => new sfValidatorString(array('max_length' => 255)),
      'est_actif'         => new sfValidatorBoolean(array('required' => false)),
      'utilisateurs_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Utilisateur', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('domaine_scientifique[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Domaine_scientifique';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['utilisateurs_list']))
    {
      $this->setDefault('utilisateurs_list', $this->object->Utilisateurs->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveUtilisateursList($con);

    parent::doSave($con);
  }

  public function saveUtilisateursList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['utilisateurs_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Utilisateurs->getPrimaryKeys();
    $values = $this->getValue('utilisateurs_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Utilisateurs', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Utilisateurs', array_values($link));
    }
  }

}
