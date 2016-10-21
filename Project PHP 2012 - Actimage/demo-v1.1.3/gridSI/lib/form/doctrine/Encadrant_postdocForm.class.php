<?php

/**
 * Encadrant_postdoc form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Encadrant_postdocForm extends BaseEncadrant_postdocForm {

  public function configure() {
    $this->useFields(array('role_postdoc_id'));
    $this->widgetSchema['role_postdoc_id']
            = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Role_postdoc'),
                'add_empty' => false,
                'order_by' => array('intitule', 'ASC')));

    $this->widgetSchema['role_postdoc_id']->setLabel(libelle('msg_dossier_mris_libelle_role'));
  }

}
