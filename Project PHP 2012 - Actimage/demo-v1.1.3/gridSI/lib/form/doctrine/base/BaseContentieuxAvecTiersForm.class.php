<?php

/**
 * ContentieuxAvecTiers form base class.
 *
 * @method ContentieuxAvecTiers getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseContentieuxAvecTiersForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'part_inventive_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Part_inventive'), 'add_empty' => false)),
      'type_contentieux_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Type_contentieux'), 'add_empty' => false)),
      'est_desaccord'         => new sfWidgetFormInputCheckbox(),
      'commentaire_desaccord' => new sfWidgetFormTextarea(),
      'date_demande_cnis'     => new sfWidgetFormDate(),
      'date_cnis'             => new sfWidgetFormDate(),
      'decision_cnis'         => new sfWidgetFormTextarea(),
      'date_accord'           => new sfWidgetFormDate(),
      'created_at'            => new sfWidgetFormDateTime(),
      'updated_at'            => new sfWidgetFormDateTime(),
      'created_by'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'part_inventive_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Part_inventive'))),
      'type_contentieux_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Type_contentieux'))),
      'est_desaccord'         => new sfValidatorBoolean(array('required' => false)),
      'commentaire_desaccord' => new sfValidatorString(array('required' => false)),
      'date_demande_cnis'     => new sfValidatorDate(array('required' => false)),
      'date_cnis'             => new sfValidatorDate(array('required' => false)),
      'decision_cnis'         => new sfValidatorString(array('required' => false)),
      'date_accord'           => new sfValidatorDate(array('required' => false)),
      'created_at'            => new sfValidatorDateTime(),
      'updated_at'            => new sfValidatorDateTime(),
      'created_by'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'required' => false)),
      'updated_by'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('contentieux_avec_tiers[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ContentieuxAvecTiers';
  }

}
