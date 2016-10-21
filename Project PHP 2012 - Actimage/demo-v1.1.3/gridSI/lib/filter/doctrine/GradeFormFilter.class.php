<?php

/**
 * Grade filter form.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class GradeFormFilter extends BaseGradeFormFilter
{
  public function configure()
  {
    $this->setWidgets(array(
      'organisme_mindef_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme_mindef'),
                                                               'add_empty' => libelle('msg_libelle_tous'),
                                                               'order_by' => array('intitule', 'asc'),
                                                               'table_method' => 'retrieveOrganismesMindef',
                                                               'method'       => 'getLabelFiltre',
                                                               'label' => libelle('msg_grade_libelle_org_mindef'))),
    ));
    $this->setValidators(array(
      'organisme_mindef_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Organisme_mindef'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('grade_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->disableLocalCSRFProtection();
  }
}
