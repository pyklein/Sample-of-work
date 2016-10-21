<?php

/**
 * Statut_declaration filter form base class.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseStatut_declarationFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'intitule'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'abreviation'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'est_actif'             => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'statut_declaration_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Statut_declaration'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'intitule'              => new sfValidatorPass(array('required' => false)),
      'abreviation'           => new sfValidatorPass(array('required' => false)),
      'est_actif'             => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'statut_declaration_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Statut_declaration'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('statut_declaration_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Statut_declaration';
  }

  public function getFields()
  {
    return array(
      'id'                    => 'Number',
      'intitule'              => 'Text',
      'abreviation'           => 'Text',
      'est_actif'             => 'Boolean',
      'statut_declaration_id' => 'ForeignKey',
    );
  }
}
