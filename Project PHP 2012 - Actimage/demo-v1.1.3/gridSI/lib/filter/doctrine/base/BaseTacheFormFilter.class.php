<?php

/**
 * Tache filter form base class.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseTacheFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'debut'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'fin'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'pid'      => new sfWidgetFormFilterInput(),
      'erreur'   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'resultat' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'debut'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'fin'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'pid'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'erreur'   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'resultat' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tache_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Tache';
  }

  public function getFields()
  {
    return array(
      'cle'      => 'Text',
      'debut'    => 'Date',
      'fin'      => 'Date',
      'pid'      => 'Number',
      'erreur'   => 'Boolean',
      'resultat' => 'Text',
    );
  }
}
