<?php

/**
 * Mode_transmissionTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Mode_transmissionTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object Mode_transmissionTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Mode_transmission');
    }

       /**
     * Retourne les modes de transmission par ordre des intitulés
     *
     * @return DoctrineCollection
     * Auteurs: Actimage
     */
  public function retrieveModeTransmission(){
      $requete = $this->createQuery('m')
              ->orderBy('intitule');
      return $requete->execute();
    }
}