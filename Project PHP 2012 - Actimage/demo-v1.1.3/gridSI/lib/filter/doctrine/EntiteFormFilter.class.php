<?php

/**
 * Entite filter form.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class EntiteFormFilter extends BaseEntiteFormFilter
{
  public function configure()
  {

      $this->setWidgets(array(
      'organisme_mindef_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme_mindef'),
                                                               'add_empty' => libelle('msg_libelle_tous'),
                                                               'order_by' => array('intitule', 'asc'),
                                                               'label' => libelle('msg_entite_libelle_org_mindef'),
                                                           //   'query' => $this->getOrganismeMindefActif()
                                                                'method' => 'getLabelFiltre'
                                                                ))));
    $this->setValidators(array(
      'organisme_mindef_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Organisme_mindef'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('entite_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->disableLocalCSRFProtection();
  }

  protected function getOrganismeMindefActif(){
    return Doctrine_Core::getTable('Organisme_mindef')->retrieveOrganismesMindefActif();
  }
}
