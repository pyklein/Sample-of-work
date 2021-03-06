<?php

/**
 * BaseAvis_mris_dossier_postdoc
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $avis_mris_id
 * @property integer $dossier_postdoc_id
 * @property Avis_mris $Avis_mris
 * @property Dossier_postdoc $Dossier_postdoc
 * 
 * @method integer                   getAvisMrisId()         Returns the current record's "avis_mris_id" value
 * @method integer                   getDossierPostdocId()   Returns the current record's "dossier_postdoc_id" value
 * @method Avis_mris                 getAvisMris()           Returns the current record's "Avis_mris" value
 * @method Dossier_postdoc           getDossierPostdoc()     Returns the current record's "Dossier_postdoc" value
 * @method Avis_mris_dossier_postdoc setAvisMrisId()         Sets the current record's "avis_mris_id" value
 * @method Avis_mris_dossier_postdoc setDossierPostdocId()   Sets the current record's "dossier_postdoc_id" value
 * @method Avis_mris_dossier_postdoc setAvisMris()           Sets the current record's "Avis_mris" value
 * @method Avis_mris_dossier_postdoc setDossierPostdoc()     Sets the current record's "Dossier_postdoc" value
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseAvis_mris_dossier_postdoc extends gridDoctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('avis_mris_dossier_postdoc');
        $this->hasColumn('avis_mris_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('dossier_postdoc_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Avis_mris', array(
             'local' => 'avis_mris_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Dossier_postdoc', array(
             'local' => 'dossier_postdoc_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}