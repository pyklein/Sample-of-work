<?php

/**
 * Redevance form base class.
 *
 * @method Redevance getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseRedevanceForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'montant'           => new sfWidgetFormInputText(),
      'date_versement'    => new sfWidgetFormDate(),
      'dossier_bpi_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_bpi'), 'add_empty' => false)),
      'contrat_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Contrat'), 'add_empty' => true)),
      'type_redevance_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Type_redevance'), 'add_empty' => false)),
      'organisme_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme'), 'add_empty' => false)),
      'est_actif'         => new sfWidgetFormInputCheckbox(),
      'created_at'        => new sfWidgetFormDateTime(),
      'updated_at'        => new sfWidgetFormDateTime(),
      'created_by'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'montant'           => new sfValidatorNumber(array('required' => false)),
      'date_versement'    => new sfValidatorDate(array('required' => false)),
      'dossier_bpi_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_bpi'))),
      'contrat_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Contrat'), 'required' => false)),
      'type_redevance_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Type_redevance'))),
      'organisme_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme'))),
      'est_actif'         => new sfValidatorBoolean(array('required' => false)),
      'created_at'        => new sfValidatorDateTime(),
      'updated_at'        => new sfValidatorDateTime(),
      'created_by'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'required' => false)),
      'updated_by'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('redevance[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Redevance';
  }

}
