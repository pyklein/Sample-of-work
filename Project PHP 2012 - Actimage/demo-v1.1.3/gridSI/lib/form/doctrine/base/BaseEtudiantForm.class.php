<?php

/**
 * Etudiant form base class.
 *
 * @method Etudiant getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseEtudiantForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'civilite_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Civilite'), 'add_empty' => false)),
      'nom'                   => new sfWidgetFormInputText(),
      'nom_jeunefille'        => new sfWidgetFormInputText(),
      'prenom'                => new sfWidgetFormInputText(),
      'date_naissance'        => new sfWidgetFormDate(),
      'lieu_naissance'        => new sfWidgetFormInputText(),
      'email'                 => new sfWidgetFormInputText(),
      'email2'                => new sfWidgetFormInputText(),
      'adresse'               => new sfWidgetFormInputText(),
      'adresse2'              => new sfWidgetFormInputText(),
      'adresse3'              => new sfWidgetFormInputText(),
      'code_postal'           => new sfWidgetFormInputText(),
      'complement_adresse'    => new sfWidgetFormInputText(),
      'ville_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Ville'), 'add_empty' => true)),
      'telephone_fixe'        => new sfWidgetFormInputText(),
      'telephone_mobile'      => new sfWidgetFormInputText(),
      'adresse_etrangere'     => new sfWidgetFormTextarea(),
      'pays_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Pays'), 'add_empty' => true)),
      'nationalite_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Nationalite'), 'add_empty' => true)),
      'autre_cursus'          => new sfWidgetFormInputText(),
      'a_master'              => new sfWidgetFormInputCheckbox(),
      'mention'               => new sfWidgetFormInputText(),
      'description_formation' => new sfWidgetFormTextarea(),
      'photographie'          => new sfWidgetFormInputText(),
      'photographie_orig'     => new sfWidgetFormInputText(),
      'type_cursus_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Type_cursus'), 'add_empty' => true)),
      'est_actif'             => new sfWidgetFormInputCheckbox(),
      'created_at'            => new sfWidgetFormDateTime(),
      'updated_at'            => new sfWidgetFormDateTime(),
      'created_by'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'civilite_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Civilite'))),
      'nom'                   => new sfValidatorString(array('max_length' => 255)),
      'nom_jeunefille'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'prenom'                => new sfValidatorString(array('max_length' => 255)),
      'date_naissance'        => new sfValidatorDate(array('required' => false)),
      'lieu_naissance'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'email'                 => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'email2'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'adresse'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'adresse2'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'adresse3'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'code_postal'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'complement_adresse'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'ville_id'              => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Ville'), 'required' => false)),
      'telephone_fixe'        => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'telephone_mobile'      => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'adresse_etrangere'     => new sfValidatorString(array('required' => false)),
      'pays_id'               => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Pays'), 'required' => false)),
      'nationalite_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Nationalite'), 'required' => false)),
      'autre_cursus'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'a_master'              => new sfValidatorBoolean(array('required' => false)),
      'mention'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'description_formation' => new sfValidatorString(array('required' => false)),
      'photographie'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'photographie_orig'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'type_cursus_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Type_cursus'), 'required' => false)),
      'est_actif'             => new sfValidatorBoolean(array('required' => false)),
      'created_at'            => new sfValidatorDateTime(),
      'updated_at'            => new sfValidatorDateTime(),
      'created_by'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'required' => false)),
      'updated_by'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('etudiant[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Etudiant';
  }

}
