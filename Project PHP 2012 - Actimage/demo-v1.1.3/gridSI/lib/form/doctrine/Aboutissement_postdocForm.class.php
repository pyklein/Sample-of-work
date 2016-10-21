<?php

/**
 * Aboutissement_postdoc form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Aboutissement_postdocForm extends BaseAboutissement_postdocForm
{
  public function configure()
  {
      $this->useFields(array(
         'reception_rapport_final',
         'reception_fiche_evaluation',
         'reception_synthese'
     ));

     $this->disableCSRFProtection();
     
     $this->configureWidgets();

     $this->configureLibelles();

     $this->configureValidateurs();

     parent::configure();
  }

  private function configureLibelles()
  {
    $this->widgetSchema['reception_rapport_final']      ->setLabel(libelle('msg_dossier_postdoc_libelle_date_rapp_fin'));
    $this->widgetSchema['reception_fiche_evaluation']   ->setLabel(libelle('msg_dossier_postdoc_libelle_date_fich_eval'));
    $this->widgetSchema['reception_synthese']           ->setLabel(libelle('msg_dossier_postdoc_libelle_date_fich_synt'));
  }

  private function configureWidgets()
  {
    $this->widgetSchema['reception_rapport_final']       = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['reception_fiche_evaluation']    = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['reception_synthese']            = new sfWidgetFormInputJQueryDate();
  }

  private function configureValidateurs()
  {
    $this->setValidator('reception_rapport_final',new gridValidatorDate(array('required'=>false)));
    $this->setValidator('reception_fiche_evaluation',new gridValidatorDate(array('required'=>false)));
    $this->setValidator('reception_synthese',new gridValidatorDate(array('required'=>false)));
  }
}
