<?php

/**
 * Evenement_mrisTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Evenement_mrisTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object Evenement_mrisTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Evenement_mris');
    }

    public function getEvenementsByDossierId($intDossierId,$strTypeDossier)
    {
      $q = Doctrine_Query::create()
        -> from ('Evenement_mris e')
        -> where('e.'.$strTypeDossier.'_id = ?',$intDossierId)
        -> orderBy('date_evenement');

        return $q ; 
    }

}
