<?php

/**
 * Classement_invention_inventeur form base class.
 *
 * @method Classement_invention_inventeur getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseClassement_invention_inventeurForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                       => new sfWidgetFormInputHidden(),
      'dossier_bpi_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_bpi'), 'add_empty' => false)),
      'concerne_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Concerne'), 'add_empty' => false)),
      'classement_autorite_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Classement_autorite'), 'add_empty' => false)),
      'classement_hierarchie_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Classement_hierarchie'), 'add_empty' => false)),
      'classement_propose_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Classement_propose'), 'add_empty' => false)),
      'classement_final_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Classement_final'), 'add_empty' => false)),
      'created_at'               => new sfWidgetFormDateTime(),
      'updated_at'               => new sfWidgetFormDateTime(),
      'created_by'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                       => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'dossier_bpi_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_bpi'))),
      'concerne_id'              => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Concerne'))),
      'classement_autorite_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Classement_autorite'))),
      'classement_hierarchie_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Classement_hierarchie'))),
      'classement_propose_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Classement_propose'))),
      'classement_final_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Classement_final'))),
      'created_at'               => new sfValidatorDateTime(),
      'updated_at'               => new sfValidatorDateTime(),
      'created_by'               => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'required' => false)),
      'updated_by'               => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('classement_invention_inventeur[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Classement_invention_inventeur';
  }

}
