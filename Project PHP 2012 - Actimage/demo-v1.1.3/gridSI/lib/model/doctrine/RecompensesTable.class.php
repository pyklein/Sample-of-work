<?php

/**
 * RecompensesTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class RecompensesTable extends Doctrine_Table
{
  /**
   * Returns an instance of this class.
   *
   * @return object RecompensesTable
   */
  public static function getInstance()
  {
    return Doctrine_Core::getTable('Recompenses');
  }

  /**
   * Permet de récupérer tous les objets Recompense d'un dossier BPI
   * @param integer $intDossierId ID de dossier BPI
   * @return Doctrine_Query
   * @author Gabor JAGER
   */
  public function getRecompensesByDossier($intDossierId)
  {
    $objRequete = $this->createQuery('r')
                    ->innerJoin('r.Part_inventive pi')
                    ->innerJoin('pi.Dossier_bpi d')
                    ->where('d.id = ?', $intDossierId)
                    ->andWhere('d.est_actif = 1');

    return $objRequete;
  }
}