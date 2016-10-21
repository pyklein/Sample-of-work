<?php

/**
 * Commission form base class.
 *
 * @method Commission getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCommissionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'ordre_jour'           => new sfWidgetFormInputText(),
      'est_selection'        => new sfWidgetFormInputCheckbox(),
      'est_suivi'            => new sfWidgetFormInputCheckbox(),
      'est_analyse'          => new sfWidgetFormInputCheckbox(),
      'date_debut'           => new sfWidgetFormDateTime(),
      'date_fin'             => new sfWidgetFormDateTime(),
      'est_actif'            => new sfWidgetFormInputCheckbox(),
      'type_dossier_mris_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Type_dossier_mris'), 'add_empty' => true)),
      'created_at'           => new sfWidgetFormDateTime(),
      'updated_at'           => new sfWidgetFormDateTime(),
      'created_by'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
      'utilisateurs_list'    => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Utilisateur')),
      'intervenants_list'    => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Intervenant')),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'ordre_jour'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'est_selection'        => new sfValidatorBoolean(array('required' => false)),
      'est_suivi'            => new sfValidatorBoolean(array('required' => false)),
      'est_analyse'          => new sfValidatorBoolean(array('required' => false)),
      'date_debut'           => new sfValidatorDateTime(array('required' => false)),
      'date_fin'             => new sfValidatorDateTime(array('required' => false)),
      'est_actif'            => new sfValidatorBoolean(array('required' => false)),
      'type_dossier_mris_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Type_dossier_mris'), 'required' => false)),
      'created_at'           => new sfValidatorDateTime(),
      'updated_at'           => new sfValidatorDateTime(),
      'created_by'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'required' => false)),
      'updated_by'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'required' => false)),
      'utilisateurs_list'    => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Utilisateur', 'required' => false)),
      'intervenants_list'    => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Intervenant', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('commission[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Commission';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['utilisateurs_list']))
    {
      $this->setDefault('utilisateurs_list', $this->object->Utilisateurs->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['intervenants_list']))
    {
      $this->setDefault('intervenants_list', $this->object->Intervenants->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveUtilisateursList($con);
    $this->saveIntervenantsList($con);

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

  public function saveIntervenantsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['intervenants_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Intervenants->getPrimaryKeys();
    $values = $this->getValue('intervenants_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Intervenants', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Intervenants', array_values($link));
    }
  }

}
