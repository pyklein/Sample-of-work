<?php

/**
 * Ftp_dossier_recupere form base class.
 *
 * @method Ftp_dossier_recupere getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseFtp_dossier_recupereForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'nom_dossier_recupere' => new sfWidgetFormInputText(),
      'date_debut'           => new sfWidgetFormDateTime(),
      'date_fin'             => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'nom_dossier_recupere' => new sfValidatorString(array('max_length' => 255)),
      'date_debut'           => new sfValidatorDateTime(array('required' => false)),
      'date_fin'             => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('ftp_dossier_recupere[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Ftp_dossier_recupere';
  }

}
