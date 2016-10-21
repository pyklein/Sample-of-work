<?php

/**
 * BaseSession_dossier_these_laboratoire
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $dossier_these_id
 * @property integer $laboratoire_id
 * @property string $transaction_token
 * @property Dossier_these $DossierThese
 * @property Laboratoire $Laboratoire
 * 
 * @method integer                           getDossierTheseId()    Returns the current record's "dossier_these_id" value
 * @method integer                           getLaboratoireId()     Returns the current record's "laboratoire_id" value
 * @method string                            getTransactionToken()  Returns the current record's "transaction_token" value
 * @method Dossier_these                     getDossierThese()      Returns the current record's "DossierThese" value
 * @method Laboratoire                       getLaboratoire()       Returns the current record's "Laboratoire" value
 * @method Session_dossier_these_laboratoire setDossierTheseId()    Sets the current record's "dossier_these_id" value
 * @method Session_dossier_these_laboratoire setLaboratoireId()     Sets the current record's "laboratoire_id" value
 * @method Session_dossier_these_laboratoire setTransactionToken()  Sets the current record's "transaction_token" value
 * @method Session_dossier_these_laboratoire setDossierThese()      Sets the current record's "DossierThese" value
 * @method Session_dossier_these_laboratoire setLaboratoire()       Sets the current record's "Laboratoire" value
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseSession_dossier_these_laboratoire extends gridDoctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('session_dossier_these_laboratoire');
        $this->hasColumn('dossier_these_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('laboratoire_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('transaction_token', 'string', 20, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 20,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Dossier_these as DossierThese', array(
             'local' => 'dossier_these_id',
             'foreign' => 'id'));

        $this->hasOne('Laboratoire', array(
             'local' => 'laboratoire_id',
             'foreign' => 'id'));
    }
}