<?php

/**
 * Dossier_bpi form base class.
 *
 * @method Dossier_bpi getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseDossier_bpiForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                        => new sfWidgetFormInputHidden(),
      'titre'                     => new sfWidgetFormInputText(),
      'description'               => new sfWidgetFormTextarea(),
      'date_predeclaration'       => new sfWidgetFormDate(),
      'date_declaration_conforme' => new sfWidgetFormDate(),
      'est_brevetable'            => new sfWidgetFormInputCheckbox(),
      'numero'                    => new sfWidgetFormInputText(),
      'est_actif'                 => new sfWidgetFormInputCheckbox(),
      'est_clos'                  => new sfWidgetFormInputCheckbox(),
      'date_cloture'              => new sfWidgetFormDate(),
      'commentaire_cloture'       => new sfWidgetFormTextarea(),
      'date_reouverture'          => new sfWidgetFormDate(),
      'commentaire_reouverture'   => new sfWidgetFormTextarea(),
      'autorite_decision_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('AutoriteDecision'), 'add_empty' => true)),
      'hierarchie_locale_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('HierarchieLocale'), 'add_empty' => true)),
      'etat_partage_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Etat_partage'), 'add_empty' => false)),
      'statut_declaration_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Statut_declaration'), 'add_empty' => false)),
      'statut_dossier_bpi_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Statut_dossier_bpi'), 'add_empty' => false)),
      'date_classement'           => new sfWidgetFormDate(),
      'date_classement_cnis'      => new sfWidgetFormDate(),
      'commentaire_classement'    => new sfWidgetFormTextarea(),
      'repertoire_partage'        => new sfWidgetFormInputText(),
      'est_classifie'             => new sfWidgetFormInputCheckbox(),
      'created_at'                => new sfWidgetFormDateTime(),
      'updated_at'                => new sfWidgetFormDateTime(),
      'created_by'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
      'inventeurs_list'           => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Inventeur')),
      'dossiers_mip_list'         => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Dossier_mip')),
    ));

    $this->setValidators(array(
      'id'                        => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'titre'                     => new sfValidatorString(array('max_length' => 255)),
      'description'               => new sfValidatorString(array('required' => false)),
      'date_predeclaration'       => new sfValidatorDate(array('required' => false)),
      'date_declaration_conforme' => new sfValidatorDate(array('required' => false)),
      'est_brevetable'            => new sfValidatorBoolean(array('required' => false)),
      'numero'                    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'est_actif'                 => new sfValidatorBoolean(array('required' => false)),
      'est_clos'                  => new sfValidatorBoolean(array('required' => false)),
      'date_cloture'              => new sfValidatorDate(array('required' => false)),
      'commentaire_cloture'       => new sfValidatorString(array('required' => false)),
      'date_reouverture'          => new sfValidatorDate(array('required' => false)),
      'commentaire_reouverture'   => new sfValidatorString(array('required' => false)),
      'autorite_decision_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('AutoriteDecision'), 'required' => false)),
      'hierarchie_locale_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('HierarchieLocale'), 'required' => false)),
      'etat_partage_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Etat_partage'), 'required' => false)),
      'statut_declaration_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Statut_declaration'))),
      'statut_dossier_bpi_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Statut_dossier_bpi'))),
      'date_classement'           => new sfValidatorDate(array('required' => false)),
      'date_classement_cnis'      => new sfValidatorDate(array('required' => false)),
      'commentaire_classement'    => new sfValidatorString(array('required' => false)),
      'repertoire_partage'        => new sfValidatorString(array('max_length' => 255)),
      'est_classifie'             => new sfValidatorBoolean(array('required' => false)),
      'created_at'                => new sfValidatorDateTime(),
      'updated_at'                => new sfValidatorDateTime(),
      'created_by'                => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'required' => false)),
      'updated_by'                => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'required' => false)),
      'inventeurs_list'           => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Inventeur', 'required' => false)),
      'dossiers_mip_list'         => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Dossier_mip', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('dossier_bpi[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Dossier_bpi';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['inventeurs_list']))
    {
      $this->setDefault('inventeurs_list', $this->object->Inventeurs->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['dossiers_mip_list']))
    {
      $this->setDefault('dossiers_mip_list', $this->object->DossiersMIP->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveInventeursList($con);
    $this->saveDossiersMIPList($con);

    parent::doSave($con);
  }

  public function saveInventeursList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['inventeurs_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Inventeurs->getPrimaryKeys();
    $values = $this->getValue('inventeurs_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Inventeurs', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Inventeurs', array_values($link));
    }
  }

  public function saveDossiersMIPList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['dossiers_mip_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->DossiersMIP->getPrimaryKeys();
    $values = $this->getValue('dossiers_mip_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('DossiersMIP', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('DossiersMIP', array_values($link));
    }
  }

}
