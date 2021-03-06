<?php

/**
 * BaseType_suivi_these
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $intitule
 * @property Doctrine_Collection $Suivi_dossier_these
 * 
 * @method integer             getId()                  Returns the current record's "id" value
 * @method string              getIntitule()            Returns the current record's "intitule" value
 * @method Doctrine_Collection getSuiviDossierThese()   Returns the current record's "Suivi_dossier_these" collection
 * @method Type_suivi_these    setId()                  Sets the current record's "id" value
 * @method Type_suivi_these    setIntitule()            Sets the current record's "intitule" value
 * @method Type_suivi_these    setSuiviDossierThese()   Sets the current record's "Suivi_dossier_these" collection
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseType_suivi_these extends gridDoctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('type_suivi_these');
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
        $this->hasMany('Suivi_dossier_these', array(
             'local' => 'id',
             'foreign' => 'type_suivi_these_id'));
    }
}