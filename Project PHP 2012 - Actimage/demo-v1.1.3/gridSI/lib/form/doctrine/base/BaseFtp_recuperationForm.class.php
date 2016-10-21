<?php

/**
 * Ftp_recuperation form base class.
 *
 * @method Ftp_recuperation getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseFtp_recuperationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'nom_dossier' => new sfWidgetFormInputText(),
      'date_debut'  => new sfWidgetFormDateTime(),
      'date_fin'    => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'nom_dossier' => new sfValidatorString(array('max_length' => 255)),
      'date_debut'  => new sfValidatorDateTime(array('required' => false)),
      'date_fin'    => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('ftp_recuperation[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Ftp_recuperation';
  }

}
