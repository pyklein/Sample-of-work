<?php

/**
 * BaseType_contentieux_tiers
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $intitule
 * @property Doctrine_Collection $Contentieux_avec_tiers
 * 
 * @method integer                getId()                     Returns the current record's "id" value
 * @method string                 getIntitule()               Returns the current record's "intitule" value
 * @method Doctrine_Collection    getContentieuxAvecTiers()   Returns the current record's "Contentieux_avec_tiers" collection
 * @method Type_contentieux_tiers setId()                     Sets the current record's "id" value
 * @method Type_contentieux_tiers setIntitule()               Sets the current record's "intitule" value
 * @method Type_contentieux_tiers setContentieuxAvecTiers()   Sets the current record's "Contentieux_avec_tiers" collection
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseType_contentieux_tiers extends gridDoctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('type_contentieux_tiers');
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
        $this->hasMany('Contentieux_avec_tiers', array(
             'local' => 'id',
             'foreign' => 'type_contentieux_tiers_id'));
    }
}