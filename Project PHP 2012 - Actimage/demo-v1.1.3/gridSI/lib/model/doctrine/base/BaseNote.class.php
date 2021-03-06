<?php

/**
 * BaseNote
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $intitule
 * @property boolean $est_selection
 * @property Doctrine_Collection $Evaluation
 * 
 * @method integer             getId()            Returns the current record's "id" value
 * @method string              getIntitule()      Returns the current record's "intitule" value
 * @method boolean             getEstSelection()  Returns the current record's "est_selection" value
 * @method Doctrine_Collection getEvaluation()    Returns the current record's "Evaluation" collection
 * @method Note                setId()            Sets the current record's "id" value
 * @method Note                setIntitule()      Sets the current record's "intitule" value
 * @method Note                setEstSelection()  Sets the current record's "est_selection" value
 * @method Note                setEvaluation()    Sets the current record's "Evaluation" collection
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseNote extends gridDoctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('note');
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
        $this->hasColumn('est_selection', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Evaluation', array(
             'local' => 'id',
             'foreign' => 'note_id'));
    }
}