<?php

/**
 * Remarque_mris form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Remarque_mrisForm extends BaseRemarque_mrisForm
{
  public function configure()
  {
    $this->useFields(array('contenu'));

    $this->widgetSchema['contenu'] = new sfWidgetFormTextareaCKEditor();
    $this->widgetSchema['contenu']->setLabel(libelle("msg_libelle_contenu"));
    $this->setValidator('contenu',new gridValidatorTextarea(array('required' => true),array('required'=> libelle("msg_remarque_champ_requis",array(libelle("msg_libelle_contenu"))))));
    parent::configure();
  }
}
