<?php

/**
 * BaseLiaison_mip_bpi
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $dossier_mip_id
 * @property integer $dossier_bpi_id
 * @property Dossier_mip $Dossier_mip
 * @property Dossier_bpi $Dossier_bpi
 * 
 * @method integer         getDossierMipId()   Returns the current record's "dossier_mip_id" value
 * @method integer         getDossierBpiId()   Returns the current record's "dossier_bpi_id" value
 * @method Dossier_mip     getDossierMip()     Returns the current record's "Dossier_mip" value
 * @method Dossier_bpi     getDossierBpi()     Returns the current record's "Dossier_bpi" value
 * @method Liaison_mip_bpi setDossierMipId()   Sets the current record's "dossier_mip_id" value
 * @method Liaison_mip_bpi setDossierBpiId()   Sets the current record's "dossier_bpi_id" value
 * @method Liaison_mip_bpi setDossierMip()     Sets the current record's "Dossier_mip" value
 * @method Liaison_mip_bpi setDossierBpi()     Sets the current record's "Dossier_bpi" value
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseLiaison_mip_bpi extends gridDoctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('liaison_mip_bpi');
        $this->hasColumn('dossier_mip_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('dossier_bpi_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Dossier_mip', array(
             'local' => 'dossier_mip_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Dossier_bpi', array(
             'local' => 'dossier_bpi_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}