<?php

/**
 * Point_contactTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Point_contactTable extends Doctrine_Table {

  /**
   * Returns an instance of this class.
   *
   * @return Point_contactTable
   */
  public static function getInstance() {
    return Doctrine_Core::getTable('Point_contact');
  }

  public function retrieveByOrganismeIdAndMetierId($intOrganismeId, $intMetierId) {
    return $this->retrievePointsDeContact($this->createQuery('s')
                    ->where('s.organisme_id = ?', $intOrganismeId)
                    ->andWhere('s.metier_id = ?', $intMetierId)
    );
  }

  public function retrieveByServiceIdAndMetierId($intServiceId, $intMetierId) {
    return $this->retrievePointsDeContact($this->createQuery('s')
                    ->where('s.service_id = ?', $intServiceId)
                    ->andWhere('s.metier_id = ?', $intMetierId)

    );
  }

  public function retrieveByLaboratoireIdAndMetierId($intLaboratoireId, $intMetierId) {
    return $this->retrievePointsDeContact($this->createQuery('s')
                    ->where('s.laboratoire_id = ?', $intLaboratoireId)
                    ->andWhere('s.metier_id = ?', $intMetierId)
    );
  }

  public function retrievePointsDeContact($objRequeteDoctrine = null) {
    if ($objRequeteDoctrine == null) {
      $objRequeteDoctrine = $this->createQuery();
    }
    return $objRequeteDoctrine->orderBy('telephone');
  }

/**
 * Retourne des pts de contacts avec metier MRIS et en fonction des villes
 * @param Array $arrVilles
 * @return doctrine_query
 * @author Alexandre WETTA
 */
  public function retrievePtsContactMrisFiltreParVille($arrVilles){

    return $this->createQuery('p')->where('p.metier_id = ?', MetierTable::MRIS_ID)
            ->andWhereIn('p.ville_id', $arrVilles);

  }

}