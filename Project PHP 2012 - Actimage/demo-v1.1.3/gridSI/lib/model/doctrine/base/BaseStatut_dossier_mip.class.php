<?php

/**
 * BaseStatut_dossier_mip
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $intitule
 * @property string $abreviation
 * @property integer $precedent_statut_dossier_mip_id
 * @property boolean $est_actif
 * @property Utilisateur $UtilisateurCreatedBy
 * @property Utilisateur $UtilisateurUpdatedBy
 * @property Statut_dossier_mip $Precedent
 * @property Doctrine_Collection $Dossier_mip
 * @property Doctrine_Collection $Statut_dossier_mip
 * 
 * @method string              getIntitule()                        Returns the current record's "intitule" value
 * @method string              getAbreviation()                     Returns the current record's "abreviation" value
 * @method integer             getPrecedentStatutDossierMipId()     Returns the current record's "precedent_statut_dossier_mip_id" value
 * @method boolean             getEstActif()                        Returns the current record's "est_actif" value
 * @method Utilisateur         getUtilisateurCreatedBy()            Returns the current record's "UtilisateurCreatedBy" value
 * @method Utilisateur         getUtilisateurUpdatedBy()            Returns the current record's "UtilisateurUpdatedBy" value
 * @method Statut_dossier_mip  getPrecedent()                       Returns the current record's "Precedent" value
 * @method Doctrine_Collection getDossierMip()                      Returns the current record's "Dossier_mip" collection
 * @method Doctrine_Collection getStatutDossierMip()                Returns the current record's "Statut_dossier_mip" collection
 * @method Statut_dossier_mip  setIntitule()                        Sets the current record's "intitule" value
 * @method Statut_dossier_mip  setAbreviation()                     Sets the current record's "abreviation" value
 * @method Statut_dossier_mip  setPrecedentStatutDossierMipId()     Sets the current record's "precedent_statut_dossier_mip_id" value
 * @method Statut_dossier_mip  setEstActif()                        Sets the current record's "est_actif" value
 * @method Statut_dossier_mip  setUtilisateurCreatedBy()            Sets the current record's "UtilisateurCreatedBy" value
 * @method Statut_dossier_mip  setUtilisateurUpdatedBy()            Sets the current record's "UtilisateurUpdatedBy" value
 * @method Statut_dossier_mip  setPrecedent()                       Sets the current record's "Precedent" value
 * @method Statut_dossier_mip  setDossierMip()                      Sets the current record's "Dossier_mip" collection
 * @method Statut_dossier_mip  setStatutDossierMip()                Sets the current record's "Statut_dossier_mip" collection
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseStatut_dossier_mip extends gridDoctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('statut_dossier_mip');
        $this->hasColumn('intitule', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('abreviation', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('precedent_statut_dossier_mip_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('est_actif', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => 1,
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

        $this->hasOne('Statut_dossier_mip as Precedent', array(
             'local' => 'precedent_statut_dossier_mip_id',
             'foreign' => 'id'));

        $this->hasMany('Dossier_mip', array(
             'local' => 'id',
             'foreign' => 'statut_dossier_mip_id'));

        $this->hasMany('Statut_dossier_mip', array(
             'local' => 'id',
             'foreign' => 'precedent_statut_dossier_mip_id'));

        $timestampable0 = new Doctrine_Template_Timestampable(array(
             ));
        $signable0 = new Doctrine_Template_Signable(array(
             ));
        $this->actAs($timestampable0);
        $this->actAs($signable0);
    }
}