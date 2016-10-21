<?php

/**
 * BaseMail
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $sujet
 * @property string $message
 * @property string $destinataire
 * @property integer $statut_id
 * @property integer $nombre_tentative
 * @property timestamp $date_envoi
 * @property Utilisateur $UtilisateurCreatedBy
 * @property Mail_statut $Mail_statut
 * 
 * @method string      getSujet()                Returns the current record's "sujet" value
 * @method string      getMessage()              Returns the current record's "message" value
 * @method string      getDestinataire()         Returns the current record's "destinataire" value
 * @method integer     getStatutId()             Returns the current record's "statut_id" value
 * @method integer     getNombreTentative()      Returns the current record's "nombre_tentative" value
 * @method timestamp   getDateEnvoi()            Returns the current record's "date_envoi" value
 * @method Utilisateur getUtilisateurCreatedBy() Returns the current record's "UtilisateurCreatedBy" value
 * @method Mail_statut getMailStatut()           Returns the current record's "Mail_statut" value
 * @method Mail        setSujet()                Sets the current record's "sujet" value
 * @method Mail        setMessage()              Sets the current record's "message" value
 * @method Mail        setDestinataire()         Sets the current record's "destinataire" value
 * @method Mail        setStatutId()             Sets the current record's "statut_id" value
 * @method Mail        setNombreTentative()      Sets the current record's "nombre_tentative" value
 * @method Mail        setDateEnvoi()            Sets the current record's "date_envoi" value
 * @method Mail        setUtilisateurCreatedBy() Sets the current record's "UtilisateurCreatedBy" value
 * @method Mail        setMailStatut()           Sets the current record's "Mail_statut" value
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseMail extends gridDoctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('mail');
        $this->hasColumn('sujet', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('message', 'string', null, array(
             'type' => 'string',
             'notnull' => true,
             ));
        $this->hasColumn('destinataire', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('statut_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 1,
             ));
        $this->hasColumn('nombre_tentative', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('date_envoi', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Utilisateur as UtilisateurCreatedBy', array(
             'local' => 'created_by',
             'foreign' => 'id'));

        $this->hasOne('Mail_statut', array(
             'local' => 'statut_id',
             'foreign' => 'id'));

        $timestampable0 = new Doctrine_Template_Timestampable(array(
             ));
        $signable0 = new Doctrine_Template_Signable(array(
             ));
        $this->actAs($timestampable0);
        $this->actAs($signable0);
    }
}