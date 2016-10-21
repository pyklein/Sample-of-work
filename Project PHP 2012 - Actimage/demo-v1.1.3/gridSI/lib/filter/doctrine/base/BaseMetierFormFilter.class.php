<?php

/**
 * Metier filter form base class.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseMetierFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'intitule'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'est_administrateur' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'intitule'           => new sfValidatorPass(array('required' => false)),
      'est_administrateur' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('metier_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Metier';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'intitule'           => 'Text',
      'est_administrateur' => 'Boolean',
    );
  }
}
