<?php

/**
 * Contentieux_avec_tiers form base class.
 *
 * @method Contentieux_avec_tiers getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Antonin KALK
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseContentieux_avec_tiersForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                        => new sfWidgetFormInputHidden(),
      'organisme_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme'), 'add_empty' => false)),
      'type_contentieux_tiers_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Type_contentieux_tiers'), 'add_empty' => false)),
      'est_desaccord'             => new sfWidgetFormInputCheckbox(),
      'commentaire_desaccord'     => new sfWidgetFormTextarea(),
      'date_accord'               => new sfWidgetFormDate(),
      'created_at'                => new sfWidgetFormDateTime(),
      'updated_at'                => new sfWidgetFormDateTime(),
      'created_by'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'                => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                        => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'organisme_id'              => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme'))),
      'type_contentieux_tiers_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Type_contentieux_tiers'))),
      'est_desaccord'             => new sfValidatorBoolean(array('required' => false)),
      'commentaire_desaccord'     => new sfValidatorString(array('required' => false)),
      'date_accord'               => new sfValidatorDate(array('required' => false)),
      'created_at'                => new sfValidatorDateTime(),
      'updated_at'                => new sfValidatorDateTime(),
      'created_by'                => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'required' => false)),
      'updated_by'                => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('contentieux_avec_tiers[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Contentieux_avec_tiers';
  }

}
