<?php

/**
 * View_recherche form base class.
 *
 * @method View_recherche getObject() Returns the current form's model object
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseView_rechercheForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'dossier_mip_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_mip'), 'add_empty' => true)),
      'dossier_bpi_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_bpi'), 'add_empty' => true)),
      'dossier_ere_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_ere'), 'add_empty' => true)),
      'dossier_postdoc_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_postdoc'), 'add_empty' => true)),
      'dossier_these_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_these'), 'add_empty' => true)),
      'metier_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Metier'), 'add_empty' => true)),
      'titre'              => new sfWidgetFormInputText(),
      'etat_partage_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Etat_partage'), 'add_empty' => true)),
      'created_at'         => new sfWidgetFormDate(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'dossier_mip_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_mip'), 'required' => false)),
      'dossier_bpi_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_bpi'), 'required' => false)),
      'dossier_ere_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_ere'), 'required' => false)),
      'dossier_postdoc_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_postdoc'), 'required' => false)),
      'dossier_these_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_these'), 'required' => false)),
      'metier_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Metier'), 'required' => false)),
      'titre'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'etat_partage_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Etat_partage'), 'required' => false)),
      'created_at'         => new sfValidatorDate(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('view_recherche[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'View_recherche';
  }

}
