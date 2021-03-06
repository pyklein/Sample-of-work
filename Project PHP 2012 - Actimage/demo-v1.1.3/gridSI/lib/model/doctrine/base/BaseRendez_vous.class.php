<?php

/**
 * BaseRendez_vous
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property timestamp $date_prise_rdv
 * @property timestamp $date_rdv
 * @property integer $dossier_mip_id
 * @property Utilisateur $UtilisateurCreatedBy
 * @property Utilisateur $UtilisateurUpdatedBy
 * @property Dossier_mip $Dossier_mip
 * 
 * @method timestamp   getDatePriseRdv()         Returns the current record's "date_prise_rdv" value
 * @method timestamp   getDateRdv()              Returns the current record's "date_rdv" value
 * @method integer     getDossierMipId()         Returns the current record's "dossier_mip_id" value
 * @method Utilisateur getUtilisateurCreatedBy() Returns the current record's "UtilisateurCreatedBy" value
 * @method Utilisateur getUtilisateurUpdatedBy() Returns the current record's "UtilisateurUpdatedBy" value
 * @method Dossier_mip getDossierMip()           Returns the current record's "Dossier_mip" value
 * @method Rendez_vous setDatePriseRdv()         Sets the current record's "date_prise_rdv" value
 * @method Rendez_vous setDateRdv()              Sets the current record's "date_rdv" value
 * @method Rendez_vous setDossierMipId()         Sets the current record's "dossier_mip_id" value
 * @method Rendez_vous setUtilisateurCreatedBy() Sets the current record's "UtilisateurCreatedBy" value
 * @method Rendez_vous setUtilisateurUpdatedBy() Sets the current record's "UtilisateurUpdatedBy" value
 * @method Rendez_vous setDossierMip()           Sets the current record's "Dossier_mip" value
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseRendez_vous extends gridDoctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('rendez_vous');
        $this->hasColumn('date_prise_rdv', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('date_rdv', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('dossier_mip_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Utilisateur as UtilisateurCreatedBy', array(
             'local' => 'created_by',
             'foreign' => 'id'));

        $this->hasOne('Utilisateur as UtilisateurUpdatedBy', array(
             'local' => 'updated_by',
             'foreign' => 'id'));

        $this->hasOne('Dossier_mip', array(
             'local' => 'dossier_mip_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable(array(
             ));
        $signable0 = new Doctrine_Template_Signable(array(
             ));
        $this->actAs($timestampable0);
        $this->actAs($signable0);
    }
}