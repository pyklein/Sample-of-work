<?php

/**
 * Dossier_bpi filter form.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Actimage
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Dossier_bpiFormFilter extends BaseDossier_bpiFormFilter {

  public function configure() {

    $this->useFields(array('statut_dossier_bpi_id', 'est_clos', 'est_actif', 'autorite_decision_id', 'titre'));

    $this->setWidget('annee', new sfWidgetFormDoctrineChoice(
                    array('model' => 'Dossier_bpi',
                        'table_method' => 'getAnneesDossiers',
                        'method' => 'getAnnee',
                        'add_empty' => libelle('msg_libelle_toutes'))));

    $this->setWidget('autorite_decision_id', new sfWidgetFormDoctrineChoice(
                    array('model' => $this->getRelatedModelName('AutoriteDecision'),
                        'method' => 'getNomHierarchique',
                        'add_empty' => libelle('msg_libelle_toutes'))));

    $this->setWidget('statut_dossier_bpi_id', new sfWidgetFormDoctrineChoice(
                    array('model' => $this->getRelatedModelName('Statut_dossier_bpi'),
                        'add_empty' => libelle('msg_libelle_tous'))));

    $this->setWidget('nom_prenom_email', new sfWidgetFormFilterInput(array(
                'with_empty' => false)));

    $this->setWidget('est_clos', new sfWidgetFormChoice(array(
                'choices' => array('' => libelle('msg_libelle_tous'), 1 => libelle('msg_libelle_ferme'), 0 => libelle('msg_libelle_ouvert')),
        )));

    $this->setWidget('est_actif', new sfWidgetFormChoice(array(
                'choices' => array('' => libelle('msg_libelle_tous'), 1 => libelle('msg_libelle_actif'), 0 => libelle('msg_libelle_inactif')))));

    $this->setWidget('titre', new sfWidgetFormFilterInput(array('with_empty' => false,
                'template' => "%input%")));

    $this->setWidget('etou_titre', new gridWidgetFormEtOu());

    //validateurs
    $this->validatorSchema['annee'] = new sfValidatorPass();
    $this->validatorSchema['nom_prenom_email'] = new sfValidatorPass();
    $this->validatorSchema['etou_titre'] = new sfValidatorPass();


    //labels
    $this->widgetSchema->setLabels(array(
        'annee' => libelle("msg_libelle_annee"),
        'nom_prenom_email' => libelle("msg_libelle_nom_prenom_email"),
        'est_clos' => libelle("msg_libelle_dossier_bpi_etat_dossier"),
        'statut_dossier_bpi_id' => libelle("msg_libelle_dossier_bpi_statut_dossier"),
        'est_actif' => libelle("msg_libelle_dossier_bpi_statut_systeme"),
        'autorite_decision_id' => libelle("msg_libelle_dossier_bpi_autorite_decision")
    ));

    $this->disableLocalCSRFProtection();
  }

  public function getFields() {
    $fields = parent::getFields();
    $fields['etou_titre'] = 'Choice';
    $fields['annee'] = 'Date';
    $fields['nom_prenom_email'] = 'Text';

    return $fields;
  }

  protected function addNomPrenomEmailColumnQuery($query, $field, $value) {
    if ($value['text'] != '') {
      Dossier_bpiTable::getInstance()->appliquerFiltreNomPrenomEmail($query, $value['text']);
    }
  }

  protected function addAnneeColumnQuery($query, $field, $value) {
    Dossier_bpiTable::getInstance()->appliquerFiltreAnnee($query, $value);
  }

  protected function addEtouTitreColumnQuery($query, $fiel, $value) {}

  protected function addTitreColumnQuery($query, $fiel, $value) {
    Dossier_bpiTable::getInstance()->appliquerFiltreTitre($query, $value['text'], $this->getValue("etou_titre"));
  }

}
