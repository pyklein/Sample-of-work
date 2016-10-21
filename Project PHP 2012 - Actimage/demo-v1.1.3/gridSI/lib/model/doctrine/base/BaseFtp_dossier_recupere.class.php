<?php

/**
 * BaseFtp_dossier_recupere
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $nom_dossier_recupere
 * @property timestamp $date_debut
 * @property timestamp $date_fin
 * 
 * @method integer              getId()                   Returns the current record's "id" value
 * @method string               getNomDossierRecupere()   Returns the current record's "nom_dossier_recupere" value
 * @method timestamp            getDateDebut()            Returns the current record's "date_debut" value
 * @method timestamp            getDateFin()              Returns the current record's "date_fin" value
 * @method Ftp_dossier_recupere setId()                   Sets the current record's "id" value
 * @method Ftp_dossier_recupere setNomDossierRecupere()   Sets the current record's "nom_dossier_recupere" value
 * @method Ftp_dossier_recupere setDateDebut()            Sets the current record's "date_debut" value
 * @method Ftp_dossier_recupere setDateFin()              Sets the current record's "date_fin" value
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseFtp_dossier_recupere extends gridDoctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('ftp_dossier_recupere');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('nom_dossier_recupere', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('date_debut', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('date_fin', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}