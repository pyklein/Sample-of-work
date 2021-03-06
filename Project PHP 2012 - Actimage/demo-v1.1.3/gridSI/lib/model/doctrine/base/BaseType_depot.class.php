<?php

/**
 * BaseType_depot
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $intitule
 * @property string $abreviation
 * @property Doctrine_Collection $Brevet
 * 
 * @method integer             getId()          Returns the current record's "id" value
 * @method string              getIntitule()    Returns the current record's "intitule" value
 * @method string              getAbreviation() Returns the current record's "abreviation" value
 * @method Doctrine_Collection getBrevet()      Returns the current record's "Brevet" collection
 * @method Type_depot          setId()          Sets the current record's "id" value
 * @method Type_depot          setIntitule()    Sets the current record's "intitule" value
 * @method Type_depot          setAbreviation() Sets the current record's "abreviation" value
 * @method Type_depot          setBrevet()      Sets the current record's "Brevet" collection
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseType_depot extends gridDoctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('type_depot');
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
        $this->hasColumn('abreviation', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Brevet', array(
             'local' => 'id',
             'foreign' => 'type_depot_id'));
    }
}