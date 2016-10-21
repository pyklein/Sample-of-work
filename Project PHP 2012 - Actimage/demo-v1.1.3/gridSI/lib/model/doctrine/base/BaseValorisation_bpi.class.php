<?php

/**
 * BaseValorisation_bpi
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $dossier_bpi_id
 * @property string $commentaire
 * @property boolean $est_evalue
 * @property Dossier_bpi $Dossier_bpi
 * @property Utilisateur $UtilisateurCreatedBy
 * @property Utilisateur $UtilisateurUpdatedBy
 * @property Doctrine_Collection $Valorisation_externe
 * @property Doctrine_Collection $Valorisation_interne
 * 
 * @method integer             getDossierBpiId()         Returns the current record's "dossier_bpi_id" value
 * @method string              getCommentaire()          Returns the current record's "commentaire" value
 * @method boolean             getEstEvalue()            Returns the current record's "est_evalue" value
 * @method Dossier_bpi         getDossierBpi()           Returns the current record's "Dossier_bpi" value
 * @method Utilisateur         getUtilisateurCreatedBy() Returns the current record's "UtilisateurCreatedBy" value
 * @method Utilisateur         getUtilisateurUpdatedBy() Returns the current record's "UtilisateurUpdatedBy" value
 * @method Doctrine_Collection getValorisationExterne()  Returns the current record's "Valorisation_externe" collection
 * @method Doctrine_Collection getValorisationInterne()  Returns the current record's "Valorisation_interne" collection
 * @method Valorisation_bpi    setDossierBpiId()         Sets the current record's "dossier_bpi_id" value
 * @method Valorisation_bpi    setCommentaire()          Sets the current record's "commentaire" value
 * @method Valorisation_bpi    setEstEvalue()            Sets the current record's "est_evalue" value
 * @method Valorisation_bpi    setDossierBpi()           Sets the current record's "Dossier_bpi" value
 * @method Valorisation_bpi    setUtilisateurCreatedBy() Sets the current record's "UtilisateurCreatedBy" value
 * @method Valorisation_bpi    setUtilisateurUpdatedBy() Sets the current record's "UtilisateurUpdatedBy" value
 * @method Valorisation_bpi    setValorisationExterne()  Sets the current record's "Valorisation_externe" collection
 * @method Valorisation_bpi    setValorisationInterne()  Sets the current record's "Valorisation_interne" collection
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseValorisation_bpi extends gridDoctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('valorisation_bpi');
        $this->hasColumn('dossier_bpi_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('commentaire', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('est_evalue', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Dossier_bpi', array(
             'local' => 'dossier_bpi_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Utilisateur as UtilisateurCreatedBy', array(
             'local' => 'created_by',
             'foreign' => 'id'));

        $this->hasOne('Utilisateur as UtilisateurUpdatedBy', array(
             'local' => 'updated_by',
             'foreign' => 'id'));

        $this->hasMany('Valorisation_externe', array(
             'local' => 'id',
             'foreign' => 'valorisation_bpi_id'));

        $this->hasMany('Valorisation_interne', array(
             'local' => 'id',
             'foreign' => 'valorisation_bpi_id'));

        $timestampable0 = new Doctrine_Template_Timestampable(array(
             ));
        $signable0 = new Doctrine_Template_Signable(array(
             ));
        $this->actAs($timestampable0);
        $this->actAs($signable0);
    }
}