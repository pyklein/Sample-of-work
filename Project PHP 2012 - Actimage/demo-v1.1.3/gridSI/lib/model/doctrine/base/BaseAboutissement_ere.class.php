<?php

/**
 * BaseAboutissement_ere
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property date $reception_rapport_final
 * @property date $reception_fiche_evaluation
 * @property date $reception_synthese
 * @property integer $dossier_ere_id
 * @property Utilisateur $UtilisateurCreatedBy
 * @property Utilisateur $UtilisateurUpdatedBy
 * @property Dossier_postdoc $Dossier_postdoc
 * @property Doctrine_Collection $Dossier_ere
 * 
 * @method date                getReceptionRapportFinal()      Returns the current record's "reception_rapport_final" value
 * @method date                getReceptionFicheEvaluation()   Returns the current record's "reception_fiche_evaluation" value
 * @method date                getReceptionSynthese()          Returns the current record's "reception_synthese" value
 * @method integer             getDossierEreId()               Returns the current record's "dossier_ere_id" value
 * @method Utilisateur         getUtilisateurCreatedBy()       Returns the current record's "UtilisateurCreatedBy" value
 * @method Utilisateur         getUtilisateurUpdatedBy()       Returns the current record's "UtilisateurUpdatedBy" value
 * @method Dossier_postdoc     getDossierPostdoc()             Returns the current record's "Dossier_postdoc" value
 * @method Doctrine_Collection getDossierEre()                 Returns the current record's "Dossier_ere" collection
 * @method Aboutissement_ere   setReceptionRapportFinal()      Sets the current record's "reception_rapport_final" value
 * @method Aboutissement_ere   setReceptionFicheEvaluation()   Sets the current record's "reception_fiche_evaluation" value
 * @method Aboutissement_ere   setReceptionSynthese()          Sets the current record's "reception_synthese" value
 * @method Aboutissement_ere   setDossierEreId()               Sets the current record's "dossier_ere_id" value
 * @method Aboutissement_ere   setUtilisateurCreatedBy()       Sets the current record's "UtilisateurCreatedBy" value
 * @method Aboutissement_ere   setUtilisateurUpdatedBy()       Sets the current record's "UtilisateurUpdatedBy" value
 * @method Aboutissement_ere   setDossierPostdoc()             Sets the current record's "Dossier_postdoc" value
 * @method Aboutissement_ere   setDossierEre()                 Sets the current record's "Dossier_ere" collection
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseAboutissement_ere extends gridDoctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('aboutissement_ere');
        $this->hasColumn('reception_rapport_final', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('reception_fiche_evaluation', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('reception_synthese', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('dossier_ere_id', 'integer', null, array(
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

        $this->hasOne('Dossier_postdoc', array(
             'local' => 'dossier_ere_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasMany('Dossier_ere', array(
             'local' => 'dossier_ere_id',
             'foreign' => 'id'));

        $timestampable0 = new Doctrine_Template_Timestampable(array(
             ));
        $signable0 = new Doctrine_Template_Signable(array(
             ));
        $this->actAs($timestampable0);
        $this->actAs($signable0);
    }
}