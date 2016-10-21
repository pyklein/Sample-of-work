<?php

/**
 * Contact_seTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Contact_seTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return  Contact_seTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Contact_se');
    }

  /**
   * Recupere le query pour le listing des contact de services executants
   *
   * @return Doctrine_Query
   *
   * @author Simeon PETEV
   */
  public function buildQueryContactsSePourListing()
  {
    if (sfContext::hasInstance())
      sfContext::getInstance()->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    $objQuery = $this->getInstance()->getQueryObject()
                                      ->orderBy('nom ASC')
                                      ->orderBy('prenom ASC')
    ;

    if (sfContext::hasInstance())
      sfContext::getInstance()->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");

    return $objQuery;
  }

  public function getContactSEParEntite($intEntiteId)
  {
    $objRequete = $this->createQuery('c')
                       ->innerJoin('c.Entite e ON e.id=?',$intEntiteId)
                       ->where('e.est_executant = ?', 1);
    $arrContacts = $objRequete->execute();
    return $arrContacts[0];
  }
}