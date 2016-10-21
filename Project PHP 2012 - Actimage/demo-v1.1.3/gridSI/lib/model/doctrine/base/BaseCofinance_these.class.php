<?php

/**
 * BaseCofinance_these
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $dossier_these_id
 * @property integer $organisme_id
 * @property integer $part_cofinance
 * @property Dossier_these $Dossier_these
 * @property Organisme $Organisme
 * @property Utilisateur $UtilisateurCreatedBy
 * @property Utilisateur $UtilisateurUpdatedBy
 * 
 * @method integer         getDossierTheseId()       Returns the current record's "dossier_these_id" value
 * @method integer         getOrganismeId()          Returns the current record's "organisme_id" value
 * @method integer         getPartCofinance()        Returns the current record's "part_cofinance" value
 * @method Dossier_these   getDossierThese()         Returns the current record's "Dossier_these" value
 * @method Organisme       getOrganisme()            Returns the current record's "Organisme" value
 * @method Utilisateur     getUtilisateurCreatedBy() Returns the current record's "UtilisateurCreatedBy" value
 * @method Utilisateur     getUtilisateurUpdatedBy() Returns the current record's "UtilisateurUpdatedBy" value
 * @method Cofinance_these setDossierTheseId()       Sets the current record's "dossier_these_id" value
 * @method Cofinance_these setOrganismeId()          Sets the current record's "organisme_id" value
 * @method Cofinance_these setPartCofinance()        Sets the current record's "part_cofinance" value
 * @method Cofinance_these setDossierThese()         Sets the current record's "Dossier_these" value
 * @method Cofinance_these setOrganisme()            Sets the current record's "Organisme" value
 * @method Cofinance_these setUtilisateurCreatedBy() Sets the current record's "UtilisateurCreatedBy" value
 * @method Cofinance_these setUtilisateurUpdatedBy() Sets the current record's "UtilisateurUpdatedBy" value
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseCofinance_these extends gridDoctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('cofinance_these');
        $this->hasColumn('dossier_these_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('organisme_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('part_cofinance', 'integer', null, array(
             'type' => 'integer',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Dossier_these', array(
             'local' => 'dossier_these_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Organisme', array(
             'local' => 'organisme_id',
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