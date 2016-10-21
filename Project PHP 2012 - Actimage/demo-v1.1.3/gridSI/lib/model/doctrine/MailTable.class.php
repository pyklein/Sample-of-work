<?php

/**
 * MailTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class MailTable extends Doctrine_Table {

  /**
   * Returns an instance of this class.
   *
   * @return object MailTable
   */
  public static function getInstance() {
    return Doctrine_Core::getTable('Mail');
  }

  /**
   * Retourne les objets mails n'ayant pas encore été envoyés (statutId = 1)
   * @return collection de Mail
   */
  public function retrieveMailsAEnvoyer() {
    $requete = $this->createQuery('e')
            ->where('e.date_envoi <= ?',date('Y-m-d H:i:s',time()))
            ->andWhere('e.statut_id = 1');
    return $requete->execute();
  }

}