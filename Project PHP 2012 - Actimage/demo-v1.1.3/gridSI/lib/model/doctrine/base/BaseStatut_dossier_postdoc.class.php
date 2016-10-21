<?php

/**
 * BaseStatut_dossier_postdoc
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $intitule
 * @property Doctrine_Collection $Dossier_postdoc
 * 
 * @method integer                getId()              Returns the current record's "id" value
 * @method string                 getIntitule()        Returns the current record's "intitule" value
 * @method Doctrine_Collection    getDossierPostdoc()  Returns the current record's "Dossier_postdoc" collection
 * @method Statut_dossier_postdoc setId()              Sets the current record's "id" value
 * @method Statut_dossier_postdoc setIntitule()        Sets the current record's "intitule" value
 * @method Statut_dossier_postdoc setDossierPostdoc()  Sets the current record's "Dossier_postdoc" collection
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseStatut_dossier_postdoc extends gridDoctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('statut_dossier_postdoc');
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
        $this->hasMany('Dossier_postdoc', array(
             'local' => 'id',
             'foreign' => 'statut_dossier_postdoc_id'));
    }
}