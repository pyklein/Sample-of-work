<?php

/**
 * BaseAboutissement_postdoc
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property date $reception_rapport_final
 * @property date $reception_fiche_evaluation
 * @property date $reception_synthese
 * @property integer $dossier_postdoc_id
 * @property Utilisateur $UtilisateurCreatedBy
 * @property Utilisateur $UtilisateurUpdatedBy
 * @property Dossier_postdoc $Dossier_postdoc
 * 
 * @method date                  getReceptionRapportFinal()      Returns the current record's "reception_rapport_final" value
 * @method date                  getReceptionFicheEvaluation()   Returns the current record's "reception_fiche_evaluation" value
 * @method date                  getReceptionSynthese()          Returns the current record's "reception_synthese" value
 * @method integer               getDossierPostdocId()           Returns the current record's "dossier_postdoc_id" value
 * @method Utilisateur           getUtilisateurCreatedBy()       Returns the current record's "UtilisateurCreatedBy" value
 * @method Utilisateur           getUtilisateurUpdatedBy()       Returns the current record's "UtilisateurUpdatedBy" value
 * @method Dossier_postdoc       getDossierPostdoc()             Returns the current record's "Dossier_postdoc" value
 * @method Aboutissement_postdoc setReceptionRapportFinal()      Sets the current record's "reception_rapport_final" value
 * @method Aboutissement_postdoc setReceptionFicheEvaluation()   Sets the current record's "reception_fiche_evaluation" value
 * @method Aboutissement_postdoc setReceptionSynthese()          Sets the current record's "reception_synthese" value
 * @method Aboutissement_postdoc setDossierPostdocId()           Sets the current record's "dossier_postdoc_id" value
 * @method Aboutissement_postdoc setUtilisateurCreatedBy()       Sets the current record's "UtilisateurCreatedBy" value
 * @method Aboutissement_postdoc setUtilisateurUpdatedBy()       Sets the current record's "UtilisateurUpdatedBy" value
 * @method Aboutissement_postdoc setDossierPostdoc()             Sets the current record's "Dossier_postdoc" value
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseAboutissement_postdoc extends gridDoctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('aboutissement_postdoc');
        $this->hasColumn('reception_rapport_final', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('reception_fiche_evaluation', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('reception_synthese', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('dossier_postdoc_id', 'integer', null, array(
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
             'local' => 'dossier_postdoc_id',
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