<?php

/**
 * Mail form base class.
 *
 * @method Mail getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseMailForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'sujet'            => new sfWidgetFormInputText(),
      'message'          => new sfWidgetFormTextarea(),
      'destinataire'     => new sfWidgetFormInputText(),
      'statut_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Mail_statut'), 'add_empty' => false)),
      'nombre_tentative' => new sfWidgetFormInputText(),
      'date_envoi'       => new sfWidgetFormDateTime(),
      'created_at'       => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
      'created_by'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'       => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'sujet'            => new sfValidatorString(array('max_length' => 255)),
      'message'          => new sfValidatorString(),
      'destinataire'     => new sfValidatorString(array('max_length' => 255)),
      'statut_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Mail_statut'), 'required' => false)),
      'nombre_tentative' => new sfValidatorInteger(),
      'date_envoi'       => new sfValidatorDateTime(array('required' => false)),
      'created_at'       => new sfValidatorDateTime(),
      'updated_at'       => new sfValidatorDateTime(),
      'created_by'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'required' => false)),
      'updated_by'       => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('mail[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Mail';
  }

}
