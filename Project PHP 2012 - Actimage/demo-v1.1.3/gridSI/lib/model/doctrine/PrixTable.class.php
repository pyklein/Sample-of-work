<?php

/**
 * PrixTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class PrixTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return  PrixTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Prix');
    }

      /**
     * Retourne les prix par ordre des intitulés
     *
     * @return Requete
     * Auteurs: Alexandre WETTA
     */
    public function retrievePrix(){
      $requete = $this->createQuery('p')
              ->orderBy('intitule');
      return $requete;
    }
}