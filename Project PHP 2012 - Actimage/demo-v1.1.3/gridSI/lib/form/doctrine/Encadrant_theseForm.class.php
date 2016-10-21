<?php

/**
 * Encadrant_these form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Encadrant_theseForm extends BaseEncadrant_theseForm
{
  public function configure()
  {
    $this->useFields(array('role_these_id'));
    $this->widgetSchema['role_these_id']
            = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Role_these'),
                                               'add_empty' => false,
                                               'order_by' => array('intitule','ASC')));

    $this->widgetSchema['role_these_id']->setLabel(libelle('msg_dossier_mris_libelle_role'));
  }
}
