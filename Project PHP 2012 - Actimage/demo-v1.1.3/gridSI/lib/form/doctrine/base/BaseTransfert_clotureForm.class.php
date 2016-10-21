<?php

/**
 * Transfert_cloture form base class.
 *
 * @method Transfert_cloture getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseTransfert_clotureForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'date_transfert'      => new sfWidgetFormDateTime(),
      'reference_transfert' => new sfWidgetFormInputText(),
      'destination_autre'   => new sfWidgetFormInputText(),
      'date_cloture'        => new sfWidgetFormDateTime(),
      'reference_cloture'   => new sfWidgetFormInputText(),
      'dossier_mip_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_mip'), 'add_empty' => false)),
      'entite_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Entite'), 'add_empty' => true)),
      'created_at'          => new sfWidgetFormDateTime(),
      'updated_at'          => new sfWidgetFormDateTime(),
      'created_by'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'add_empty' => true)),
      'updated_by'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'date_transfert'      => new sfValidatorDateTime(array('required' => false)),
      'reference_transfert' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'destination_autre'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'date_cloture'        => new sfValidatorDateTime(array('required' => false)),
      'reference_cloture'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'dossier_mip_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_mip'))),
      'entite_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Entite'), 'required' => false)),
      'created_at'          => new sfValidatorDateTime(),
      'updated_at'          => new sfValidatorDateTime(),
      'created_by'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurCreatedBy'), 'required' => false)),
      'updated_by'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UtilisateurUpdatedBy'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('transfert_cloture[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Transfert_cloture';
  }

}
