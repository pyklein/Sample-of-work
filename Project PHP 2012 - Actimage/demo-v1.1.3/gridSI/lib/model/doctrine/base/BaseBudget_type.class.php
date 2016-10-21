<?php

/**
 * BaseBudget_type
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $intitule
 * @property boolean $est_negatif
 * @property Doctrine_Collection $Budget
 * @property Doctrine_Collection $Financement
 * 
 * @method integer             getId()          Returns the current record's "id" value
 * @method string              getIntitule()    Returns the current record's "intitule" value
 * @method boolean             getEstNegatif()  Returns the current record's "est_negatif" value
 * @method Doctrine_Collection getBudget()      Returns the current record's "Budget" collection
 * @method Doctrine_Collection getFinancement() Returns the current record's "Financement" collection
 * @method Budget_type         setId()          Sets the current record's "id" value
 * @method Budget_type         setIntitule()    Sets the current record's "intitule" value
 * @method Budget_type         setEstNegatif()  Sets the current record's "est_negatif" value
 * @method Budget_type         setBudget()      Sets the current record's "Budget" collection
 * @method Budget_type         setFinancement() Sets the current record's "Financement" collection
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseBudget_type extends gridDoctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('budget_type');
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
        $this->hasColumn('est_negatif', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Budget', array(
             'local' => 'id',
             'foreign' => 'budget_type_id'));

        $this->hasMany('Financement', array(
             'local' => 'id',
             'foreign' => 'budget_type_id'));
    }
}