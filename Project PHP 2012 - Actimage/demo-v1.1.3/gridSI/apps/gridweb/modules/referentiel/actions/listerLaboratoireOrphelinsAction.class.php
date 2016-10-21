<?php

/**
 * Action pour le listage des services orphelins
 *
 * @author Alexandre WETTA
 */
class listerLaboratoireOrphelinsAction extends gridAction {

  public function execute($request) {

      $objRequeteDoctrine = LaboratoireTable::getInstance()->retrieveLaboratoireOrphelin();

      $this->processPager($objRequeteDoctrine->orderBy('intitule'), 'Laboratoire');

  }

}
?>
