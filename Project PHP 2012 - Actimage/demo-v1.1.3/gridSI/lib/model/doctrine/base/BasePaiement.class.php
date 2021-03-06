<?php

/**
 * BasePaiement
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property date $date_paiement
 * @property float $montant
 * @property string $reference
 * @property integer $entite_id
 * @property integer $dossier_mip_id
 * @property Utilisateur $UtilisateurCreatedBy
 * @property Utilisateur $UtilisateurUpdatedBy
 * @property Dossier_mip $Dossier_mip
 * @property Entite $Entite
 * 
 * @method date        getDatePaiement()         Returns the current record's "date_paiement" value
 * @method float       getMontant()              Returns the current record's "montant" value
 * @method string      getReference()            Returns the current record's "reference" value
 * @method integer     getEntiteId()             Returns the current record's "entite_id" value
 * @method integer     getDossierMipId()         Returns the current record's "dossier_mip_id" value
 * @method Utilisateur getUtilisateurCreatedBy() Returns the current record's "UtilisateurCreatedBy" value
 * @method Utilisateur getUtilisateurUpdatedBy() Returns the current record's "UtilisateurUpdatedBy" value
 * @method Dossier_mip getDossierMip()           Returns the current record's "Dossier_mip" value
 * @method Entite      getEntite()               Returns the current record's "Entite" value
 * @method Paiement    setDatePaiement()         Sets the current record's "date_paiement" value
 * @method Paiement    setMontant()              Sets the current record's "montant" value
 * @method Paiement    setReference()            Sets the current record's "reference" value
 * @method Paiement    setEntiteId()             Sets the current record's "entite_id" value
 * @method Paiement    setDossierMipId()         Sets the current record's "dossier_mip_id" value
 * @method Paiement    setUtilisateurCreatedBy() Sets the current record's "UtilisateurCreatedBy" value
 * @method Paiement    setUtilisateurUpdatedBy() Sets the current record's "UtilisateurUpdatedBy" value
 * @method Paiement    setDossierMip()           Sets the current record's "Dossier_mip" value
 * @method Paiement    setEntite()               Sets the current record's "Entite" value
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BasePaiement extends gridDoctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('paiement');
        $this->hasColumn('date_paiement', 'date', null, array(
             'type' => 'date',
             'notnull' => true,
             ));
        $this->hasColumn('montant', 'float', null, array(
             'type' => 'float',
             'notnull' => true,
             ));
        $this->hasColumn('reference', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('entite_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
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
             'foreign' => 'id'));

        $this->hasOne('Entite', array(
             'local' => 'entite_id',
             'foreign' => 'id'));

        $timestampable0 = new Doctrine_Template_Timestampable(array(
             ));
        $signable0 = new Doctrine_Template_Signable(array(
             ));
        $this->actAs($timestampable0);
        $this->actAs($signable0);
    }
}