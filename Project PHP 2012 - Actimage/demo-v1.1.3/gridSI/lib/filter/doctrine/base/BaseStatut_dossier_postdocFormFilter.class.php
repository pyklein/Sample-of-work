<?php

/**
 * Statut_dossier_postdoc filter form base class.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseStatut_dossier_postdocFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'intitule' => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'intitule' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('statut_dossier_postdoc_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Statut_dossier_postdoc';
  }

  public function getFields()
  {
    return array(
      'id'       => 'Number',
      'intitule' => 'Text',
    );
  }
}
