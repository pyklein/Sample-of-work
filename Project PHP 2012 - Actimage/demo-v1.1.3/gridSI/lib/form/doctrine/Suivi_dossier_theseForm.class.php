<?php

/**
 * Suivi_dossier_these form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Suivi_dossier_theseForm extends BaseSuivi_dossier_theseForm
{
  public function configure()
  {
    $this->useFields(array('type_suivi_these_id','descriptif','date_demande', 'date_reception'));

    $this->widgetSchema['type_suivi_these_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Type_suivi_these'), 'add_empty' => false));
    $this->widgetSchema['type_suivi_these_id']->setLabel(libelle("msg_libelle_type_suivi_these"));

    $this->widgetSchema['descriptif'] = new sfWidgetFormInputText();
    $this->widgetSchema['descriptif']->setLabel(libelle("msg_libelle_descriptif_these"));
    $this->validatorSchema['descriptif'] = new sfValidatorString(array('required' => true),array('required' => libelle("msg_suivi_champ_requis",array(libelle("msg_libelle_descriptif_these")))));

    $this->widgetSchema['date_demande'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['date_demande']->setLabel(libelle("msg_libelle_date_demande_these"));
    $this->validatorSchema['date_demande'] = new gridValidatorDate( array('required' => true),array('required' => libelle("msg_suivi_champ_requis",array(libelle("msg_libelle_date_demande_these")))));

    $this->widgetSchema['date_reception'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['date_reception']->setLabel(libelle("msg_libelle_date_reception_these"));
    $this->validatorSchema['date_reception'] = new gridValidatorDate( array('required' => false),array('required' => libelle("msg_suivi_champ_requis",array(libelle("msg_libelle_date_reception_these")))));


    $this->disableLocalCSRFProtection();
    parent::configure();
  }
}
