<?php

/**
 * Avis_mris form base class.
 *
 * @method Avis_mris getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseAvis_mrisForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'date_avis'             => new sfWidgetFormDate(),
      'date_envoi_lettre'     => new sfWidgetFormDate(),
      'est_satisfaisant'      => new sfWidgetFormInputCheckbox(),
      'dossier_these_id'      => new sfWidgetFormInputText(),
      'dossier_ere_id'        => new sfWidgetFormInputText(),
      'dossier_postdoc_id'    => new sfWidgetFormInputText(),
      'created_at'            => new sfWidgetFormDateTime(),
      'updated_at'            => new sfWidgetFormDateTime(),
      'created_by'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
      'dossier_theses_list'   => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Dossier_these')),
      'dossier_eres_list'     => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Dossier_ere')),
      'dossier_postdocs_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Dossier_postdoc')),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'date_avis'             => new sfValidatorDate(array('required' => false)),
      'date_envoi_lettre'     => new sfValidatorDate(array('required' => false)),
      'est_satisfaisant'      => new sfValidatorBoolean(array('required' => false)),
      'dossier_these_id'      => new sfValidatorInteger(array('required' => false)),
      'dossier_ere_id'        => new sfValidatorInteger(array('required' => false)),
      'dossier_postdoc_id'    => new sfValidatorInteger(array('required' => false)),
      'created_at'            => new sfValidatorDateTime(),
      'updated_at'            => new sfValidatorDateTime(),
      'created_by'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'required' => false)),
      'updated_by'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'required' => false)),
      'dossier_theses_list'   => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Dossier_these', 'required' => false)),
      'dossier_eres_list'     => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Dossier_ere', 'required' => false)),
      'dossier_postdocs_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Dossier_postdoc', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('avis_mris[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Avis_mris';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['dossier_theses_list']))
    {
      $this->setDefault('dossier_theses_list', $this->object->Dossier_theses->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['dossier_eres_list']))
    {
      $this->setDefault('dossier_eres_list', $this->object->Dossier_eres->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['dossier_postdocs_list']))
    {
      $this->setDefault('dossier_postdocs_list', $this->object->Dossier_postdocs->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveDossier_thesesList($con);
    $this->saveDossier_eresList($con);
    $this->saveDossier_postdocsList($con);

    parent::doSave($con);
  }

  public function saveDossier_thesesList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['dossier_theses_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Dossier_theses->getPrimaryKeys();
    $values = $this->getValue('dossier_theses_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Dossier_theses', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Dossier_theses', array_values($link));
    }
  }

  public function saveDossier_eresList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['dossier_eres_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Dossier_eres->getPrimaryKeys();
    $values = $this->getValue('dossier_eres_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Dossier_eres', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Dossier_eres', array_values($link));
    }
  }

  public function saveDossier_postdocsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['dossier_postdocs_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Dossier_postdocs->getPrimaryKeys();
    $values = $this->getValue('dossier_postdocs_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Dossier_postdocs', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Dossier_postdocs', array_values($link));
    }
  }

}
