<?php

/**
 * BaseClassement_invention_inventeur
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $dossier_bpi_id
 * @property integer $concerne_id
 * @property integer $classement_autorite_id
 * @property integer $classement_hierarchie_id
 * @property integer $classement_propose_id
 * @property integer $classement_final_id
 * @property Dossier_bpi $Dossier_bpi
 * @property Classement $Classement_autorite
 * @property Classement $Classement_hierarchie
 * @property Classement $Classement_propose
 * @property Classement $Classement_final
 * @property Inventeur $Concerne
 * @property Utilisateur $UtilisateurCreatedBy
 * @property Utilisateur $UtilisateurUpdatedBy
 * 
 * @method integer                        getDossierBpiId()             Returns the current record's "dossier_bpi_id" value
 * @method integer                        getConcerneId()               Returns the current record's "concerne_id" value
 * @method integer                        getClassementAutoriteId()     Returns the current record's "classement_autorite_id" value
 * @method integer                        getClassementHierarchieId()   Returns the current record's "classement_hierarchie_id" value
 * @method integer                        getClassementProposeId()      Returns the current record's "classement_propose_id" value
 * @method integer                        getClassementFinalId()        Returns the current record's "classement_final_id" value
 * @method Dossier_bpi                    getDossierBpi()               Returns the current record's "Dossier_bpi" value
 * @method Classement                     getClassementAutorite()       Returns the current record's "Classement_autorite" value
 * @method Classement                     getClassementHierarchie()     Returns the current record's "Classement_hierarchie" value
 * @method Classement                     getClassementPropose()        Returns the current record's "Classement_propose" value
 * @method Classement                     getClassementFinal()          Returns the current record's "Classement_final" value
 * @method Inventeur                      getConcerne()                 Returns the current record's "Concerne" value
 * @method Utilisateur                    getUtilisateurCreatedBy()     Returns the current record's "UtilisateurCreatedBy" value
 * @method Utilisateur                    getUtilisateurUpdatedBy()     Returns the current record's "UtilisateurUpdatedBy" value
 * @method Classement_invention_inventeur setDossierBpiId()             Sets the current record's "dossier_bpi_id" value
 * @method Classement_invention_inventeur setConcerneId()               Sets the current record's "concerne_id" value
 * @method Classement_invention_inventeur setClassementAutoriteId()     Sets the current record's "classement_autorite_id" value
 * @method Classement_invention_inventeur setClassementHierarchieId()   Sets the current record's "classement_hierarchie_id" value
 * @method Classement_invention_inventeur setClassementProposeId()      Sets the current record's "classement_propose_id" value
 * @method Classement_invention_inventeur setClassementFinalId()        Sets the current record's "classement_final_id" value
 * @method Classement_invention_inventeur setDossierBpi()               Sets the current record's "Dossier_bpi" value
 * @method Classement_invention_inventeur setClassementAutorite()       Sets the current record's "Classement_autorite" value
 * @method Classement_invention_inventeur setClassementHierarchie()     Sets the current record's "Classement_hierarchie" value
 * @method Classement_invention_inventeur setClassementPropose()        Sets the current record's "Classement_propose" value
 * @method Classement_invention_inventeur setClassementFinal()          Sets the current record's "Classement_final" value
 * @method Classement_invention_inventeur setConcerne()                 Sets the current record's "Concerne" value
 * @method Classement_invention_inventeur setUtilisateurCreatedBy()     Sets the current record's "UtilisateurCreatedBy" value
 * @method Classement_invention_inventeur setUtilisateurUpdatedBy()     Sets the current record's "UtilisateurUpdatedBy" value
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseClassement_invention_inventeur extends gridDoctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('classement_invention_inventeur');
        $this->hasColumn('dossier_bpi_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('concerne_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('classement_autorite_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('classement_hierarchie_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('classement_propose_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('classement_final_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Dossier_bpi', array(
             'local' => 'dossier_bpi_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Classement as Classement_autorite', array(
             'local' => 'classement_autorite_id',
             'foreign' => 'id'));

        $this->hasOne('Classement as Classement_hierarchie', array(
             'local' => 'classement_hierarchie_id',
             'foreign' => 'id'));

        $this->hasOne('Classement as Classement_propose', array(
             'local' => 'classement_propose_id',
             'foreign' => 'id'));

        $this->hasOne('Classement as Classement_final', array(
             'local' => 'classement_final_id',
             'foreign' => 'id'));

        $this->hasOne('Inventeur as Concerne', array(
             'local' => 'concerne_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Utilisateur as UtilisateurCreatedBy', array(
             'local' => 'created_by',
             'foreign' => 'id'));

        $this->hasOne('Utilisateur as UtilisateurUpdatedBy', array(
             'local' => 'updated_by',
             'foreign' => 'id'));

        $timestampable0 = new Doctrine_Template_Timestampable(array(
             ));
        $signable0 = new Doctrine_Template_Signable(array(
             ));
        $this->actAs($timestampable0);
        $this->actAs($signable0);
    }
}