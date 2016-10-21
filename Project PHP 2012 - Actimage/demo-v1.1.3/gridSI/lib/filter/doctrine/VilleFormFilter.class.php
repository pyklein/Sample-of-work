<?php

sfContext::getInstance()->getConfiguration()->loadHelpers("Libelle");

/**
 * Ville filter form.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class VilleFormFilter extends BaseVilleFormFilter
{
  public function configure()
  {
    $this->setWidgets(array(
      'departement_id' => new sfWidgetFormDoctrineChoiceParametered(array('model' => $this->getRelatedModelName('Departement'),
                                                               'add_empty' => libelle('msg_libelle_tous'),
                                                               'order_by' => array('code_departemental', 'asc'),
                                                               'table_method' => 'retrieveDepartements',
                                                               'method' => 'getLabelFiltre',
                                                               'label' => libelle('msg_ville_libelle_departement'))),
    ));
    $this->setValidators(array(
      'departement_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Departement'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('ville_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->disableLocalCSRFProtection();

  }
}
