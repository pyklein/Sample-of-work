<?php

/**
 * Innovateur_dossier_mip form base class.
 *
 * @method Innovateur_dossier_mip getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseInnovateur_dossier_mipForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'dossier_mip_id'     => new sfWidgetFormInputHidden(),
      'utilisateur_id'     => new sfWidgetFormInputHidden(),
      'type_innovateur_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Type_innovateur'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'dossier_mip_id'     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('dossier_mip_id')), 'empty_value' => $this->getObject()->get('dossier_mip_id'), 'required' => false)),
      'utilisateur_id'     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('utilisateur_id')), 'empty_value' => $this->getObject()->get('utilisateur_id'), 'required' => false)),
      'type_innovateur_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Type_innovateur'))),
    ));

    $this->widgetSchema->setNameFormat('innovateur_dossier_mip[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Innovateur_dossier_mip';
  }

}
