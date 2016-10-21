<?php

/**
 * Remarque_mipTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Remarque_mipTable extends Doctrine_Table {

  /**
   * Returns an instance of this class.
   *
   * @return object Remarque_mipTable
   */
  public static function getInstance() {
    return Doctrine_Core::getTable('Remarque_mip');
  }

  /**
   * Permet de creer un query permettant de recuperer les remarques pour un dossier 
   * MIP donné
   *
   * @param integer $intIdDossierMip L'id du dossier MIP concerné
   * @return object Doctrine_Query
   *
   * @author Simeon PETEV
   */
  public function buildQueryRemarquesPourDossierMipOrdreDesc($intIdDossierMip) 
  {
    if (sfContext::hasInstance())
      sfContext::getInstance()->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    $objQuery = Remarque_mipTable::getInstance()->getQueryObject()
                    ->where('dossier_mip_id = ?', $intIdDossierMip)
                    ->orderBy('created_at DESC');

    if (sfContext::hasInstance())
      sfContext::getInstance()->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");

    return $objQuery;
  }

  /**
   * Permet de recuperer les Remarques MIP d'un dossier MIP
   *
   * @param integer $intIdDossierMip  L'id du dossier MIP concerné
   * @return array Array d'objets Remarque_mip
   *
   * @author Simeon PETEV
   */
  public function retreveRemarquesPourDossierMipOrdreDesc($intIdDossierMip) {
    return $this->buildQueryRemarquesPourDossierMipOrdreDesc($intIdDossierMip)->execute();
  }


}