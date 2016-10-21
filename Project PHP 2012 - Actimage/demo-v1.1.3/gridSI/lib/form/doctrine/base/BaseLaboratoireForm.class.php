<?php

/**
 * Laboratoire form base class.
 *
 * @method Laboratoire getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseLaboratoireForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'intitule'              => new sfWidgetFormInputText(),
      'intitule_ancien'       => new sfWidgetFormInputText(),
      'abreviation'           => new sfWidgetFormInputText(),
      'evaluation_aers'       => new sfWidgetFormInputText(),
      'est_actif'             => new sfWidgetFormInputCheckbox(),
      'service_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Service'), 'add_empty' => true)),
      'organisme_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme'), 'add_empty' => true)),
      'created_at'            => new sfWidgetFormDateTime(),
      'updated_at'            => new sfWidgetFormDateTime(),
      'created_by'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
      'dossiers_these_list'   => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Dossier_these')),
      'dossiers_ere_list'     => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Dossier_ere')),
      'dossiers_postdoc_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Dossier_postdoc')),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'intitule'              => new sfValidatorString(array('max_length' => 255)),
      'intitule_ancien'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'abreviation'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'evaluation_aers'       => new sfValidatorString(array('max_length' => 3, 'required' => false)),
      'est_actif'             => new sfValidatorBoolean(array('required' => false)),
      'service_id'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Service'), 'required' => false)),
      'organisme_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme'), 'required' => false)),
      'created_at'            => new sfValidatorDateTime(),
      'updated_at'            => new sfValidatorDateTime(),
      'created_by'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'required' => false)),
      'updated_by'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'required' => false)),
      'dossiers_these_list'   => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Dossier_these', 'required' => false)),
      'dossiers_ere_list'     => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Dossier_ere', 'required' => false)),
      'dossiers_postdoc_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Dossier_postdoc', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('laboratoire[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Laboratoire';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['dossiers_these_list']))
    {
      $this->setDefault('dossiers_these_list', $this->object->DossiersThese->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['dossiers_ere_list']))
    {
      $this->setDefault('dossiers_ere_list', $this->object->DossiersEre->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['dossiers_postdoc_list']))
    {
      $this->setDefault('dossiers_postdoc_list', $this->object->DossiersPostdoc->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveDossiersTheseList($con);
    $this->saveDossiersEreList($con);
    $this->saveDossiersPostdocList($con);

    parent::doSave($con);
  }

  public function saveDossiersTheseList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['dossiers_these_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->DossiersThese->getPrimaryKeys();
    $values = $this->getValue('dossiers_these_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('DossiersThese', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('DossiersThese', array_values($link));
    }
  }

  public function saveDossiersEreList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['dossiers_ere_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->DossiersEre->getPrimaryKeys();
    $values = $this->getValue('dossiers_ere_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('DossiersEre', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('DossiersEre', array_values($link));
    }
  }

  public function saveDossiersPostdocList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['dossiers_postdoc_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->DossiersPostdoc->getPrimaryKeys();
    $values = $this->getValue('dossiers_postdoc_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('DossiersPostdoc', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('DossiersPostdoc', array_values($link));
    }
  }

}
