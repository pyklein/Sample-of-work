<?php

/**
 * Profil form base class.
 *
 * @method Profil getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseProfilForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'intitule'          => new sfWidgetFormInputText(),
      'code'              => new sfWidgetFormInputText(),
      'metier_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Metier'), 'add_empty' => false)),
      'priorite'          => new sfWidgetFormInputText(),
      'utilisateurs_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Utilisateur')),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'intitule'          => new sfValidatorString(array('max_length' => 255)),
      'code'              => new sfValidatorString(array('max_length' => 255)),
      'metier_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Metier'))),
      'priorite'          => new sfValidatorInteger(),
      'utilisateurs_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Utilisateur', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('profil[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Profil';
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
