<?php

/**
 * ContratTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class ContratTable extends Doctrine_Table
{

  /**
   * Returns an instance of this class.
   *
   * @return object ContratTable
   */
  public static function getInstance()
  {
    return Doctrine_Core::getTable('Contrat');
  }

  /**
   * Creer un query pour pecupere les contrats liés à un dossier bpi
   *
   * @param integer $intIdDossier ID du dossier ciblé
   * @return Doctrine_Query
   *
   * @author Simeon PETEV
   */
  public function buildQueryListContratsParDossierOrdreDscDate($intIdDossier)
  {
    if (sfContext::hasInstance())
      sfContext::getInstance()->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    $objQuery = $this->getQueryObject()
                    ->where('dossier_bpi_id = ?', $intIdDossier)
                    ->orderBy('date_redaction DESC');

    if (sfContext::hasInstance())
      sfContext::getInstance()->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");

    return $objQuery;
  }

  public function buildQueryContratOrdreAscPourSelectbox($intDossierId)
  {
    $objQuery = $this->getQueryObject()
                     ->where('dossier_bpi_id = ?', $intDossierId)
                     ->andWhere("est_actif = 1")
                     ->orderBy('numero_mb');

    return $objQuery;
  }

  /**
   * retourne les contrats d'un dossier BPI qui ont un type concession de license ou cession de titre
   *
   * @param integer $dossierId  ID du dossier BPI
   * @return Doctrine_Query
   *
   * @author Actimage
   */
  public function retrieveQueryContratParDossierPourSelectbox($dossierId)
  {
    $objQuery = $this->createQuery('c')
                          ->innerJoin('c.Contrat_type_contrat t')
                          ->where('c.est_actif = 1 AND c.dossier_bpi_id = ?',$dossierId)
                          ->andWhere('t.type_contrat_id = ? OR t.type_contrat_id =  ?', array(Type_contratTable::Licence,Type_contratTable::Cession))
                          ;

    return $objQuery;
  }

  /**
   * Requete permettant de récupérer les contrats selon le classement
   * @param string $strClassement
   * @return Doctrine_Query
   * @author Jihad
   */
  public function retrieveContratParClassementParDossierBpiId($arrClassement,$intDossierBpiId)
  {
    $objRequeteDoctrine = $this->createQuery('c')
                    ->innerJoin('c.Contrat_type_contrat t on t.contrat_id = c.id');

    if (array_key_exists(Classement_invention_inventeurTable::M, $arrClassement))
    {
      $objRequeteDoctrine = $objRequeteDoctrine->where('t.type_contrat_id=?', Type_contratTable::Reglement);
    }

    else if (array_key_exists(Classement_invention_inventeurTable::HMA, $arrClassement) || array_key_exists(Classement_invention_inventeurTable::HMNA, $arrClassement))
    {
      $objRequeteDoctrine = $objRequeteDoctrine->where('t.type_contrat_id=? OR t.type_contrat_id=?', array(Type_contratTable::Reglement,Type_contratTable::Licence) );
    }

    $objRequeteDoctrine->andWhere('c.est_actif = 1 AND c.dossier_bpi_id=?',$intDossierBpiId);
    
    return $objRequeteDoctrine;
  }

}