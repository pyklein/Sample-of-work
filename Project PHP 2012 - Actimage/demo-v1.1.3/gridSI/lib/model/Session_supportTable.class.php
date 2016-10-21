<?php
/**
 * Classe abstraite regroupant les methodes communes à toutes les tables de support utilisées dans les
 * vues à listes basculantes
 *
 * @author William Richards
 */
abstract class Session_supportTable extends Doctrine_Table{
      /**
   *  Supprime les enregistrements liés à une session expirée ou lors d'un enregistrement effectif
   * @param string  $strToken   Transaction_token de la session
   */
  public function nettoyerAncienneSession($strToken) {
    $requete = $this->createQuery('s')->where('s.transaction_token = ?', $strToken);
    foreach ($requete->execute() as $sessionInfo) {
      $sessionInfo->delete();
    }
  }
    /**
   *  Récupère les informations de la table de support pour une session donnée
   * @param   string  $strToken   Transaction_token de la session
   * @return  Doctrine_collection Les informations recherchées
   */
  public function retrieveEtatSession($strToken) {
    return $this->createQuery('s')->where('s.transaction_token = ?', $strToken)->execute();
  }
}
?>
