<?php

/**
 * BaseMetier
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $intitule
 * @property boolean $est_administrateur
 * @property Doctrine_Collection $Profil
 * @property Doctrine_Collection $Notification
 * @property Doctrine_Collection $Contact_se
 * @property Doctrine_Collection $Point_contact
 * @property Doctrine_Collection $View_recherche
 * @property Doctrine_Collection $Libelle_organisme
 * 
 * @method integer             getId()                 Returns the current record's "id" value
 * @method string              getIntitule()           Returns the current record's "intitule" value
 * @method boolean             getEstAdministrateur()  Returns the current record's "est_administrateur" value
 * @method Doctrine_Collection getProfil()             Returns the current record's "Profil" collection
 * @method Doctrine_Collection getNotification()       Returns the current record's "Notification" collection
 * @method Doctrine_Collection getContactSe()          Returns the current record's "Contact_se" collection
 * @method Doctrine_Collection getPointContact()       Returns the current record's "Point_contact" collection
 * @method Doctrine_Collection getViewRecherche()      Returns the current record's "View_recherche" collection
 * @method Doctrine_Collection getLibelleOrganisme()   Returns the current record's "Libelle_organisme" collection
 * @method Metier              setId()                 Sets the current record's "id" value
 * @method Metier              setIntitule()           Sets the current record's "intitule" value
 * @method Metier              setEstAdministrateur()  Sets the current record's "est_administrateur" value
 * @method Metier              setProfil()             Sets the current record's "Profil" collection
 * @method Metier              setNotification()       Sets the current record's "Notification" collection
 * @method Metier              setContactSe()          Sets the current record's "Contact_se" collection
 * @method Metier              setPointContact()       Sets the current record's "Point_contact" collection
 * @method Metier              setViewRecherche()      Sets the current record's "View_recherche" collection
 * @method Metier              setLibelleOrganisme()   Sets the current record's "Libelle_organisme" collection
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseMetier extends gridDoctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('metier');
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
        $this->hasColumn('est_administrateur', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Profil', array(
             'local' => 'id',
             'foreign' => 'metier_id'));

        $this->hasMany('Notification', array(
             'local' => 'id',
             'foreign' => 'metier_id'));

        $this->hasMany('Contact_se', array(
             'local' => 'id',
             'foreign' => 'metier_id'));

        $this->hasMany('Point_contact', array(
             'local' => 'id',
             'foreign' => 'metier_id'));

        $this->hasMany('View_recherche', array(
             'local' => 'id',
             'foreign' => 'metier_id'));

        $this->hasMany('Libelle_organisme', array(
             'local' => 'id',
             'foreign' => 'metier_id'));
    }
}