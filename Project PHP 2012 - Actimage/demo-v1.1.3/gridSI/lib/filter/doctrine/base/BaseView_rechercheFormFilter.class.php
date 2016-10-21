<?php

/**
 * View_recherche filter form base class.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseView_rechercheFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'dossier_mip_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_mip'), 'add_empty' => true)),
      'dossier_bpi_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_bpi'), 'add_empty' => true)),
      'dossier_ere_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_ere'), 'add_empty' => true)),
      'dossier_postdoc_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_postdoc'), 'add_empty' => true)),
      'dossier_these_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dossier_these'), 'add_empty' => true)),
      'metier_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Metier'), 'add_empty' => true)),
      'titre'              => new sfWidgetFormFilterInput(),
      'etat_partage_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Etat_partage'), 'add_empty' => true)),
      'created_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'dossier_mip_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Dossier_mip'), 'column' => 'id')),
      'dossier_bpi_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Dossier_bpi'), 'column' => 'id')),
      'dossier_ere_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Dossier_ere'), 'column' => 'id')),
      'dossier_postdoc_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Dossier_postdoc'), 'column' => 'id')),
      'dossier_these_id'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Dossier_these'), 'column' => 'id')),
      'metier_id'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Metier'), 'column' => 'id')),
      'titre'              => new sfValidatorPass(array('required' => false)),
      'etat_partage_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Etat_partage'), 'column' => 'id')),
      'created_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('view_recherche_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'View_recherche';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'dossier_mip_id'     => 'ForeignKey',
      'dossier_bpi_id'     => 'ForeignKey',
      'dossier_ere_id'     => 'ForeignKey',
      'dossier_postdoc_id' => 'ForeignKey',
      'dossier_these_id'   => 'ForeignKey',
      'metier_id'          => 'ForeignKey',
      'titre'              => 'Text',
      'etat_partage_id'    => 'ForeignKey',
      'created_at'         => 'Date',
    );
  }
}
