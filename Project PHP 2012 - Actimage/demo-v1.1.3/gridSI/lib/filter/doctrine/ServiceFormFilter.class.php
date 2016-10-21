<?php

/**
 * Service filter form.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ServiceFormFilter extends BaseServiceFormFilter
{
  public function configure()
  {
    $this->useFields(array('intitule','abreviation','organisme_id'));

    $this->widgetSchema['organisme_id'] =
        new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme'),
            'add_empty' => libelle('msg_libelle_tous'),
            'order_by' => array('intitule', 'asc'),
            'label' => libelle('msg_service_libelle_organisme')));
    $this->widgetSchema['intitule']->setLabel(libelle('msg_service_libelle_intitule'));
    $this->widgetSchema['abreviation']->setLabel(libelle('msg_service_libelle_abreviation'));

    $this->disableLocalCSRFProtection();
  }
}
