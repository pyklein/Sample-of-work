<?php

/**
 * Utilisateur form base class.
 *
 * @method Utilisateur getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseUtilisateurForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                          => new sfWidgetFormInputHidden(),
      'civilite_id'                 => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Civilite'), 'add_empty' => false)),
      'nom'                         => new sfWidgetFormInputText(),
      'nom_jeunefille'              => new sfWidgetFormInputText(),
      'prenom'                      => new sfWidgetFormInputText(),
      'email'                       => new sfWidgetFormInputText(),
      'email2'                      => new sfWidgetFormInputText(),
      'email_perso'                 => new sfWidgetFormInputText(),
      'mot_de_passe'                => new sfWidgetFormInputText(),
      'date_naissance'              => new sfWidgetFormDate(),
      'date_deces'                  => new sfWidgetFormDate(),
      'adresse_perso'               => new sfWidgetFormInputText(),
      'adresse_perso2'              => new sfWidgetFormInputText(),
      'adresse_perso3'              => new sfWidgetFormInputText(),
      'code_postal_perso'           => new sfWidgetFormInputText(),
      'complement_adresse_perso'    => new sfWidgetFormInputText(),
      'ville_perso_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Ville'), 'add_empty' => true)),
      'telephone_fixe'              => new sfWidgetFormInputText(),
      'telephone_mobile'            => new sfWidgetFormInputText(),
      'telephone_autre'             => new sfWidgetFormInputText(),
      'telephone_fixe_perso'        => new sfWidgetFormInputText(),
      'telephone_mobile_perso'      => new sfWidgetFormInputText(),
      'fax'                         => new sfWidgetFormInputText(),
      'photographie'                => new sfWidgetFormInputText(),
      'photographie_orig'           => new sfWidgetFormInputText(),
      'est_actif'                   => new sfWidgetFormInputCheckbox(),
      'uid'                         => new sfWidgetFormInputText(),
      'entite_id'                   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Entite'), 'add_empty' => true)),
      'entite_ancienne_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('EntiteAncienne'), 'add_empty' => true)),
      'organisme_mindef_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme_mindef'), 'add_empty' => true)),
      'grade_id'                    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Grade'), 'add_empty' => true)),
      'statut_id'                   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Statut'), 'add_empty' => true)),
      'est_utilisateur_ldap'        => new sfWidgetFormInputCheckbox(),
      'created_at'                  => new sfWidgetFormDateTime(),
      'updated_at'                  => new sfWidgetFormDateTime(),
      'created_by'                  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'                  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
      'profils_list'                => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Profil')),
      'domaines_scientifiques_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Domaine_scientifique')),
    ));

    $this->setValidators(array(
      'id'                          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'civilite_id'                 => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Civilite'))),
      'nom'                         => new sfValidatorString(array('max_length' => 255)),
      'nom_jeunefille'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'prenom'                      => new sfValidatorString(array('max_length' => 255)),
      'email'                       => new sfValidatorString(array('max_length' => 255)),
      'email2'                      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'email_perso'                 => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'mot_de_passe'                => new sfValidatorString(array('max_length' => 255)),
      'date_naissance'              => new sfValidatorDate(array('required' => false)),
      'date_deces'                  => new sfValidatorDate(array('required' => false)),
      'adresse_perso'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'adresse_perso2'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'adresse_perso3'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'code_postal_perso'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'complement_adresse_perso'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'ville_perso_id'              => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Ville'), 'required' => false)),
      'telephone_fixe'              => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'telephone_mobile'            => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'telephone_autre'             => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'telephone_fixe_perso'        => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'telephone_mobile_perso'      => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'fax'                         => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'photographie'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'photographie_orig'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'est_actif'                   => new sfValidatorBoolean(array('required' => false)),
      'uid'                         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'entite_id'                   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Entite'), 'required' => false)),
      'entite_ancienne_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('EntiteAncienne'), 'required' => false)),
      'organisme_mindef_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme_mindef'), 'required' => false)),
      'grade_id'                    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Grade'), 'required' => false)),
      'statut_id'                   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Statut'), 'required' => false)),
      'est_utilisateur_ldap'        => new sfValidatorBoolean(array('required' => false)),
      'created_at'                  => new sfValidatorDateTime(),
      'updated_at'                  => new sfValidatorDateTime(),
      'created_by'                  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'required' => false)),
      'updated_by'                  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'required' => false)),
      'profils_list'                => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Profil', 'required' => false)),
      'domaines_scientifiques_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Domaine_scientifique', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('utilisateur[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Utilisateur';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['profils_list']))
    {
      $this->setDefault('profils_list', $this->object->Profils->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['domaines_scientifiques_list']))
    {
      $this->setDefault('domaines_scientifiques_list', $this->object->DomainesScientifiques->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveProfilsList($con);
    $this->saveDomainesScientifiquesList($con);

    parent::doSave($con);
  }

  public function saveProfilsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['profils_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Profils->getPrimaryKeys();
    $values = $this->getValue('profils_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Profils', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Profils', array_values($link));
    }
  }

  public function saveDomainesScientifiquesList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['domaines_scientifiques_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->DomainesScientifiques->getPrimaryKeys();
    $values = $this->getValue('domaines_scientifiques_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('DomainesScientifiques', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('DomainesScientifiques', array_values($link));
    }
  }

}
