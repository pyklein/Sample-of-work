<?php

/**
 * Aboutissement_these form base class.
 *
 * @method Aboutissement_these getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseAboutissement_theseForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                           => new sfWidgetFormInputHidden(),
      'est_preselectionne_prix'      => new sfWidgetFormInputCheckbox(),
      'est_selectionne_prix'         => new sfWidgetFormInputCheckbox(),
      'reception_exemplaire_these'   => new sfWidgetFormDate(),
      'reception_rapport_soutenance' => new sfWidgetFormDate(),
      'reception_liste_publication'  => new sfWidgetFormDate(),
      'reception_fiche_evaluation'   => new sfWidgetFormDate(),
      'reception_synthese'           => new sfWidgetFormDate(),
      'date_soutenance'              => new sfWidgetFormDate(),
      'dossier_these_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_these'), 'add_empty' => false)),
      'created_at'                   => new sfWidgetFormDateTime(),
      'updated_at'                   => new sfWidgetFormDateTime(),
      'created_by'                   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'                   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'est_preselectionne_prix'      => new sfValidatorBoolean(array('required' => false)),
      'est_selectionne_prix'         => new sfValidatorBoolean(array('required' => false)),
      'reception_exemplaire_these'   => new sfValidatorDate(array('required' => false)),
      'reception_rapport_soutenance' => new sfValidatorDate(array('required' => false)),
      'reception_liste_publication'  => new sfValidatorDate(array('required' => false)),
      'reception_fiche_evaluation'   => new sfValidatorDate(array('required' => false)),
      'reception_synthese'           => new sfValidatorDate(array('required' => false)),
      'date_soutenance'              => new sfValidatorDate(array('required' => false)),
      'dossier_these_id'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_these'))),
      'created_at'                   => new sfValidatorDateTime(),
      'updated_at'                   => new sfValidatorDateTime(),
      'created_by'                   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'required' => false)),
      'updated_by'                   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('aboutissement_these[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Aboutissement_these';
  }

}
