<?php

/**
 * Dossier_mip form base class.
 *
 * @method Dossier_mip getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseDossier_mipForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'numero'                => new sfWidgetFormInputText(),
      'titre'                 => new sfWidgetFormInputText(),
      'acronyme'              => new sfWidgetFormInputText(),
      'descriptif'            => new sfWidgetFormTextarea(),
      'etat_partage_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Etat_partage'), 'add_empty' => true)),
      'est_publie'            => new sfWidgetFormInputCheckbox(),
      'dossier_vivant'        => new sfWidgetFormInputCheckbox(),
      'photographie'          => new sfWidgetFormInputText(),
      'photographie_orig'     => new sfWidgetFormInputText(),
      'repertoire_partage'    => new sfWidgetFormInputText(),
      'statut_dossier_mip_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Statut_dossier_mip'), 'add_empty' => true)),
      'niveau_protection_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Niveau_protection'), 'add_empty' => true)),
      'pilote_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Pilote'), 'add_empty' => true)),
      'organisme_mindef_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme_mindef'), 'add_empty' => false)),
      'statut_projet_mip_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Statut_projet_mip'), 'add_empty' => false)),
      'est_actif'             => new sfWidgetFormInputCheckbox(),
      'necessite_controle'    => new sfWidgetFormInputText(),
      'date_bascule'          => new sfWidgetFormDateTime(),
      'created_at'            => new sfWidgetFormDateTime(),
      'updated_at'            => new sfWidgetFormDateTime(),
      'created_by'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
      'dossiers_bpi_list'     => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Dossier_bpi')),
      'innovateurs_list'      => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Utilisateur')),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'numero'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'titre'                 => new sfValidatorString(array('max_length' => 255)),
      'acronyme'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'descriptif'            => new sfValidatorString(array('required' => false)),
      'etat_partage_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Etat_partage'), 'required' => false)),
      'est_publie'            => new sfValidatorBoolean(array('required' => false)),
      'dossier_vivant'        => new sfValidatorBoolean(array('required' => false)),
      'photographie'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'photographie_orig'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'repertoire_partage'    => new sfValidatorString(array('max_length' => 255)),
      'statut_dossier_mip_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Statut_dossier_mip'), 'required' => false)),
      'niveau_protection_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Niveau_protection'), 'required' => false)),
      'pilote_id'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Pilote'), 'required' => false)),
      'organisme_mindef_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme_mindef'))),
      'statut_projet_mip_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Statut_projet_mip'), 'required' => false)),
      'est_actif'             => new sfValidatorBoolean(array('required' => false)),
      'necessite_controle'    => new sfValidatorPass(array('required' => false)),
      'date_bascule'          => new sfValidatorDateTime(array('required' => false)),
      'created_at'            => new sfValidatorDateTime(),
      'updated_at'            => new sfValidatorDateTime(),
      'created_by'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'required' => false)),
      'updated_by'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'required' => false)),
      'dossiers_bpi_list'     => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Dossier_bpi', 'required' => false)),
      'innovateurs_list'      => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Utilisateur', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('dossier_mip[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Dossier_mip';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['dossiers_bpi_list']))
    {
      $this->setDefault('dossiers_bpi_list', $this->object->DossiersBPI->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['innovateurs_list']))
    {
      $this->setDefault('innovateurs_list', $this->object->Innovateurs->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveDossiersBPIList($con);
    $this->saveInnovateursList($con);

    parent::doSave($con);
  }

  public function saveDossiersBPIList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['dossiers_bpi_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->DossiersBPI->getPrimaryKeys();
    $values = $this->getValue('dossiers_bpi_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('DossiersBPI', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('DossiersBPI', array_values($link));
    }
  }

  public function saveInnovateursList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['innovateurs_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Innovateurs->getPrimaryKeys();
    $values = $this->getValue('innovateurs_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Innovateurs', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Innovateurs', array_values($link));
    }
  }

}
