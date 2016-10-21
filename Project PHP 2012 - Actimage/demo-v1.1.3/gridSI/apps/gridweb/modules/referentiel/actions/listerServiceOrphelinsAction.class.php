<?php

/**
 * Action pour le listage des services orphelins
 *
 * @author Alexandre WETTA
 */
class listerServiceOrphelinsAction extends gridAction {

  public function execute($request) {

      $objRequeteDoctrine = ServiceTable::getInstance()->retrieveServiceOrphelin();

      $this->processPager($objRequeteDoctrine->orderBy('intitule'), 'Service');

  }

}
?>
