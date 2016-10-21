<?php

/**
 * Type_depot filter form base class.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseType_depotFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'intitule'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'abreviation' => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'intitule'    => new sfValidatorPass(array('required' => false)),
      'abreviation' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('type_depot_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Type_depot';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'intitule'    => 'Text',
      'abreviation' => 'Text',
    );
  }
}
