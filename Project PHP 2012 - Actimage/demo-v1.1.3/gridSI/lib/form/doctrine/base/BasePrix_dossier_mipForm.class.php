<?php

/**
 * Prix_dossier_mip form base class.
 *
 * @method Prix_dossier_mip getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasePrix_dossier_mipForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'annee'           => new sfWidgetFormInputText(),
      'est_selectionne' => new sfWidgetFormInputCheckbox(),
      'est_obtenu'      => new sfWidgetFormInputCheckbox(),
      'dossier_mip_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_mip'), 'add_empty' => false)),
      'prix_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Prix'), 'add_empty' => false)),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
      'created_by'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'annee'           => new sfValidatorInteger(),
      'est_selectionne' => new sfValidatorBoolean(array('required' => false)),
      'est_obtenu'      => new sfValidatorBoolean(array('required' => false)),
      'dossier_mip_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_mip'))),
      'prix_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Prix'))),
      'created_at'      => new sfValidatorDateTime(),
      'updated_at'      => new sfValidatorDateTime(),
      'created_by'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'required' => false)),
      'updated_by'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('prix_dossier_mip[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Prix_dossier_mip';
  }

}
