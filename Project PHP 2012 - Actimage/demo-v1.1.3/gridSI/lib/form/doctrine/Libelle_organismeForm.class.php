<?php

/**
 * Libelle_organisme form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Libelle_organismeForm extends BaseLibelle_organismeForm {

  public function configure() {
    $this->useFields(array('libelle_simple', 'libelle_liste'));

    //set widgets
    $this->widgetSchema['libelle_simple'] = new sfWidgetFormTextareaCKEditor();
    $this->widgetSchema['libelle_liste'] = new sfWidgetFormTextareaCKEditor();

    //set Validateurs
    $this->validatorSchema['libelle_simple'] = new gridValidatorTextarea();
    $this->validatorSchema['libelle_liste'] = new gridValidatorTextarea();

    //set labels
    $this->widgetSchema->setLabels(array(
        'libelle_simple' => libelle("msg_libelle_organisme_simple"),
        'libelle_liste' => libelle("msg_libelle_organisme_liste"),
    ));
  }

}
