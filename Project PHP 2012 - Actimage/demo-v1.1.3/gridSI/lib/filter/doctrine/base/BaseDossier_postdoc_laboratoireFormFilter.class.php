<?php

/**
 * Dossier_postdoc_laboratoire filter form base class.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseDossier_postdoc_laboratoireFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
    ));

    $this->setValidators(array(
    ));

    $this->widgetSchema->setNameFormat('dossier_postdoc_laboratoire_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Dossier_postdoc_laboratoire';
  }

  public function getFields()
  {
    return array(
      'dossier_postdoc_id' => 'Number',
      'laboratoire_id'     => 'Number',
    );
  }
}
