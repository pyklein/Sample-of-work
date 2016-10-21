<?php

/**
 * BaseType_evenement_ere
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $intitule
 * @property Doctrine_Collection $Evenement_mris
 * 
 * @method integer             getId()             Returns the current record's "id" value
 * @method string              getIntitule()       Returns the current record's "intitule" value
 * @method Doctrine_Collection getEvenementMris()  Returns the current record's "Evenement_mris" collection
 * @method Type_evenement_ere  setId()             Sets the current record's "id" value
 * @method Type_evenement_ere  setIntitule()       Sets the current record's "intitule" value
 * @method Type_evenement_ere  setEvenementMris()  Sets the current record's "Evenement_mris" collection
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseType_evenement_ere extends gridDoctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('type_evenement_ere');
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
        $this->hasMany('Evenement_mris', array(
             'local' => 'id',
             'foreign' => 'type_evenement_ere_id'));
    }
}