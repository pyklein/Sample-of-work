<?php

/**
 * Attribution_droit form base class.
 *
 * @method Attribution_droit getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseAttribution_droitForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                        => new sfWidgetFormInputHidden(),
      'echeance_supplementaire'   => new sfWidgetFormDate(),
      'droits_attribues'          => new sfWidgetFormInputCheckbox(),
      'date_decision_attribution' => new sfWidgetFormDate(),
      'commentaire'               => new sfWidgetFormTextarea(),
      'date_envoi_contrat'        => new sfWidgetFormDate(),
      'redaction_brevet_lance'    => new sfWidgetFormInputCheckbox(),
      'contrat_id'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Contrat'), 'add_empty' => true)),
      'brevet_id'                 => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Brevet'), 'add_empty' => true)),
      'dossier_bpi_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_bpi'), 'add_empty' => false)),
      'created_at'                => new sfWidgetFormDateTime(),
      'updated_at'                => new sfWidgetFormDateTime(),
      'created_by'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                        => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'echeance_supplementaire'   => new sfValidatorDate(array('required' => false)),
      'droits_attribues'          => new sfValidatorBoolean(array('required' => false)),
      'date_decision_attribution' => new sfValidatorDate(array('required' => false)),
      'commentaire'               => new sfValidatorString(array('required' => false)),
      'date_envoi_contrat'        => new sfValidatorDate(array('required' => false)),
      'redaction_brevet_lance'    => new sfValidatorBoolean(array('required' => false)),
      'contrat_id'                => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Contrat'), 'required' => false)),
      'brevet_id'                 => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Brevet'), 'required' => false)),
      'dossier_bpi_id'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_bpi'))),
      'created_at'                => new sfValidatorDateTime(),
      'updated_at'                => new sfValidatorDateTime(),
      'created_by'                => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'required' => false)),
      'updated_by'                => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('attribution_droit[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Attribution_droit';
  }

}
