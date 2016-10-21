<?php

/**
 * BaseSuivi_dossier_these
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $descriptif
 * @property date $date_demande
 * @property date $date_reception
 * @property integer $dossier_these_id
 * @property integer $type_suivi_these_id
 * @property Dossier_these $Dossier_these
 * @property Type_suivi_these $Type_suivi_these
 * @property Utilisateur $UtilisateurCreatedBy
 * @property Utilisateur $UtilisateurUpdatedBy
 * 
 * @method string              getDescriptif()           Returns the current record's "descriptif" value
 * @method date                getDateDemande()          Returns the current record's "date_demande" value
 * @method date                getDateReception()        Returns the current record's "date_reception" value
 * @method integer             getDossierTheseId()       Returns the current record's "dossier_these_id" value
 * @method integer             getTypeSuiviTheseId()     Returns the current record's "type_suivi_these_id" value
 * @method Dossier_these       getDossierThese()         Returns the current record's "Dossier_these" value
 * @method Type_suivi_these    getTypeSuiviThese()       Returns the current record's "Type_suivi_these" value
 * @method Utilisateur         getUtilisateurCreatedBy() Returns the current record's "UtilisateurCreatedBy" value
 * @method Utilisateur         getUtilisateurUpdatedBy() Returns the current record's "UtilisateurUpdatedBy" value
 * @method Suivi_dossier_these setDescriptif()           Sets the current record's "descriptif" value
 * @method Suivi_dossier_these setDateDemande()          Sets the current record's "date_demande" value
 * @method Suivi_dossier_these setDateReception()        Sets the current record's "date_reception" value
 * @method Suivi_dossier_these setDossierTheseId()       Sets the current record's "dossier_these_id" value
 * @method Suivi_dossier_these setTypeSuiviTheseId()     Sets the current record's "type_suivi_these_id" value
 * @method Suivi_dossier_these setDossierThese()         Sets the current record's "Dossier_these" value
 * @method Suivi_dossier_these setTypeSuiviThese()       Sets the current record's "Type_suivi_these" value
 * @method Suivi_dossier_these setUtilisateurCreatedBy() Sets the current record's "UtilisateurCreatedBy" value
 * @method Suivi_dossier_these setUtilisateurUpdatedBy() Sets the current record's "UtilisateurUpdatedBy" value
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseSuivi_dossier_these extends gridDoctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('suivi_dossier_these');
        $this->hasColumn('descriptif', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('date_demande', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('date_reception', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('dossier_these_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('type_suivi_these_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Dossier_these', array(
             'local' => 'dossier_these_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Type_suivi_these', array(
             'local' => 'type_suivi_these_id',
             'foreign' => 'id'));

        $this->hasOne('Utilisateur as UtilisateurCreatedBy', array(
             'local' => 'created_by',
             'foreign' => 'id'));

        $this->hasOne('Utilisateur as UtilisateurUpdatedBy', array(
             'local' => 'updated_by',
             'foreign' => 'id'));

        $timestampable0 = new Doctrine_Template_Timestampable(array(
             ));
        $signable0 = new Doctrine_Template_Signable(array(
             ));
        $this->actAs($timestampable0);
        $this->actAs($signable0);
    }
}