<?php

/**
 * Avis_mris_date form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Avis_mris_dateForm extends BaseAvis_mrisForm
{
  public function configure()
  {
    $this->useFields(array('date_envoi_lettre'));

    $this->widgetSchema['date_envoi_lettre'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['date_envoi_lettre']->setLabel(libelle("msg_libelle_avis_mris_date_envoi_lettre"));
    $this->validatorSchema['date_envoi_lettre'] =  new gridValidatorDate(array('required' => false));

    parent::configure();
  }
}
