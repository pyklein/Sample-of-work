<?php

/**
 * BaseLaboratoire
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $intitule
 * @property string $intitule_ancien
 * @property string $abreviation
 * @property string $evaluation_aers
 * @property boolean $est_actif
 * @property integer $service_id
 * @property integer $organisme_id
 * @property Service $Service
 * @property Organisme $Organisme
 * @property Utilisateur $UtilisateurCreatedBy
 * @property Utilisateur $UtilisateurUpdatedBy
 * @property Doctrine_Collection $Point_contact
 * @property Doctrine_Collection $Session_invitation_commission
 * @property Doctrine_Collection $Session_dossier_these_laboratoire
 * @property Doctrine_Collection $Session_dossier_ere_laboratoire
 * @property Doctrine_Collection $Session_dossier_postdoc_laboratoire
 * @property Doctrine_Collection $Intervenant
 * @property Doctrine_Collection $Invitation
 * @property Doctrine_Collection $DossiersThese
 * @property Doctrine_Collection $Dossier_these_laboratoire
 * @property Doctrine_Collection $DossiersEre
 * @property Doctrine_Collection $Dossier_ere_laboratoire
 * @property Doctrine_Collection $DossiersPostdoc
 * @property Doctrine_Collection $Dossier_postdoc_laboratoire
 * 
 * @method integer             getId()                                  Returns the current record's "id" value
 * @method string              getIntitule()                            Returns the current record's "intitule" value
 * @method string              getIntituleAncien()                      Returns the current record's "intitule_ancien" value
 * @method string              getAbreviation()                         Returns the current record's "abreviation" value
 * @method string              getEvaluationAers()                      Returns the current record's "evaluation_aers" value
 * @method boolean             getEstActif()                            Returns the current record's "est_actif" value
 * @method integer             getServiceId()                           Returns the current record's "service_id" value
 * @method integer             getOrganismeId()                         Returns the current record's "organisme_id" value
 * @method Service             getService()                             Returns the current record's "Service" value
 * @method Organisme           getOrganisme()                           Returns the current record's "Organisme" value
 * @method Utilisateur         getUtilisateurCreatedBy()                Returns the current record's "UtilisateurCreatedBy" value
 * @method Utilisateur         getUtilisateurUpdatedBy()                Returns the current record's "UtilisateurUpdatedBy" value
 * @method Doctrine_Collection getPointContact()                        Returns the current record's "Point_contact" collection
 * @method Doctrine_Collection getSessionInvitationCommission()         Returns the current record's "Session_invitation_commission" collection
 * @method Doctrine_Collection getSessionDossierTheseLaboratoire()      Returns the current record's "Session_dossier_these_laboratoire" collection
 * @method Doctrine_Collection getSessionDossierEreLaboratoire()        Returns the current record's "Session_dossier_ere_laboratoire" collection
 * @method Doctrine_Collection getSessionDossierPostdocLaboratoire()    Returns the current record's "Session_dossier_postdoc_laboratoire" collection
 * @method Doctrine_Collection getIntervenant()                         Returns the current record's "Intervenant" collection
 * @method Doctrine_Collection getInvitation()                          Returns the current record's "Invitation" collection
 * @method Doctrine_Collection getDossiersThese()                       Returns the current record's "DossiersThese" collection
 * @method Doctrine_Collection getDossierTheseLaboratoire()             Returns the current record's "Dossier_these_laboratoire" collection
 * @method Doctrine_Collection getDossiersEre()                         Returns the current record's "DossiersEre" collection
 * @method Doctrine_Collection getDossierEreLaboratoire()               Returns the current record's "Dossier_ere_laboratoire" collection
 * @method Doctrine_Collection getDossiersPostdoc()                     Returns the current record's "DossiersPostdoc" collection
 * @method Doctrine_Collection getDossierPostdocLaboratoire()           Returns the current record's "Dossier_postdoc_laboratoire" collection
 * @method Laboratoire         setId()                                  Sets the current record's "id" value
 * @method Laboratoire         setIntitule()                            Sets the current record's "intitule" value
 * @method Laboratoire         setIntituleAncien()                      Sets the current record's "intitule_ancien" value
 * @method Laboratoire         setAbreviation()                         Sets the current record's "abreviation" value
 * @method Laboratoire         setEvaluationAers()                      Sets the current record's "evaluation_aers" value
 * @method Laboratoire         setEstActif()                            Sets the current record's "est_actif" value
 * @method Laboratoire         setServiceId()                           Sets the current record's "service_id" value
 * @method Laboratoire         setOrganismeId()                         Sets the current record's "organisme_id" value
 * @method Laboratoire         setService()                             Sets the current record's "Service" value
 * @method Laboratoire         setOrganisme()                           Sets the current record's "Organisme" value
 * @method Laboratoire         setUtilisateurCreatedBy()                Sets the current record's "UtilisateurCreatedBy" value
 * @method Laboratoire         setUtilisateurUpdatedBy()                Sets the current record's "UtilisateurUpdatedBy" value
 * @method Laboratoire         setPointContact()                        Sets the current record's "Point_contact" collection
 * @method Laboratoire         setSessionInvitationCommission()         Sets the current record's "Session_invitation_commission" collection
 * @method Laboratoire         setSessionDossierTheseLaboratoire()      Sets the current record's "Session_dossier_these_laboratoire" collection
 * @method Laboratoire         setSessionDossierEreLaboratoire()        Sets the current record's "Session_dossier_ere_laboratoire" collection
 * @method Laboratoire         setSessionDossierPostdocLaboratoire()    Sets the current record's "Session_dossier_postdoc_laboratoire" collection
 * @method Laboratoire         setIntervenant()                         Sets the current record's "Intervenant" collection
 * @method Laboratoire         setInvitation()                          Sets the current record's "Invitation" collection
 * @method Laboratoire         setDossiersThese()                       Sets the current record's "DossiersThese" collection
 * @method Laboratoire         setDossierTheseLaboratoire()             Sets the current record's "Dossier_these_laboratoire" collection
 * @method Laboratoire         setDossiersEre()                         Sets the current record's "DossiersEre" collection
 * @method Laboratoire         setDossierEreLaboratoire()               Sets the current record's "Dossier_ere_laboratoire" collection
 * @method Laboratoire         setDossiersPostdoc()                     Sets the current record's "DossiersPostdoc" collection
 * @method Laboratoire         setDossierPostdocLaboratoire()           Sets the current record's "Dossier_postdoc_laboratoire" collection
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseLaboratoire extends gridDoctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('laboratoire');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('intitule', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('intitule_ancien', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('abreviation', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('evaluation_aers', 'string', 3, array(
             'type' => 'string',
             'length' => 3,
             ));
        $this->hasColumn('est_actif', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => 1,
             ));
        $this->hasColumn('service_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('organisme_id', 'integer', null, array(
             'type' => 'integer',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Service', array(
             'local' => 'service_id',
             'foreign' => 'id'));

        $this->hasOne('Organisme', array(
             'local' => 'organisme_id',
             'foreign' => 'id'));

        $this->hasOne('Utilisateur as UtilisateurCreatedBy', array(
             'local' => 'created_by',
             'foreign' => 'id'));

        $this->hasOne('Utilisateur as UtilisateurUpdatedBy', array(
             'local' => 'updated_by',
             'foreign' => 'id'));

        $this->hasMany('Point_contact', array(
             'local' => 'id',
             'foreign' => 'laboratoire_id'));

        $this->hasMany('Session_invitation_commission', array(
             'local' => 'id',
             'foreign' => 'laboratoire_id'));

        $this->hasMany('Session_dossier_these_laboratoire', array(
             'local' => 'id',
             'foreign' => 'laboratoire_id'));

        $this->hasMany('Session_dossier_ere_laboratoire', array(
             'local' => 'id',
             'foreign' => 'laboratoire_id'));

        $this->hasMany('Session_dossier_postdoc_laboratoire', array(
             'local' => 'id',
             'foreign' => 'laboratoire_id'));

        $this->hasMany('Intervenant', array(
             'local' => 'id',
             'foreign' => 'laboratoire_id'));

        $this->hasMany('Invitation', array(
             'local' => 'id',
             'foreign' => 'laboratoire_id'));

        $this->hasMany('Dossier_these as DossiersThese', array(
             'refClass' => 'Dossier_these_laboratoire',
             'local' => 'laboratoire_id',
             'foreign' => 'dossier_these_id'));

        $this->hasMany('Dossier_these_laboratoire', array(
             'local' => 'id',
             'foreign' => 'laboratoire_id'));

        $this->hasMany('Dossier_ere as DossiersEre', array(
             'refClass' => 'Dossier_ere_laboratoire',
             'local' => 'laboratoire_id',
             'foreign' => 'dossier_ere_id'));

        $this->hasMany('Dossier_ere_laboratoire', array(
             'local' => 'id',
             'foreign' => 'laboratoire_id'));

        $this->hasMany('Dossier_postdoc as DossiersPostdoc', array(
             'refClass' => 'Dossier_postdoc_laboratoire',
             'local' => 'laboratoire_id',
             'foreign' => 'dossier_postdoc_id'));

        $this->hasMany('Dossier_postdoc_laboratoire', array(
             'local' => 'id',
             'foreign' => 'laboratoire_id'));

        $timestampable0 = new Doctrine_Template_Timestampable(array(
             ));
        $signable0 = new Doctrine_Template_Signable(array(
             ));
        $this->actAs($timestampable0);
        $this->actAs($signable0);
    }
}