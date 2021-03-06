<?php

/**
 * BaseStatut_contrat
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $intitule
 * @property Doctrine_Collection $Contrat
 * 
 * @method integer             getId()       Returns the current record's "id" value
 * @method string              getIntitule() Returns the current record's "intitule" value
 * @method Doctrine_Collection getContrat()  Returns the current record's "Contrat" collection
 * @method Statut_contrat      setId()       Sets the current record's "id" value
 * @method Statut_contrat      setIntitule() Sets the current record's "intitule" value
 * @method Statut_contrat      setContrat()  Sets the current record's "Contrat" collection
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseStatut_contrat extends gridDoctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('statut_contrat');
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
        $this->hasMany('Contrat', array(
             'local' => 'id',
             'foreign' => 'statut_contrat_id'));
    }
}