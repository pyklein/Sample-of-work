<?php

/**
 * Innovateur_dossier_mip filter form base class.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseInnovateur_dossier_mipFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'type_innovateur_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Type_innovateur'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'type_innovateur_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Type_innovateur'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('innovateur_dossier_mip_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Innovateur_dossier_mip';
  }

  public function getFields()
  {
    return array(
      'dossier_mip_id'     => 'Number',
      'utilisateur_id'     => 'Number',
      'type_innovateur_id' => 'ForeignKey',
    );
  }
}
