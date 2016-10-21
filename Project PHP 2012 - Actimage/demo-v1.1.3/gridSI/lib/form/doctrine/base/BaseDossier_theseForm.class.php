<?php

/**
 * Dossier_these form base class.
 *
 * @method Dossier_these getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseDossier_theseForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                           => new sfWidgetFormInputHidden(),
      'numero'                       => new sfWidgetFormInputText(),
      'titre'                        => new sfWidgetFormInputText(),
      'objet'                        => new sfWidgetFormTextarea(),
      'fichier_editable'             => new sfWidgetFormInputText(),
      'fichier_editable_orig'        => new sfWidgetFormInputText(),
      'fichier_pdf'                  => new sfWidgetFormInputText(),
      'fichier_pdf_orig'             => new sfWidgetFormInputText(),
      'classement'                   => new sfWidgetFormInputText(),
      'est_actif'                    => new sfWidgetFormInputCheckbox(),
      'cotutelle'                    => new sfWidgetFormInputCheckbox(),
      'cooperation'                  => new sfWidgetFormInputCheckbox(),
      'statut_dossier_these_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Statut_dossier_these'), 'add_empty' => true)),
      'domaine_scientifique_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Domaine_scientifique'), 'add_empty' => true)),
      'organisme_mindef_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme_mindef'), 'add_empty' => true)),
      'organisme_id'                 => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme'), 'add_empty' => true)),
      'realise_par'                  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Etudiant'), 'add_empty' => true)),
      'pilote_par'                   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('PilotePar'), 'add_empty' => true)),
      'etat_partage_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Etat_partage'), 'add_empty' => true)),
      'type_convention_organisme_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Type_convention_organisme'), 'add_empty' => false)),
      'mis_en_attente_le'            => new sfWidgetFormDateTime(),
      'repertoire_partage'           => new sfWidgetFormInputText(),
      'created_at'                   => new sfWidgetFormDateTime(),
      'updated_at'                   => new sfWidgetFormDateTime(),
      'created_by'                   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'                   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
      'laboratoires_list'            => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Laboratoire')),
      'avis_mris_list'               => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Avis_mris')),
    ));

    $this->setValidators(array(
      'id'                           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'numero'                       => new sfValidatorString(array('max_length' => 255)),
      'titre'                        => new sfValidatorString(array('max_length' => 255)),
      'objet'                        => new sfValidatorString(array('required' => false)),
      'fichier_editable'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'fichier_editable_orig'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'fichier_pdf'                  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'fichier_pdf_orig'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'classement'                   => new sfValidatorInteger(array('required' => false)),
      'est_actif'                    => new sfValidatorBoolean(array('required' => false)),
      'cotutelle'                    => new sfValidatorBoolean(array('required' => false)),
      'cooperation'                  => new sfValidatorBoolean(array('required' => false)),
      'statut_dossier_these_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Statut_dossier_these'), 'required' => false)),
      'domaine_scientifique_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Domaine_scientifique'), 'required' => false)),
      'organisme_mindef_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme_mindef'), 'required' => false)),
      'organisme_id'                 => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme'), 'required' => false)),
      'realise_par'                  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Etudiant'), 'required' => false)),
      'pilote_par'                   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('PilotePar'), 'required' => false)),
      'etat_partage_id'              => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Etat_partage'), 'required' => false)),
      'type_convention_organisme_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Type_convention_organisme'))),
      'mis_en_attente_le'            => new sfValidatorDateTime(array('required' => false)),
      'repertoire_partage'           => new sfValidatorString(array('max_length' => 255)),
      'created_at'                   => new sfValidatorDateTime(),
      'updated_at'                   => new sfValidatorDateTime(),
      'created_by'                   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'required' => false)),
      'updated_by'                   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'required' => false)),
      'laboratoires_list'            => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Laboratoire', 'required' => false)),
      'avis_mris_list'               => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Avis_mris', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('dossier_these[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Dossier_these';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['laboratoires_list']))
    {
      $this->setDefault('laboratoires_list', $this->object->Laboratoires->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['avis_mris_list']))
    {
      $this->setDefault('avis_mris_list', $this->object->Avis_mris->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveLaboratoiresList($con);
    $this->saveAvis_mrisList($con);

    parent::doSave($con);
  }

  public function saveLaboratoiresList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['laboratoires_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Laboratoires->getPrimaryKeys();
    $values = $this->getValue('laboratoires_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Laboratoires', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Laboratoires', array_values($link));
    }
  }

  public function saveAvis_mrisList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['avis_mris_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Avis_mris->getPrimaryKeys();
    $values = $this->getValue('avis_mris_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Avis_mris', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Avis_mris', array_values($link));
    }
  }

}
