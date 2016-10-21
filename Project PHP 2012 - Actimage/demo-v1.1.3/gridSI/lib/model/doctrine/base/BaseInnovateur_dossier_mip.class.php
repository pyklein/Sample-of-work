<?php

/**
 * BaseInnovateur_dossier_mip
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $dossier_mip_id
 * @property integer $utilisateur_id
 * @property integer $type_innovateur_id
 * @property Dossier_mip $Dossier_mip
 * @property Utilisateur $Innovateur
 * @property Type_innovateur $Type_innovateur
 * 
 * @method integer                getDossierMipId()       Returns the current record's "dossier_mip_id" value
 * @method integer                getUtilisateurId()      Returns the current record's "utilisateur_id" value
 * @method integer                getTypeInnovateurId()   Returns the current record's "type_innovateur_id" value
 * @method Dossier_mip            getDossierMip()         Returns the current record's "Dossier_mip" value
 * @method Utilisateur            getInnovateur()         Returns the current record's "Innovateur" value
 * @method Type_innovateur        getTypeInnovateur()     Returns the current record's "Type_innovateur" value
 * @method Innovateur_dossier_mip setDossierMipId()       Sets the current record's "dossier_mip_id" value
 * @method Innovateur_dossier_mip setUtilisateurId()      Sets the current record's "utilisateur_id" value
 * @method Innovateur_dossier_mip setTypeInnovateurId()   Sets the current record's "type_innovateur_id" value
 * @method Innovateur_dossier_mip setDossierMip()         Sets the current record's "Dossier_mip" value
 * @method Innovateur_dossier_mip setInnovateur()         Sets the current record's "Innovateur" value
 * @method Innovateur_dossier_mip setTypeInnovateur()     Sets the current record's "Type_innovateur" value
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseInnovateur_dossier_mip extends gridDoctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('innovateur_dossier_mip');
        $this->hasColumn('dossier_mip_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('utilisateur_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('type_innovateur_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Dossier_mip', array(
             'local' => 'dossier_mip_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Utilisateur as Innovateur', array(
             'local' => 'utilisateur_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Type_innovateur', array(
             'local' => 'type_innovateur_id',
             'foreign' => 'id'));
    }
}