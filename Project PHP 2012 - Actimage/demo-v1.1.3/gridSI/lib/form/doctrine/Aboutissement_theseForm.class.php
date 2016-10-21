<?php

/**
 * Aboutissement_these form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Aboutissement_theseForm extends BaseAboutissement_theseForm {

  public function configure() {
    $this->useFields(array(
        'est_preselectionne_prix',
        'est_selectionne_prix',
        'reception_exemplaire_these',
        'reception_rapport_soutenance',
        'reception_liste_publication',
        'reception_fiche_evaluation',
        'reception_synthese',
        'date_soutenance'
    ));

    $this->disableCSRFProtection();

    $this->configureWidgets();

    $this->configureLibelles();

    $this->configureValidateurs();

    parent::configure();
  }

  private function configureLibelles() {
    $this->widgetSchema['est_preselectionne_prix']->setLabel(libelle('msg_dossier_these_libelle_preselectionne'));
    $this->widgetSchema['est_selectionne_prix']->setLabel(libelle('msg_dossier_these_libelle_selectione'));
    $this->widgetSchema['reception_exemplaire_these']->setLabel(libelle('msg_dossier_these_libelle_date_exapl_these'));
    $this->widgetSchema['reception_rapport_soutenance']->setLabel(libelle('msg_dossier_these_libelle_date_rapp_souten'));
    $this->widgetSchema['reception_liste_publication']->setLabel(libelle('msg_dossier_these_libelle_date_list_pub'));
    $this->widgetSchema['reception_fiche_evaluation']->setLabel(libelle('msg_dossier_these_libelle_date_fich_eval'));
    $this->widgetSchema['reception_synthese']->setLabel(libelle('msg_dossier_these_libelle_date_fich_synt'));
    $this->widgetSchema['date_soutenance']->setLabel(libelle('msg_dossier_these_libelle_date_soutenance'));
  }

  private function configureWidgets() {
    $this->widgetSchema['reception_exemplaire_these'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['reception_rapport_soutenance'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['reception_liste_publication'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['reception_fiche_evaluation'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['reception_synthese'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['date_soutenance'] = new sfWidgetFormInputJQueryDate();
  }

  private function configureValidateurs() {
    $this->setValidator('reception_exemplaire_these', new gridValidatorDate(array('required' => false)));
    $this->setValidator('reception_rapport_soutenance', new gridValidatorDate(array('required' => false)));
    $this->setValidator('reception_liste_publication', new gridValidatorDate(array('required' => false)));
    $this->setValidator('reception_fiche_evaluation', new gridValidatorDate(array('required' => false)));
    $this->setValidator('reception_synthese', new gridValidatorDate(array('required' => false)));
    $this->setValidator('date_soutenance', new gridValidatorDate(array('required' => false)));
  }

}
