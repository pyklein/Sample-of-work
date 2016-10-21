<?php

/**
 * BaseStatut
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $intitule
 * @property Doctrine_Collection $Utilisateur
 * 
 * @method integer             getId()          Returns the current record's "id" value
 * @method string              getIntitule()    Returns the current record's "intitule" value
 * @method Doctrine_Collection getUtilisateur() Returns the current record's "Utilisateur" collection
 * @method Statut              setId()          Sets the current record's "id" value
 * @method Statut              setIntitule()    Sets the current record's "intitule" value
 * @method Statut              setUtilisateur() Sets the current record's "Utilisateur" collection
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseStatut extends gridDoctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('statut');
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
        $this->hasMany('Utilisateur', array(
             'local' => 'id',
             'foreign' => 'statut_id'));
    }
}