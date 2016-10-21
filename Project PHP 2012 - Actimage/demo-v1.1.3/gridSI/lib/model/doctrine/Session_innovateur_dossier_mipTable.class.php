<?php

/**
 * Session_innovateur_dossier_mipTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Session_innovateur_dossier_mipTable extends Session_supportTable {

  /**
   * Returns an instance of this class.
   *
   * @return object Session_innovateur_dossier_mipTable
   */
  public static function getInstance() {
    return Doctrine_Core::getTable('Session_innovateur_dossier_mip');
  }

 /**
  * Récupère les informations de la table de support pour une session et un innovateur donné
  * @param string                 $strId      Id de l'innovateur
  * @param string                 $strToken   Transaction_token de la session
  * @return Doctrine_collection               les informations recherchées (Un seul enregistrement à priori)
  */
  public function getSessionByUtilisateurIdAndToken($strId, $strToken) {
    $requete = $this->createQuery('s')->where('s.innovateur_id = ?', $strId)
                    ->andWhere('s.transaction_token = ?', $strToken);

    $collection = $requete->execute();
    return $collection;
  }
}