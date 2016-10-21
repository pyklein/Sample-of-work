<?php

/**
 * BaseAboutissement_these
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property boolean $est_preselectionne_prix
 * @property boolean $est_selectionne_prix
 * @property date $reception_exemplaire_these
 * @property date $reception_rapport_soutenance
 * @property date $reception_liste_publication
 * @property date $reception_fiche_evaluation
 * @property date $reception_synthese
 * @property date $date_soutenance
 * @property integer $dossier_these_id
 * @property Utilisateur $UtilisateurCreatedBy
 * @property Utilisateur $UtilisateurUpdatedBy
 * @property Dossier_these $Dossier_these
 * 
 * @method boolean             getEstPreselectionnePrix()        Returns the current record's "est_preselectionne_prix" value
 * @method boolean             getEstSelectionnePrix()           Returns the current record's "est_selectionne_prix" value
 * @method date                getReceptionExemplaireThese()     Returns the current record's "reception_exemplaire_these" value
 * @method date                getReceptionRapportSoutenance()   Returns the current record's "reception_rapport_soutenance" value
 * @method date                getReceptionListePublication()    Returns the current record's "reception_liste_publication" value
 * @method date                getReceptionFicheEvaluation()     Returns the current record's "reception_fiche_evaluation" value
 * @method date                getReceptionSynthese()            Returns the current record's "reception_synthese" value
 * @method date                getDateSoutenance()               Returns the current record's "date_soutenance" value
 * @method integer             getDossierTheseId()               Returns the current record's "dossier_these_id" value
 * @method Utilisateur         getUtilisateurCreatedBy()         Returns the current record's "UtilisateurCreatedBy" value
 * @method Utilisateur         getUtilisateurUpdatedBy()         Returns the current record's "UtilisateurUpdatedBy" value
 * @method Dossier_these       getDossierThese()                 Returns the current record's "Dossier_these" value
 * @method Aboutissement_these setEstPreselectionnePrix()        Sets the current record's "est_preselectionne_prix" value
 * @method Aboutissement_these setEstSelectionnePrix()           Sets the current record's "est_selectionne_prix" value
 * @method Aboutissement_these setReceptionExemplaireThese()     Sets the current record's "reception_exemplaire_these" value
 * @method Aboutissement_these setReceptionRapportSoutenance()   Sets the current record's "reception_rapport_soutenance" value
 * @method Aboutissement_these setReceptionListePublication()    Sets the current record's "reception_liste_publication" value
 * @method Aboutissement_these setReceptionFicheEvaluation()     Sets the current record's "reception_fiche_evaluation" value
 * @method Aboutissement_these setReceptionSynthese()            Sets the current record's "reception_synthese" value
 * @method Aboutissement_these setDateSoutenance()               Sets the current record's "date_soutenance" value
 * @method Aboutissement_these setDossierTheseId()               Sets the current record's "dossier_these_id" value
 * @method Aboutissement_these setUtilisateurCreatedBy()         Sets the current record's "UtilisateurCreatedBy" value
 * @method Aboutissement_these setUtilisateurUpdatedBy()         Sets the current record's "UtilisateurUpdatedBy" value
 * @method Aboutissement_these setDossierThese()                 Sets the current record's "Dossier_these" value
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseAboutissement_these extends gridDoctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('aboutissement_these');
        $this->hasColumn('est_preselectionne_prix', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => false,
             ));
        $this->hasColumn('est_selectionne_prix', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => false,
             ));
        $this->hasColumn('reception_exemplaire_these', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('reception_rapport_soutenance', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('reception_liste_publication', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('reception_fiche_evaluation', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('reception_synthese', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('date_soutenance', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('dossier_these_id', 'integer', null, array(
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

        $this->hasOne('Dossier_these', array(
             'local' => 'dossier_these_id',
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