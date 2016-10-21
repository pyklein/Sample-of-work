<?php

/**
 * Demande_brevet form base class.
 *
 * @method Demande_brevet getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseDemande_brevetForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'numero_demande'         => new sfWidgetFormInputText(),
      'numero_publication'     => new sfWidgetFormInputText(),
      'titre'                  => new sfWidgetFormInputText(),
      'date_decision_depot'    => new sfWidgetFormDate(),
      'date_objectif_depot'    => new sfWidgetFormDate(),
      'date_depot'             => new sfWidgetFormDate(),
      'date_rapport_recherche' => new sfWidgetFormDate(),
      'date_obtention'         => new sfWidgetFormDate(),
      'date_rejet'             => new sfWidgetFormDate(),
      'date_cession'           => new sfWidgetFormDate(),
      'parent_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Parent'), 'add_empty' => true)),
      'contrat_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Contrat'), 'add_empty' => true)),
      'pays_id'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Pays'), 'add_empty' => false)),
      'type_depot_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Type_depot'), 'add_empty' => false)),
      'dossier_bpi_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_bpi'), 'add_empty' => false)),
      'responsable_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Responsable'), 'add_empty' => false)),
      'phase_depot_brevet_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Phase_depot_brevet'), 'add_empty' => false)),
      'created_by'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
      'created_at'             => new sfWidgetFormDateTime(),
      'updated_at'             => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'numero_demande'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'numero_publication'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'titre'                  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'date_decision_depot'    => new sfValidatorDate(array('required' => false)),
      'date_objectif_depot'    => new sfValidatorDate(array('required' => false)),
      'date_depot'             => new sfValidatorDate(array('required' => false)),
      'date_rapport_recherche' => new sfValidatorDate(array('required' => false)),
      'date_obtention'         => new sfValidatorDate(array('required' => false)),
      'date_rejet'             => new sfValidatorDate(array('required' => false)),
      'date_cession'           => new sfValidatorDate(array('required' => false)),
      'parent_id'              => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Parent'), 'required' => false)),
      'contrat_id'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Contrat'), 'required' => false)),
      'pays_id'                => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Pays'))),
      'type_depot_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Type_depot'))),
      'dossier_bpi_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_bpi'))),
      'responsable_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Responsable'))),
      'phase_depot_brevet_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Phase_depot_brevet'))),
      'created_by'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'required' => false)),
      'updated_by'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'required' => false)),
      'created_at'             => new sfValidatorDateTime(),
      'updated_at'             => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('demande_brevet[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Demande_brevet';
  }

}
