<?php

/**
 * Valorisation form base class.
 *
 * @method Valorisation getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseValorisationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                                  => new sfWidgetFormInputHidden(),
      'date_demande_generalisation'         => new sfWidgetFormDateTime(),
      'destinataire_demande_generalisation' => new sfWidgetFormInputText(),
      'avantage_inconvenient'               => new sfWidgetFormInputText(),
      'retour_experience'                   => new sfWidgetFormInputText(),
      'fiche_internet'                      => new sfWidgetFormInputText(),
      'dossier_mip_id'                      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_mip'), 'add_empty' => false)),
      'created_at'                          => new sfWidgetFormDateTime(),
      'updated_at'                          => new sfWidgetFormDateTime(),
      'created_by'                          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'                          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                                  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'date_demande_generalisation'         => new sfValidatorDateTime(array('required' => false)),
      'destinataire_demande_generalisation' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'avantage_inconvenient'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'retour_experience'                   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'fiche_internet'                      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'dossier_mip_id'                      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_mip'))),
      'created_at'                          => new sfValidatorDateTime(),
      'updated_at'                          => new sfValidatorDateTime(),
      'created_by'                          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'required' => false)),
      'updated_by'                          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('valorisation[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Valorisation';
  }

}
