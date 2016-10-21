<?php

/**
 * Encadrant_ere filter form base class.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseEncadrant_ereFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
    ));

    $this->setValidators(array(
    ));

    $this->widgetSchema->setNameFormat('encadrant_ere_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Encadrant_ere';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'dossier_ere_id' => 'Number',
      'intervenant_id' => 'Number',
      'role_ere_id'    => 'Number',
    );
  }
}
