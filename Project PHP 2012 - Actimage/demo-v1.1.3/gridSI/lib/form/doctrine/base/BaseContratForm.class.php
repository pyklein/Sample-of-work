<?php

/**
 * Contrat form base class.
 *
 * @method Contrat getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseContratForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'date_proposition'    => new sfWidgetFormDate(),
      'date_signature'      => new sfWidgetFormDate(),
      'date_inscription_mb' => new sfWidgetFormDate(),
      'numero_mb'           => new sfWidgetFormInputText(),
      'date_redaction'      => new sfWidgetFormDate(),
      'est_actif'           => new sfWidgetFormInputCheckbox(),
      'juriste_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Juriste'), 'add_empty' => true)),
      'statut_contrat_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Statut_contrat'), 'add_empty' => false)),
      'dossier_bpi_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_bpi'), 'add_empty' => false)),
      'created_at'          => new sfWidgetFormDateTime(),
      'updated_at'          => new sfWidgetFormDateTime(),
      'created_by'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
      'type_contrats_list'  => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Type_contrat')),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'date_proposition'    => new sfValidatorDate(array('required' => false)),
      'date_signature'      => new sfValidatorDate(array('required' => false)),
      'date_inscription_mb' => new sfValidatorDate(array('required' => false)),
      'numero_mb'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'date_redaction'      => new sfValidatorDate(array('required' => false)),
      'est_actif'           => new sfValidatorBoolean(array('required' => false)),
      'juriste_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Juriste'), 'required' => false)),
      'statut_contrat_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Statut_contrat'))),
      'dossier_bpi_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_bpi'))),
      'created_at'          => new sfValidatorDateTime(),
      'updated_at'          => new sfValidatorDateTime(),
      'created_by'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'required' => false)),
      'updated_by'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'required' => false)),
      'type_contrats_list'  => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Type_contrat', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('contrat[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Contrat';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['type_contrats_list']))
    {
      $this->setDefault('type_contrats_list', $this->object->Type_contrats->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveType_contratsList($con);

    parent::doSave($con);
  }

  public function saveType_contratsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['type_contrats_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Type_contrats->getPrimaryKeys();
    $values = $this->getValue('type_contrats_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Type_contrats', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Type_contrats', array_values($link));
    }
  }

}
