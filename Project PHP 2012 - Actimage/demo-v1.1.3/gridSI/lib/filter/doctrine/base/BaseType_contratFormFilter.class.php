<?php

/**
 * Type_contrat filter form base class.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseType_contratFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'intitule'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'abreviation'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'contrat_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Contrat')),
    ));

    $this->setValidators(array(
      'intitule'     => new sfValidatorPass(array('required' => false)),
      'abreviation'  => new sfValidatorPass(array('required' => false)),
      'contrat_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Contrat', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('type_contrat_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addContratListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.Contrat_type_contrat Contrat_type_contrat')
      ->andWhereIn('Contrat_type_contrat.contrat_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Type_contrat';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'intitule'     => 'Text',
      'abreviation'  => 'Text',
      'contrat_list' => 'ManyKey',
    );
  }
}
