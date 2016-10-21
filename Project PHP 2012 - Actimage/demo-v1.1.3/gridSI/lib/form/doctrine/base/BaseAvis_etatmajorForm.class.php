<?php

/**
 * Avis_etatmajor form base class.
 *
 * @method Avis_etatmajor getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseAvis_etatmajorForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'date_demande'      => new sfWidgetFormDateTime(),
      'reference_demande' => new sfWidgetFormInputText(),
      'date_reception'    => new sfWidgetFormDateTime(),
      'date_envoi'        => new sfWidgetFormDateTime(),
      'reference'         => new sfWidgetFormInputText(),
      'est_favorable'     => new sfWidgetFormInputCheckbox(),
      'recommandation'    => new sfWidgetFormTextarea(),
      'dossier_mip_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_mip'), 'add_empty' => false)),
      'created_at'        => new sfWidgetFormDateTime(),
      'updated_at'        => new sfWidgetFormDateTime(),
      'created_by'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'date_demande'      => new sfValidatorDateTime(array('required' => false)),
      'reference_demande' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'date_reception'    => new sfValidatorDateTime(array('required' => false)),
      'date_envoi'        => new sfValidatorDateTime(array('required' => false)),
      'reference'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'est_favorable'     => new sfValidatorBoolean(array('required' => false)),
      'recommandation'    => new sfValidatorString(array('required' => false)),
      'dossier_mip_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_mip'))),
      'created_at'        => new sfValidatorDateTime(),
      'updated_at'        => new sfValidatorDateTime(),
      'created_by'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'required' => false)),
      'updated_by'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('avis_etatmajor[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Avis_etatmajor';
  }

}
