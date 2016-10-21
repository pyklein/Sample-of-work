<?php

/**
 * Organisme filter form.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class OrganismeFormFilter extends BaseOrganismeFormFilter {

  public function configure() {
    $this->useFields(array('type_organisme_id','intitule'));
    $this->widgetSchema['type_organisme_id'] =
        new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Type_organisme'),
            'add_empty' => libelle('msg_libelle_tous'),
            'order_by' => array('intitule', 'asc'),
            'label' => libelle('msg_organisme_libelle_type_org')));

    $this->widgetSchema['intitule']->setLabel(libelle('msg_organisme_libelle_intitule'));

    $this->widgetSchema->setNameFormat('organisme_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->disableLocalCSRFProtection();
  }

}
