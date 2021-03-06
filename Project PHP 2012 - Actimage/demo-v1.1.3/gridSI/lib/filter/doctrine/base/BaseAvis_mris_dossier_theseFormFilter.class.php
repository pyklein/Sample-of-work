<?php

/**
 * Avis_mris_dossier_these filter form base class.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseAvis_mris_dossier_theseFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
    ));

    $this->setValidators(array(
    ));

    $this->widgetSchema->setNameFormat('avis_mris_dossier_these_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Avis_mris_dossier_these';
  }

  public function getFields()
  {
    return array(
      'avis_mris_id'     => 'Number',
      'dossier_these_id' => 'Number',
    );
  }
}
