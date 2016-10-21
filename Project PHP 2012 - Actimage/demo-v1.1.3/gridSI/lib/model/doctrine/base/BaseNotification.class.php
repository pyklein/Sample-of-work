<?php

/**
 * BaseNotification
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $metier_id
 * @property string $contenu
 * @property timestamp $date_debut
 * @property timestamp $date_fin
 * @property boolean $est_actif
 * @property Utilisateur $UtilisateurCreatedBy
 * @property Utilisateur $UtilisateurUpdatedBy
 * @property Metier $Metier
 * 
 * @method integer      getMetierId()             Returns the current record's "metier_id" value
 * @method string       getContenu()              Returns the current record's "contenu" value
 * @method timestamp    getDateDebut()            Returns the current record's "date_debut" value
 * @method timestamp    getDateFin()              Returns the current record's "date_fin" value
 * @method boolean      getEstActif()             Returns the current record's "est_actif" value
 * @method Utilisateur  getUtilisateurCreatedBy() Returns the current record's "UtilisateurCreatedBy" value
 * @method Utilisateur  getUtilisateurUpdatedBy() Returns the current record's "UtilisateurUpdatedBy" value
 * @method Metier       getMetier()               Returns the current record's "Metier" value
 * @method Notification setMetierId()             Sets the current record's "metier_id" value
 * @method Notification setContenu()              Sets the current record's "contenu" value
 * @method Notification setDateDebut()            Sets the current record's "date_debut" value
 * @method Notification setDateFin()              Sets the current record's "date_fin" value
 * @method Notification setEstActif()             Sets the current record's "est_actif" value
 * @method Notification setUtilisateurCreatedBy() Sets the current record's "UtilisateurCreatedBy" value
 * @method Notification setUtilisateurUpdatedBy() Sets the current record's "UtilisateurUpdatedBy" value
 * @method Notification setMetier()               Sets the current record's "Metier" value
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseNotification extends gridDoctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('notification');
        $this->hasColumn('metier_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('contenu', 'string', null, array(
             'type' => 'string',
             'notnull' => true,
             ));
        $this->hasColumn('date_debut', 'timestamp', null, array(
             'type' => 'timestamp',
             'notnull' => true,
             ));
        $this->hasColumn('date_fin', 'timestamp', null, array(
             'type' => 'timestamp',
             'notnull' => true,
             ));
        $this->hasColumn('est_actif', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => 1,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Utilisateur as UtilisateurCreatedBy', array(
             'local' => 'created_by',
             'foreign' => 'id'));

        $this->hasOne('Utilisateur as UtilisateurUpdatedBy', array(
             'local' => 'updated_by',
             'foreign' => 'id'));

        $this->hasOne('Metier', array(
             'local' => 'metier_id',
             'foreign' => 'id'));

        $timestampable0 = new Doctrine_Template_Timestampable(array(
             ));
        $signable0 = new Doctrine_Template_Signable(array(
             ));
        $this->actAs($timestampable0);
        $this->actAs($signable0);
    }
}