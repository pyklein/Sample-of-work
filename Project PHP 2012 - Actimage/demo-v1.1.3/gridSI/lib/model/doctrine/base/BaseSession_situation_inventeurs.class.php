<?php

/**
 * BaseSession_situation_inventeurs
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $inventeur_id
 * @property string $transaction_token
 * @property integer $part_inventive
 * @property Inventeur $Inventeur
 * 
 * @method integer                      getInventeurId()       Returns the current record's "inventeur_id" value
 * @method string                       getTransactionToken()  Returns the current record's "transaction_token" value
 * @method integer                      getPartInventive()     Returns the current record's "part_inventive" value
 * @method Inventeur                    getInventeur()         Returns the current record's "Inventeur" value
 * @method Session_situation_inventeurs setInventeurId()       Sets the current record's "inventeur_id" value
 * @method Session_situation_inventeurs setTransactionToken()  Sets the current record's "transaction_token" value
 * @method Session_situation_inventeurs setPartInventive()     Sets the current record's "part_inventive" value
 * @method Session_situation_inventeurs setInventeur()         Sets the current record's "Inventeur" value
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseSession_situation_inventeurs extends gridDoctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('session_situation_inventeurs');
        $this->hasColumn('inventeur_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('transaction_token', 'string', 20, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 20,
             ));
        $this->hasColumn('part_inventive', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Inventeur', array(
             'local' => 'inventeur_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}