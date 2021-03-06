<?php

/**
 * Session_situation_inventeursTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Session_situation_inventeursTable extends Session_supportTable {

  /**
   * Returns an instance of this class.
   *
   * @return object Session_situation_inventeursTable
   */
  public static function getInstance() {
    return Doctrine_Core::getTable('Session_situation_inventeurs');
  }

  /**
   * Récupère les informations de la table de support pour une session et un inventeur donné
   * @param string                 $strId      Id de l'inventeur
   * @param string                 $strToken   Transaction_token de la session
   * @return Doctrine_collection               les informations recherchées (Un seul enregistrement à priori)
   */
  public function getSessionByInventeurIdAndToken($strId, $strToken) {
    $requete = $this->createQuery('s')->where('s.inventeur_id = ?', $strId)
                    ->andWhere('s.transaction_token = ?', $strToken);
    $collection = $requete->execute();
    return $collection;
  }

}