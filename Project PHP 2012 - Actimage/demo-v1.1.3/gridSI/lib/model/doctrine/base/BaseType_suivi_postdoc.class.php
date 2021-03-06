<?php

/**
 * BaseType_suivi_postdoc
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $intitule
 * @property Doctrine_Collection $Suivi_dossier_postdoc
 * 
 * @method integer             getId()                    Returns the current record's "id" value
 * @method string              getIntitule()              Returns the current record's "intitule" value
 * @method Doctrine_Collection getSuiviDossierPostdoc()   Returns the current record's "Suivi_dossier_postdoc" collection
 * @method Type_suivi_postdoc  setId()                    Sets the current record's "id" value
 * @method Type_suivi_postdoc  setIntitule()              Sets the current record's "intitule" value
 * @method Type_suivi_postdoc  setSuiviDossierPostdoc()   Sets the current record's "Suivi_dossier_postdoc" collection
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseType_suivi_postdoc extends gridDoctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('type_suivi_postdoc');
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
        $this->hasMany('Suivi_dossier_postdoc', array(
             'local' => 'id',
             'foreign' => 'type_suivi_postdoc_id'));
    }
}