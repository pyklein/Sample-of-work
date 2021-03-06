<?php

/**
 * BaseBudget
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property date $date_budget
 * @property integer $budget_type_id
 * @property integer $dossier_mip_id
 * @property string $reference
 * @property float $montant
 * @property Utilisateur $UtilisateurCreatedBy
 * @property Utilisateur $UtilisateurUpdatedBy
 * @property Budget_type $Budget_type
 * @property Dossier_mip $Dossier_mip
 * 
 * @method date        getDateBudget()           Returns the current record's "date_budget" value
 * @method integer     getBudgetTypeId()         Returns the current record's "budget_type_id" value
 * @method integer     getDossierMipId()         Returns the current record's "dossier_mip_id" value
 * @method string      getReference()            Returns the current record's "reference" value
 * @method float       getMontant()              Returns the current record's "montant" value
 * @method Utilisateur getUtilisateurCreatedBy() Returns the current record's "UtilisateurCreatedBy" value
 * @method Utilisateur getUtilisateurUpdatedBy() Returns the current record's "UtilisateurUpdatedBy" value
 * @method Budget_type getBudgetType()           Returns the current record's "Budget_type" value
 * @method Dossier_mip getDossierMip()           Returns the current record's "Dossier_mip" value
 * @method Budget      setDateBudget()           Sets the current record's "date_budget" value
 * @method Budget      setBudgetTypeId()         Sets the current record's "budget_type_id" value
 * @method Budget      setDossierMipId()         Sets the current record's "dossier_mip_id" value
 * @method Budget      setReference()            Sets the current record's "reference" value
 * @method Budget      setMontant()              Sets the current record's "montant" value
 * @method Budget      setUtilisateurCreatedBy() Sets the current record's "UtilisateurCreatedBy" value
 * @method Budget      setUtilisateurUpdatedBy() Sets the current record's "UtilisateurUpdatedBy" value
 * @method Budget      setBudgetType()           Sets the current record's "Budget_type" value
 * @method Budget      setDossierMip()           Sets the current record's "Dossier_mip" value
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseBudget extends gridDoctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('budget');
        $this->hasColumn('date_budget', 'date', null, array(
             'type' => 'date',
             'notnull' => true,
             ));
        $this->hasColumn('budget_type_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('dossier_mip_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('reference', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('montant', 'float', null, array(
             'type' => 'float',
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

        $this->hasOne('Budget_type', array(
             'local' => 'budget_type_id',
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