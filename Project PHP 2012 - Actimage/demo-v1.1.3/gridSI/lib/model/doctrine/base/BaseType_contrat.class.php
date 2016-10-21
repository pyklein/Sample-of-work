<?php

/**
 * BaseType_contrat
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $intitule
 * @property string $abreviation
 * @property Doctrine_Collection $Contrat
 * @property Doctrine_Collection $Contrat_type_contrat
 * 
 * @method integer             getId()                   Returns the current record's "id" value
 * @method string              getIntitule()             Returns the current record's "intitule" value
 * @method string              getAbreviation()          Returns the current record's "abreviation" value
 * @method Doctrine_Collection getContrat()              Returns the current record's "Contrat" collection
 * @method Doctrine_Collection getContratTypeContrat()   Returns the current record's "Contrat_type_contrat" collection
 * @method Type_contrat        setId()                   Sets the current record's "id" value
 * @method Type_contrat        setIntitule()             Sets the current record's "intitule" value
 * @method Type_contrat        setAbreviation()          Sets the current record's "abreviation" value
 * @method Type_contrat        setContrat()              Sets the current record's "Contrat" collection
 * @method Type_contrat        setContratTypeContrat()   Sets the current record's "Contrat_type_contrat" collection
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseType_contrat extends gridDoctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('type_contrat');
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
        $this->hasMany('Contrat', array(
             'refClass' => 'Contrat_type_contrat',
             'local' => 'type_contrat_id',
             'foreign' => 'contrat_id'));

        $this->hasMany('Contrat_type_contrat', array(
             'local' => 'id',
             'foreign' => 'type_contrat_id'));
    }
}