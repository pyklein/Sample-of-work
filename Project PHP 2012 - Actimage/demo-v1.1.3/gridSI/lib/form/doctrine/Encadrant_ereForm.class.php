<?php

/**
 * Encadrant_ere form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Encadrant_ereForm extends BaseEncadrant_ereForm
{
  public function configure()
  {
    $this->useFields(array('role_ere_id'));
    $this->widgetSchema['role_ere_id']
            = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Role_ere'),
                                               'add_empty' => false,
                                               'order_by' => array('intitule','ASC')));

    $this->widgetSchema['role_ere_id']->setLabel(libelle('msg_dossier_mris_libelle_role'));
  }
}
