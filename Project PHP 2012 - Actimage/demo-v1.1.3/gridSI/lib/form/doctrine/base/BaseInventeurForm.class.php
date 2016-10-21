<?php

/**
 * Inventeur form base class.
 *
 * @method Inventeur getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseInventeurForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                       => new sfWidgetFormInputHidden(),
      'civilite_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Civilite'), 'add_empty' => false)),
      'nom'                      => new sfWidgetFormInputText(),
      'prenom'                   => new sfWidgetFormInputText(),
      'date_naissance'           => new sfWidgetFormDate(),
      'date_deces'               => new sfWidgetFormDate(),
      'date_retraite'            => new sfWidgetFormDate(),
      'email'                    => new sfWidgetFormInputText(),
      'email2'                   => new sfWidgetFormInputText(),
      'telephone_fixe'           => new sfWidgetFormInputText(),
      'telephone_mobile'         => new sfWidgetFormInputText(),
      'telephone_autre'          => new sfWidgetFormInputText(),
      'fax'                      => new sfWidgetFormInputText(),
      'email_perso'              => new sfWidgetFormInputText(),
      'adresse_perso'            => new sfWidgetFormInputText(),
      'adresse_perso2'           => new sfWidgetFormInputText(),
      'adresse_perso3'           => new sfWidgetFormInputText(),
      'code_postal_perso'        => new sfWidgetFormInputText(),
      'complement_adresse_perso' => new sfWidgetFormInputText(),
      'ville_id'                 => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Ville'), 'add_empty' => true)),
      'telephone_fixe_perso'     => new sfWidgetFormInputText(),
      'telephone_mobile_perso'   => new sfWidgetFormInputText(),
      'est_exterieur'            => new sfWidgetFormInputCheckbox(),
      'est_actif'                => new sfWidgetFormInputCheckbox(),
      'organisme_mindef_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme_mindef'), 'add_empty' => true)),
      'entite_id'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Entite'), 'add_empty' => true)),
      'grade_id'                 => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Grade'), 'add_empty' => true)),
      'organisme_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme'), 'add_empty' => true)),
      'service_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Service'), 'add_empty' => true)),
      'created_at'               => new sfWidgetFormDateTime(),
      'updated_at'               => new sfWidgetFormDateTime(),
      'created_by'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
      'dossier_bpis_list'        => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Dossier_bpi')),
    ));

    $this->setValidators(array(
      'id'                       => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'civilite_id'              => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Civilite'))),
      'nom'                      => new sfValidatorString(array('max_length' => 255)),
      'prenom'                   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'date_naissance'           => new sfValidatorDate(array('required' => false)),
      'date_deces'               => new sfValidatorDate(array('required' => false)),
      'date_retraite'            => new sfValidatorDate(array('required' => false)),
      'email'                    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'email2'                   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'telephone_fixe'           => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'telephone_mobile'         => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'telephone_autre'          => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'fax'                      => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'email_perso'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'adresse_perso'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'adresse_perso2'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'adresse_perso3'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'code_postal_perso'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'complement_adresse_perso' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'ville_id'                 => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Ville'), 'required' => false)),
      'telephone_fixe_perso'     => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'telephone_mobile_perso'   => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'est_exterieur'            => new sfValidatorBoolean(array('required' => false)),
      'est_actif'                => new sfValidatorBoolean(array('required' => false)),
      'organisme_mindef_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme_mindef'), 'required' => false)),
      'entite_id'                => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Entite'), 'required' => false)),
      'grade_id'                 => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Grade'), 'required' => false)),
      'organisme_id'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme'), 'required' => false)),
      'service_id'               => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Service'), 'required' => false)),
      'created_at'               => new sfValidatorDateTime(),
      'updated_at'               => new sfValidatorDateTime(),
      'created_by'               => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'required' => false)),
      'updated_by'               => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'required' => false)),
      'dossier_bpis_list'        => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Dossier_bpi', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('inventeur[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Inventeur';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['dossier_bpis_list']))
    {
      $this->setDefault('dossier_bpis_list', $this->object->Dossier_bpis->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveDossier_bpisList($con);

    parent::doSave($con);
  }

  public function saveDossier_bpisList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['dossier_bpis_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Dossier_bpis->getPrimaryKeys();
    $values = $this->getValue('dossier_bpis_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Dossier_bpis', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Dossier_bpis', array_values($link));
    }
  }

}
