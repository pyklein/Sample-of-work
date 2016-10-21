<?php

/**
 * BaseCommission
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $ordre_jour
 * @property boolean $est_selection
 * @property boolean $est_suivi
 * @property boolean $est_analyse
 * @property timestamp $date_debut
 * @property timestamp $date_fin
 * @property boolean $est_actif
 * @property integer $type_dossier_mris_id
 * @property Type_dossier_mris $Type_dossier_mris
 * @property Utilisateur $UtilisateurCreatedBy
 * @property Utilisateur $UtilisateurUpdatedBy
 * @property Doctrine_Collection $Utilisateurs
 * @property Doctrine_Collection $Intervenants
 * @property Doctrine_Collection $Commission_utilisateur
 * @property Doctrine_Collection $Commission_intervenant
 * @property Doctrine_Collection $Invitation
 * 
 * @method string              getOrdreJour()              Returns the current record's "ordre_jour" value
 * @method boolean             getEstSelection()           Returns the current record's "est_selection" value
 * @method boolean             getEstSuivi()               Returns the current record's "est_suivi" value
 * @method boolean             getEstAnalyse()             Returns the current record's "est_analyse" value
 * @method timestamp           getDateDebut()              Returns the current record's "date_debut" value
 * @method timestamp           getDateFin()                Returns the current record's "date_fin" value
 * @method boolean             getEstActif()               Returns the current record's "est_actif" value
 * @method integer             getTypeDossierMrisId()      Returns the current record's "type_dossier_mris_id" value
 * @method Type_dossier_mris   getTypeDossierMris()        Returns the current record's "Type_dossier_mris" value
 * @method Utilisateur         getUtilisateurCreatedBy()   Returns the current record's "UtilisateurCreatedBy" value
 * @method Utilisateur         getUtilisateurUpdatedBy()   Returns the current record's "UtilisateurUpdatedBy" value
 * @method Doctrine_Collection getUtilisateurs()           Returns the current record's "Utilisateurs" collection
 * @method Doctrine_Collection getIntervenants()           Returns the current record's "Intervenants" collection
 * @method Doctrine_Collection getCommissionUtilisateur()  Returns the current record's "Commission_utilisateur" collection
 * @method Doctrine_Collection getCommissionIntervenant()  Returns the current record's "Commission_intervenant" collection
 * @method Doctrine_Collection getInvitation()             Returns the current record's "Invitation" collection
 * @method Commission          setOrdreJour()              Sets the current record's "ordre_jour" value
 * @method Commission          setEstSelection()           Sets the current record's "est_selection" value
 * @method Commission          setEstSuivi()               Sets the current record's "est_suivi" value
 * @method Commission          setEstAnalyse()             Sets the current record's "est_analyse" value
 * @method Commission          setDateDebut()              Sets the current record's "date_debut" value
 * @method Commission          setDateFin()                Sets the current record's "date_fin" value
 * @method Commission          setEstActif()               Sets the current record's "est_actif" value
 * @method Commission          setTypeDossierMrisId()      Sets the current record's "type_dossier_mris_id" value
 * @method Commission          setTypeDossierMris()        Sets the current record's "Type_dossier_mris" value
 * @method Commission          setUtilisateurCreatedBy()   Sets the current record's "UtilisateurCreatedBy" value
 * @method Commission          setUtilisateurUpdatedBy()   Sets the current record's "UtilisateurUpdatedBy" value
 * @method Commission          setUtilisateurs()           Sets the current record's "Utilisateurs" collection
 * @method Commission          setIntervenants()           Sets the current record's "Intervenants" collection
 * @method Commission          setCommissionUtilisateur()  Sets the current record's "Commission_utilisateur" collection
 * @method Commission          setCommissionIntervenant()  Sets the current record's "Commission_intervenant" collection
 * @method Commission          setInvitation()             Sets the current record's "Invitation" collection
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseCommission extends gridDoctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('commission');
        $this->hasColumn('ordre_jour', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('est_selection', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => false,
             ));
        $this->hasColumn('est_suivi', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => false,
             ));
        $this->hasColumn('est_analyse', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => false,
             ));
        $this->hasColumn('date_debut', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('date_fin', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('est_actif', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => 1,
             ));
        $this->hasColumn('type_dossier_mris_id', 'integer', null, array(
             'type' => 'integer',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Type_dossier_mris', array(
             'local' => 'type_dossier_mris_id',
             'foreign' => 'id'));

        $this->hasOne('Utilisateur as UtilisateurCreatedBy', array(
             'local' => 'created_by',
             'foreign' => 'id'));

        $this->hasOne('Utilisateur as UtilisateurUpdatedBy', array(
             'local' => 'updated_by',
             'foreign' => 'id'));

        $this->hasMany('Utilisateur as Utilisateurs', array(
             'refClass' => 'Commission_utilisateur',
             'local' => 'utilisateur_id',
             'foreign' => 'commission_id'));

        $this->hasMany('Intervenant as Intervenants', array(
             'refClass' => 'Commission_intervenant',
             'local' => 'intervenant_id',
             'foreign' => 'commission_id'));

        $this->hasMany('Commission_utilisateur', array(
             'local' => 'id',
             'foreign' => 'commission_id'));

        $this->hasMany('Commission_intervenant', array(
             'local' => 'id',
             'foreign' => 'commission_id'));

        $this->hasMany('Invitation', array(
             'local' => 'id',
             'foreign' => 'commission_id'));

        $timestampable0 = new Doctrine_Template_Timestampable(array(
             ));
        $signable0 = new Doctrine_Template_Signable(array(
             ));
        $this->actAs($timestampable0);
        $this->actAs($signable0);
    }
}