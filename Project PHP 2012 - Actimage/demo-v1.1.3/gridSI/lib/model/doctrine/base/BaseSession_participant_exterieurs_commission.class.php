<?php

/**
 * BaseSession_participant_exterieurs_commission
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $intervenant_id
 * @property string $transaction_token
 * @property boolean $est_concerne
 * @property Intervenant $Intervenant
 * 
 * @method integer                                   getIntervenantId()     Returns the current record's "intervenant_id" value
 * @method string                                    getTransactionToken()  Returns the current record's "transaction_token" value
 * @method boolean                                   getEstConcerne()       Returns the current record's "est_concerne" value
 * @method Intervenant                               getIntervenant()       Returns the current record's "Intervenant" value
 * @method Session_participant_exterieurs_commission setIntervenantId()     Sets the current record's "intervenant_id" value
 * @method Session_participant_exterieurs_commission setTransactionToken()  Sets the current record's "transaction_token" value
 * @method Session_participant_exterieurs_commission setEstConcerne()       Sets the current record's "est_concerne" value
 * @method Session_participant_exterieurs_commission setIntervenant()       Sets the current record's "Intervenant" value
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseSession_participant_exterieurs_commission extends gridDoctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('session_participant_exterieurs_commission');
        $this->hasColumn('intervenant_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('transaction_token', 'string', 20, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 20,
             ));
        $this->hasColumn('est_concerne', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Intervenant', array(
             'local' => 'intervenant_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}