<?php

/**
 * Session_dossier_postdoc_laboratoire filter form base class.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseSession_dossier_postdoc_laboratoireFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'dossier_postdoc_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('DossierPostdoc'), 'add_empty' => true)),
      'laboratoire_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Laboratoire'), 'add_empty' => true)),
      'transaction_token'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'dossier_postdoc_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('DossierPostdoc'), 'column' => 'id')),
      'laboratoire_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Laboratoire'), 'column' => 'id')),
      'transaction_token'  => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('session_dossier_postdoc_laboratoire_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Session_dossier_postdoc_laboratoire';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'dossier_postdoc_id' => 'ForeignKey',
      'laboratoire_id'     => 'ForeignKey',
      'transaction_token'  => 'Text',
    );
  }
}
