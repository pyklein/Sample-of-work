<?php

/**
 * BaseAttribution_droit
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property date $echeance_supplementaire
 * @property boolean $droits_attribues
 * @property date $date_decision_attribution
 * @property string $commentaire
 * @property date $date_envoi_contrat
 * @property boolean $redaction_brevet_lance
 * @property integer $contrat_id
 * @property integer $brevet_id
 * @property integer $dossier_bpi_id
 * @property Contrat $Contrat
 * @property Brevet $Brevet
 * @property Utilisateur $UtilisateurCreatedBy
 * @property Utilisateur $UtilisateurUpdatedBy
 * @property Dossier_bpi $Dossier_bpi
 * 
 * @method date              getEcheanceSupplementaire()    Returns the current record's "echeance_supplementaire" value
 * @method boolean           getDroitsAttribues()           Returns the current record's "droits_attribues" value
 * @method date              getDateDecisionAttribution()   Returns the current record's "date_decision_attribution" value
 * @method string            getCommentaire()               Returns the current record's "commentaire" value
 * @method date              getDateEnvoiContrat()          Returns the current record's "date_envoi_contrat" value
 * @method boolean           getRedactionBrevetLance()      Returns the current record's "redaction_brevet_lance" value
 * @method integer           getContratId()                 Returns the current record's "contrat_id" value
 * @method integer           getBrevetId()                  Returns the current record's "brevet_id" value
 * @method integer           getDossierBpiId()              Returns the current record's "dossier_bpi_id" value
 * @method Contrat           getContrat()                   Returns the current record's "Contrat" value
 * @method Brevet            getBrevet()                    Returns the current record's "Brevet" value
 * @method Utilisateur       getUtilisateurCreatedBy()      Returns the current record's "UtilisateurCreatedBy" value
 * @method Utilisateur       getUtilisateurUpdatedBy()      Returns the current record's "UtilisateurUpdatedBy" value
 * @method Dossier_bpi       getDossierBpi()                Returns the current record's "Dossier_bpi" value
 * @method Attribution_droit setEcheanceSupplementaire()    Sets the current record's "echeance_supplementaire" value
 * @method Attribution_droit setDroitsAttribues()           Sets the current record's "droits_attribues" value
 * @method Attribution_droit setDateDecisionAttribution()   Sets the current record's "date_decision_attribution" value
 * @method Attribution_droit setCommentaire()               Sets the current record's "commentaire" value
 * @method Attribution_droit setDateEnvoiContrat()          Sets the current record's "date_envoi_contrat" value
 * @method Attribution_droit setRedactionBrevetLance()      Sets the current record's "redaction_brevet_lance" value
 * @method Attribution_droit setContratId()                 Sets the current record's "contrat_id" value
 * @method Attribution_droit setBrevetId()                  Sets the current record's "brevet_id" value
 * @method Attribution_droit setDossierBpiId()              Sets the current record's "dossier_bpi_id" value
 * @method Attribution_droit setContrat()                   Sets the current record's "Contrat" value
 * @method Attribution_droit setBrevet()                    Sets the current record's "Brevet" value
 * @method Attribution_droit setUtilisateurCreatedBy()      Sets the current record's "UtilisateurCreatedBy" value
 * @method Attribution_droit setUtilisateurUpdatedBy()      Sets the current record's "UtilisateurUpdatedBy" value
 * @method Attribution_droit setDossierBpi()                Sets the current record's "Dossier_bpi" value
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseAttribution_droit extends gridDoctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('attribution_droit');
        $this->hasColumn('echeance_supplementaire', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('droits_attribues', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => false,
             ));
        $this->hasColumn('date_decision_attribution', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('commentaire', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('date_envoi_contrat', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('redaction_brevet_lance', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => false,
             ));
        $this->hasColumn('contrat_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('brevet_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('dossier_bpi_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Contrat', array(
             'local' => 'contrat_id',
             'foreign' => 'id'));

        $this->hasOne('Brevet', array(
             'local' => 'brevet_id',
             'foreign' => 'id'));

        $this->hasOne('Utilisateur as UtilisateurCreatedBy', array(
             'local' => 'created_by',
             'foreign' => 'id'));

        $this->hasOne('Utilisateur as UtilisateurUpdatedBy', array(
             'local' => 'updated_by',
             'foreign' => 'id'));

        $this->hasOne('Dossier_bpi', array(
             'local' => 'dossier_bpi_id',
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