<?php

/**
 * BaseMode_transmission
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $intitule
 * @property Doctrine_Collection $Remise_documents
 * 
 * @method integer             getId()               Returns the current record's "id" value
 * @method string              getIntitule()         Returns the current record's "intitule" value
 * @method Doctrine_Collection getRemiseDocuments()  Returns the current record's "Remise_documents" collection
 * @method Mode_transmission   setId()               Sets the current record's "id" value
 * @method Mode_transmission   setIntitule()         Sets the current record's "intitule" value
 * @method Mode_transmission   setRemiseDocuments()  Sets the current record's "Remise_documents" collection
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseMode_transmission extends gridDoctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('mode_transmission');
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
        $this->hasMany('Remise_documents', array(
             'local' => 'id',
             'foreign' => 'mode_transmission_ea'));
    }
}