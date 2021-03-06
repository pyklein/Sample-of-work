<?php

/**
 * ActionTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class ActionTable extends Doctrine_Table
{
  /**
   * Returns an instance of this class.
   *
   * @return object ActionTable
   */
  public static function getInstance()
  {
    return Doctrine_Core::getTable('Action');
  }

  /**
   * Permet de récuperer une collection d'actions menées d'un dossier BPI
   * @param integer $intDossierBpiId
   * @return Doctrine_Query
   */
  public function getActionsMeneesByDossierBpi($intDossierBpiId)
  {
    $objRequete = $this->createQuery('a')
                       ->where('a.dossier_bpi_id = ?',$intDossierBpiId)
                       ->andWhere('a.statut_action_id = ?',  Statut_actionTable::MENER)
                       ->andWhere('a.date_action is not ?',NULL);

    return $objRequete;
  }

  /**
   * Permet de récuperer une collection d'actions à mener d'un dossier BPI
   * @param integer $intDossierBpiId
   * @param string $strDateAvant recherche avant cette date (format SQL)
   * @return Doctrine_Query
   * @author Gabor JAGER
   */
  public function getActionsAMenerByDossierBpi($intDossierBpiId, $strDateAvant = "")
  {
    $objRequete = $this->createQuery('a')
                       ->where('a.dossier_bpi_id = ?', $intDossierBpiId)
                       ->andWhere('a.statut_action_id = ?', Statut_actionTable::A_MENER);

    if ($strDateAvant != "")
    {
      $objRequete->andWhere("a.date_echeance < ?", $strDateAvant);
    }
    
    $objRequete->orderBy("a.date_echeance");

    return $objRequete;
  }
}
