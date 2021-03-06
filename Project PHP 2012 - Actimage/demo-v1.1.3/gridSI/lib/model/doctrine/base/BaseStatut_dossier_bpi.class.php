<?php

/**
 * BaseStatut_dossier_bpi
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $intitule
 * @property string $abreviation
 * @property integer $precedent_statut_dossier_bpi_id
 * @property boolean $est_actif
 * @property Utilisateur $UtilisateurCreatedBy
 * @property Utilisateur $UtilisateurUpdatedBy
 * @property Statut_dossier_bpi $Precedent
 * @property Doctrine_Collection $Dossier_bpi
 * @property Doctrine_Collection $Statut_dossier_bpi
 * @property Doctrine_Collection $Documents_bpi
 * 
 * @method string              getIntitule()                        Returns the current record's "intitule" value
 * @method string              getAbreviation()                     Returns the current record's "abreviation" value
 * @method integer             getPrecedentStatutDossierBpiId()     Returns the current record's "precedent_statut_dossier_bpi_id" value
 * @method boolean             getEstActif()                        Returns the current record's "est_actif" value
 * @method Utilisateur         getUtilisateurCreatedBy()            Returns the current record's "UtilisateurCreatedBy" value
 * @method Utilisateur         getUtilisateurUpdatedBy()            Returns the current record's "UtilisateurUpdatedBy" value
 * @method Statut_dossier_bpi  getPrecedent()                       Returns the current record's "Precedent" value
 * @method Doctrine_Collection getDossierBpi()                      Returns the current record's "Dossier_bpi" collection
 * @method Doctrine_Collection getStatutDossierBpi()                Returns the current record's "Statut_dossier_bpi" collection
 * @method Doctrine_Collection getDocumentsBpi()                    Returns the current record's "Documents_bpi" collection
 * @method Statut_dossier_bpi  setIntitule()                        Sets the current record's "intitule" value
 * @method Statut_dossier_bpi  setAbreviation()                     Sets the current record's "abreviation" value
 * @method Statut_dossier_bpi  setPrecedentStatutDossierBpiId()     Sets the current record's "precedent_statut_dossier_bpi_id" value
 * @method Statut_dossier_bpi  setEstActif()                        Sets the current record's "est_actif" value
 * @method Statut_dossier_bpi  setUtilisateurCreatedBy()            Sets the current record's "UtilisateurCreatedBy" value
 * @method Statut_dossier_bpi  setUtilisateurUpdatedBy()            Sets the current record's "UtilisateurUpdatedBy" value
 * @method Statut_dossier_bpi  setPrecedent()                       Sets the current record's "Precedent" value
 * @method Statut_dossier_bpi  setDossierBpi()                      Sets the current record's "Dossier_bpi" collection
 * @method Statut_dossier_bpi  setStatutDossierBpi()                Sets the current record's "Statut_dossier_bpi" collection
 * @method Statut_dossier_bpi  setDocumentsBpi()                    Sets the current record's "Documents_bpi" collection
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseStatut_dossier_bpi extends gridDoctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('statut_dossier_bpi');
        $this->hasColumn('intitule', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('abreviation', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('precedent_statut_dossier_bpi_id', 'integer', null, array(
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

        $this->hasOne('Statut_dossier_bpi as Precedent', array(
             'local' => 'precedent_statut_dossier_bpi_id',
             'foreign' => 'id'));

        $this->hasMany('Dossier_bpi', array(
             'local' => 'id',
             'foreign' => 'statut_dossier_bpi_id'));

        $this->hasMany('Statut_dossier_bpi', array(
             'local' => 'id',
             'foreign' => 'precedent_statut_dossier_bpi_id'));

        $this->hasMany('Documents_bpi', array(
             'local' => 'id',
             'foreign' => 'statut_dossier_bpi_id'));

        $timestampable0 = new Doctrine_Template_Timestampable(array(
             ));
        $signable0 = new Doctrine_Template_Signable(array(
             ));
        $this->actAs($timestampable0);
        $this->actAs($signable0);
    }
}