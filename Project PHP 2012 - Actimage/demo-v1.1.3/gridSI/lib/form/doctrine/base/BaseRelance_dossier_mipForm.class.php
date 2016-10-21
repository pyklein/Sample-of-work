<?php

/**
 * Relance_dossier_mip form base class.
 *
 * @method Relance_dossier_mip getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseRelance_dossier_mipForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                          => new sfWidgetFormInputHidden(),
      'dossier_mip_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DossierMIP'), 'add_empty' => false)),
      'type_relance_dossier_mip_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TypeRelance'), 'add_empty' => false)),
      'created_at'                  => new sfWidgetFormDateTime(),
      'updated_at'                  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'dossier_mip_id'              => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('DossierMIP'))),
      'type_relance_dossier_mip_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TypeRelance'))),
      'created_at'                  => new sfValidatorDateTime(),
      'updated_at'                  => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('relance_dossier_mip[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Relance_dossier_mip';
  }

}
