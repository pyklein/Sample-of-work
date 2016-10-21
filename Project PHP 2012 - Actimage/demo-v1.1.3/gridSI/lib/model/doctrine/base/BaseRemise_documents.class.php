<?php

/**
 * BaseRemise_documents
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property timestamp $date_reception_ea
 * @property string $reference_ea
 * @property timestamp $date_envoi_ar_ea
 * @property string $reference_ar_ea
 * @property integer $mode_transmission_ea
 * @property timestamp $date_reception_cr
 * @property string $reference_cr
 * @property timestamp $date_envoi_ar_cr
 * @property string $reference_ar_cr
 * @property integer $mode_transmission_cr
 * @property timestamp $date_reception_video
 * @property string $reference_video
 * @property timestamp $date_envoi_ar_video
 * @property string $reference_ar_video
 * @property integer $mode_transmission_video
 * @property timestamp $date_soutien
 * @property integer $reference_soutien
 * @property integer $dossier_mip_id
 * @property Utilisateur $UtilisateurCreatedBy
 * @property Utilisateur $UtilisateurUpdatedBy
 * @property Mode_transmission $ModeTransmissionEA
 * @property Mode_transmission $ModeTransmissionCR
 * @property Mode_transmission $ModeTransmissionVideo
 * @property Dossier_mip $Dossier_mip
 * 
 * @method timestamp         getDateReceptionEa()         Returns the current record's "date_reception_ea" value
 * @method string            getReferenceEa()             Returns the current record's "reference_ea" value
 * @method timestamp         getDateEnvoiArEa()           Returns the current record's "date_envoi_ar_ea" value
 * @method string            getReferenceArEa()           Returns the current record's "reference_ar_ea" value
 * @method integer           getModeTransmissionEa()      Returns the current record's "mode_transmission_ea" value
 * @method timestamp         getDateReceptionCr()         Returns the current record's "date_reception_cr" value
 * @method string            getReferenceCr()             Returns the current record's "reference_cr" value
 * @method timestamp         getDateEnvoiArCr()           Returns the current record's "date_envoi_ar_cr" value
 * @method string            getReferenceArCr()           Returns the current record's "reference_ar_cr" value
 * @method integer           getModeTransmissionCr()      Returns the current record's "mode_transmission_cr" value
 * @method timestamp         getDateReceptionVideo()      Returns the current record's "date_reception_video" value
 * @method string            getReferenceVideo()          Returns the current record's "reference_video" value
 * @method timestamp         getDateEnvoiArVideo()        Returns the current record's "date_envoi_ar_video" value
 * @method string            getReferenceArVideo()        Returns the current record's "reference_ar_video" value
 * @method integer           getModeTransmissionVideo()   Returns the current record's "mode_transmission_video" value
 * @method timestamp         getDateSoutien()             Returns the current record's "date_soutien" value
 * @method integer           getReferenceSoutien()        Returns the current record's "reference_soutien" value
 * @method integer           getDossierMipId()            Returns the current record's "dossier_mip_id" value
 * @method Utilisateur       getUtilisateurCreatedBy()    Returns the current record's "UtilisateurCreatedBy" value
 * @method Utilisateur       getUtilisateurUpdatedBy()    Returns the current record's "UtilisateurUpdatedBy" value
 * @method Mode_transmission getModeTransmissionEA()      Returns the current record's "ModeTransmissionEA" value
 * @method Mode_transmission getModeTransmissionCR()      Returns the current record's "ModeTransmissionCR" value
 * @method Mode_transmission getModeTransmissionVideo()   Returns the current record's "ModeTransmissionVideo" value
 * @method Dossier_mip       getDossierMip()              Returns the current record's "Dossier_mip" value
 * @method Remise_documents  setDateReceptionEa()         Sets the current record's "date_reception_ea" value
 * @method Remise_documents  setReferenceEa()             Sets the current record's "reference_ea" value
 * @method Remise_documents  setDateEnvoiArEa()           Sets the current record's "date_envoi_ar_ea" value
 * @method Remise_documents  setReferenceArEa()           Sets the current record's "reference_ar_ea" value
 * @method Remise_documents  setModeTransmissionEa()      Sets the current record's "mode_transmission_ea" value
 * @method Remise_documents  setDateReceptionCr()         Sets the current record's "date_reception_cr" value
 * @method Remise_documents  setReferenceCr()             Sets the current record's "reference_cr" value
 * @method Remise_documents  setDateEnvoiArCr()           Sets the current record's "date_envoi_ar_cr" value
 * @method Remise_documents  setReferenceArCr()           Sets the current record's "reference_ar_cr" value
 * @method Remise_documents  setModeTransmissionCr()      Sets the current record's "mode_transmission_cr" value
 * @method Remise_documents  setDateReceptionVideo()      Sets the current record's "date_reception_video" value
 * @method Remise_documents  setReferenceVideo()          Sets the current record's "reference_video" value
 * @method Remise_documents  setDateEnvoiArVideo()        Sets the current record's "date_envoi_ar_video" value
 * @method Remise_documents  setReferenceArVideo()        Sets the current record's "reference_ar_video" value
 * @method Remise_documents  setModeTransmissionVideo()   Sets the current record's "mode_transmission_video" value
 * @method Remise_documents  setDateSoutien()             Sets the current record's "date_soutien" value
 * @method Remise_documents  setReferenceSoutien()        Sets the current record's "reference_soutien" value
 * @method Remise_documents  setDossierMipId()            Sets the current record's "dossier_mip_id" value
 * @method Remise_documents  setUtilisateurCreatedBy()    Sets the current record's "UtilisateurCreatedBy" value
 * @method Remise_documents  setUtilisateurUpdatedBy()    Sets the current record's "UtilisateurUpdatedBy" value
 * @method Remise_documents  setModeTransmissionEA()      Sets the current record's "ModeTransmissionEA" value
 * @method Remise_documents  setModeTransmissionCR()      Sets the current record's "ModeTransmissionCR" value
 * @method Remise_documents  setModeTransmissionVideo()   Sets the current record's "ModeTransmissionVideo" value
 * @method Remise_documents  setDossierMip()              Sets the current record's "Dossier_mip" value
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseRemise_documents extends gridDoctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('remise_documents');
        $this->hasColumn('date_reception_ea', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('reference_ea', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('date_envoi_ar_ea', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('reference_ar_ea', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('mode_transmission_ea', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('date_reception_cr', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('reference_cr', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('date_envoi_ar_cr', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('reference_ar_cr', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('mode_transmission_cr', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('date_reception_video', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('reference_video', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('date_envoi_ar_video', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('reference_ar_video', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('mode_transmission_video', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('date_soutien', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('reference_soutien', 'integer', null, array(
             'type' => 'integer',
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

        $this->hasOne('Mode_transmission as ModeTransmissionEA', array(
             'local' => 'mode_transmission_ea',
             'foreign' => 'id'));

        $this->hasOne('Mode_transmission as ModeTransmissionCR', array(
             'local' => 'mode_transmission_cr',
             'foreign' => 'id'));

        $this->hasOne('Mode_transmission as ModeTransmissionVideo', array(
             'local' => 'mode_transmission_video',
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