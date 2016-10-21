<?php

/**
 * Remarque_bpiTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Remarque_bpiTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object Remarque_bpiTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Remarque_bpi');
    }

    public function retrieveRemarqueParDossierBpi($intDossierBpiId)
    {
      return $this->createQuery('r')->where('r.dossier_bpi_id = ?',$intDossierBpiId);
    }
}