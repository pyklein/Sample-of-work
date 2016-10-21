<?php

/**
 * BaseSignataire
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $contrat_id
 * @property integer $organisme_id
 * @property integer $service_id
 * @property Contrat $Contrat
 * @property Organisme $Organisme
 * @property Service $Service
 * 
 * @method integer    getContratId()    Returns the current record's "contrat_id" value
 * @method integer    getOrganismeId()  Returns the current record's "organisme_id" value
 * @method integer    getServiceId()    Returns the current record's "service_id" value
 * @method Contrat    getContrat()      Returns the current record's "Contrat" value
 * @method Organisme  getOrganisme()    Returns the current record's "Organisme" value
 * @method Service    getService()      Returns the current record's "Service" value
 * @method Signataire setContratId()    Sets the current record's "contrat_id" value
 * @method Signataire setOrganismeId()  Sets the current record's "organisme_id" value
 * @method Signataire setServiceId()    Sets the current record's "service_id" value
 * @method Signataire setContrat()      Sets the current record's "Contrat" value
 * @method Signataire setOrganisme()    Sets the current record's "Organisme" value
 * @method Signataire setService()      Sets the current record's "Service" value
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseSignataire extends gridDoctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('signataire');
        $this->hasColumn('contrat_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('organisme_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('service_id', 'integer', null, array(
             'type' => 'integer',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Contrat', array(
             'local' => 'contrat_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Organisme', array(
             'local' => 'organisme_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Service', array(
             'local' => 'service_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}