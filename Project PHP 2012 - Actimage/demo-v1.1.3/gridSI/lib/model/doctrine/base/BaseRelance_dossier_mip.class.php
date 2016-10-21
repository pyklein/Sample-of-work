<?php

/**
 * BaseRelance_dossier_mip
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $dossier_mip_id
 * @property integer $type_relance_dossier_mip_id
 * @property Type_relance_dossier_mip $TypeRelance
 * @property Dossier_mip $DossierMIP
 * 
 * @method integer                  getDossierMipId()                Returns the current record's "dossier_mip_id" value
 * @method integer                  getTypeRelanceDossierMipId()     Returns the current record's "type_relance_dossier_mip_id" value
 * @method Type_relance_dossier_mip getTypeRelance()                 Returns the current record's "TypeRelance" value
 * @method Dossier_mip              getDossierMIP()                  Returns the current record's "DossierMIP" value
 * @method Relance_dossier_mip      setDossierMipId()                Sets the current record's "dossier_mip_id" value
 * @method Relance_dossier_mip      setTypeRelanceDossierMipId()     Sets the current record's "type_relance_dossier_mip_id" value
 * @method Relance_dossier_mip      setTypeRelance()                 Sets the current record's "TypeRelance" value
 * @method Relance_dossier_mip      setDossierMIP()                  Sets the current record's "DossierMIP" value
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseRelance_dossier_mip extends gridDoctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('relance_dossier_mip');
        $this->hasColumn('dossier_mip_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('type_relance_dossier_mip_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Type_relance_dossier_mip as TypeRelance', array(
             'local' => 'type_relance_dossier_mip_id',
             'foreign' => 'id'));

        $this->hasOne('Dossier_mip as DossierMIP', array(
             'local' => 'dossier_mip_id',
             'foreign' => 'id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}