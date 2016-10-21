<?php

/**
 * Formulaire pour la modification d'un service orphelin (sans organisme)
 *
 * @author Alexandre WETTA
 */
class ServiceOrphelinForm extends BaseServiceForm {
   public function  configure() {

     $this->useFields(array('organisme_id'));

     $this->setWidget('organisme_id', new gridWidgetFormOrganisme());

     $this->widgetSchema['organisme_id']->setLabel(libelle('msg_libelle_organisme'));

     $this->disableLocalCSRFProtection();
     parent::configure();
  }
}
?>
