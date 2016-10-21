<?php

/**
 * Suivi_dossier_postdocTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Suivi_dossier_postdocTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object Suivi_dossier_postdocTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Suivi_dossier_postdoc');
    }

    public function getSuiviByDossierId($intDossierId,$strTypeDossier)
    {
      $q = Doctrine_Query::create()
        -> from ('Suivi_dossier_postdoc s')
        -> where('s.'.$strTypeDossier.'_id = ?',$intDossierId)
        -> orderBy('date_demande');

        return $q ;
    }

     /**
     * Fonction retournant la liste des suivi d'un dossier ordonné par le type de suivi
     *
     * @param int $intDossierId Identifiant du dossier
     * @param string $strTypeDossier Type du dossier (dossier_these, dossier_ere, dossier_postdoc)
     * @return Doctrine_Collection
     * @author Julien GAUTIER
     */
    public function getSuiviByDossierIdOrderedByType($intDossierId,$strTypeDossier)
    {
      $q = Doctrine_Query::create()
        -> from ('Suivi_dossier_postdoc s')
        -> where('s.'.$strTypeDossier.'_id = ?',$intDossierId)
        -> orderBy("type_suivi_postdoc_id ASC, date_demande ASC");

        return $q->execute() ;
    }
}