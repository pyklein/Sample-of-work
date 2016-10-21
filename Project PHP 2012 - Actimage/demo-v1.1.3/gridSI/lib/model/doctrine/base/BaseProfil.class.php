<?php

/**
 * BaseProfil
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $intitule
 * @property string $code
 * @property integer $metier_id
 * @property integer $priorite
 * @property Metier $Metier
 * @property Doctrine_Collection $Utilisateurs
 * @property Doctrine_Collection $Utilisateur_profil
 * 
 * @method string              getIntitule()           Returns the current record's "intitule" value
 * @method string              getCode()               Returns the current record's "code" value
 * @method integer             getMetierId()           Returns the current record's "metier_id" value
 * @method integer             getPriorite()           Returns the current record's "priorite" value
 * @method Metier              getMetier()             Returns the current record's "Metier" value
 * @method Doctrine_Collection getUtilisateurs()       Returns the current record's "Utilisateurs" collection
 * @method Doctrine_Collection getUtilisateurProfil()  Returns the current record's "Utilisateur_profil" collection
 * @method Profil              setIntitule()           Sets the current record's "intitule" value
 * @method Profil              setCode()               Sets the current record's "code" value
 * @method Profil              setMetierId()           Sets the current record's "metier_id" value
 * @method Profil              setPriorite()           Sets the current record's "priorite" value
 * @method Profil              setMetier()             Sets the current record's "Metier" value
 * @method Profil              setUtilisateurs()       Sets the current record's "Utilisateurs" collection
 * @method Profil              setUtilisateurProfil()  Sets the current record's "Utilisateur_profil" collection
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseProfil extends gridDoctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('profil');
        $this->hasColumn('intitule', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('code', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('metier_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('priorite', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Metier', array(
             'local' => 'metier_id',
             'foreign' => 'id'));

        $this->hasMany('Utilisateur as Utilisateurs', array(
             'refClass' => 'Utilisateur_profil',
             'local' => 'profil_id',
             'foreign' => 'utilisateur_id'));

        $this->hasMany('Utilisateur_profil', array(
             'local' => 'id',
             'foreign' => 'profil_id'));
    }
}