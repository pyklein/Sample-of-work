<?php

/**
 * BaseType_contentieux
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $intitule
 * @property Doctrine_Collection $Contentieux
 * 
 * @method integer             getId()          Returns the current record's "id" value
 * @method string              getIntitule()    Returns the current record's "intitule" value
 * @method Doctrine_Collection getContentieux() Returns the current record's "Contentieux" collection
 * @method Type_contentieux    setId()          Sets the current record's "id" value
 * @method Type_contentieux    setIntitule()    Sets the current record's "intitule" value
 * @method Type_contentieux    setContentieux() Sets the current record's "Contentieux" collection
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseType_contentieux extends gridDoctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('type_contentieux');
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
        $this->hasMany('Contentieux', array(
             'local' => 'id',
             'foreign' => 'type_contentieux_id'));
    }
}