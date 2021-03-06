<?php

/**
 * BaseType_action
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $intitule
 * @property Doctrine_Collection $Action
 * 
 * @method integer             getId()       Returns the current record's "id" value
 * @method string              getIntitule() Returns the current record's "intitule" value
 * @method Doctrine_Collection getAction()   Returns the current record's "Action" collection
 * @method Type_action         setId()       Sets the current record's "id" value
 * @method Type_action         setIntitule() Sets the current record's "intitule" value
 * @method Type_action         setAction()   Sets the current record's "Action" collection
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseType_action extends gridDoctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('type_action');
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
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Action', array(
             'local' => 'id',
             'foreign' => 'type_action_id'));
    }
}