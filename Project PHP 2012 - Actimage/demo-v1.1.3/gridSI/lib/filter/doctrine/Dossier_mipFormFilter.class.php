<?php

/**
 * Dossier_mip filter form.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Dossier_mipFormFilter extends BaseDossier_mipFormFilter {

  private $boolRecherche;
  private $objRequeteDoctrine;

  function __construct($boolRecherche = false,$objRequeteDoctrine = null, $defaults = array(), $options = array(), $CSRFSecret = null) {
    $this->objRequeteDoctrine = $objRequeteDoctrine;
    $this->boolRecherche = $boolRecherche;
    $defaults = array_merge(array('statut_projet' => 1),$defaults);

    parent::__construct($defaults, $options, $CSRFSecret);
  }

  public function configure() {

    $arrFields = array('organisme_mindef_id', 'statut_dossier_mip_id', 'numero');

    // widgets de formulaire de recherche
    $arrRecherchePositions = array();
    $arrRechercheFields = array();
    if ($this->boolRecherche) {
      $arrRecherchePositions = array('titre', 'acronyme', 'descriptif', 'etou_titre', 'etou_descriptif', 'dossier_vivant');
      $arrRechercheFields = array('titre', 'acronyme', 'descriptif', 'dossier_vivant');

      $this->widgetSchema->setLabel('titre', libelle("msg_libelle_intitule"));
      $this->widgetSchema->setLabel('acronyme', libelle("msg_libelle_acronyme"));
      $this->widgetSchema->setLabel('descriptif', libelle("msg_libelle_descriptif"));
    }

    $this->useFields(array_merge($arrFields, $arrRechercheFields));

    if ($this->boolRecherche) {
      $this->widgetSchema['dossier_vivant'] = new sfWidgetFormInputCheckbox();
      
      $this->setWidget('titre', new sfWidgetFormFilterInput(array('with_empty' => false,
                  'template' => "%input%")));

      $this->setWidget('etou_titre', new gridWidgetFormEtOu());
      $this->setWidget('acronyme', new sfWidgetFormFilterInput(array('with_empty' => false)));

      $this->setWidget('descriptif', new sfWidgetFormFilterInput(array('with_empty' => false,
                  'template' => "%input%")));

      $this->setWidget('etou_descriptif', new gridWidgetFormEtOu());

      $this->validatorSchema['etou_titre'] = new sfValidatorPass();
      $this->validatorSchema['etou_descriptif'] = new sfValidatorPass();
      $this->validatorSchema['dossier_vivant'] = new sfValidatorBoolean();
      
    }

    $this->setWidget('organisme_mindef_id', new sfWidgetFormDoctrineChoice(
                    array('model' => 'Organisme_mindef',
                        'add_empty' => 'Tous',
                        'method' => 'getLabelFiltre',
                        'table_method' => 'retrieveOrganismesMindef')));

    //widgets
    $this->setWidget('annee', new sfWidgetFormChoice(
                    array('choices' => Dossier_mipTable::getInstance()->getAnneesDossiersByNumero())));

    $this->setWidget('nom_prenom_email', new sfWidgetFormFilterInput(array(
                'with_empty' => false)));

    $this->setWidget('statut_projet', new sfWidgetFormChoice(array(
                'choices' => array(
                    '0' => libelle('msg_libelle_tous'),
                    '1' => libelle('msg_libelle_dossier_mip'),
                    '2' => libelle('msg_libelle_pre_projet')                    
                )
            )));

    $this->widgetSchema['numero']->setOption('with_empty', false);


    $this->widgetSchema['statut_dossier_mip_id'] = new sfWidgetFormDoctrineChoiceParametered(array(
                'model' => 'Statut_dossier_mip',
                'add_empty' => libelle('msg_libelle_tous'),
                'table_method' => array('method' => 'retrieveStatutsParOrdre', 'parameters' => array(true))
            ));

    //validateurs
    $this->validatorSchema['annee'] = new sfValidatorPass();
    $this->validatorSchema['nom_prenom_email'] = new sfValidatorPass();
    $this->validatorSchema['statut_projet'] = new sfValidatorPass();
    
    $this->widgetSchema->setLabels(array(
        'annee' => libelle("msg_libelle_annee"),
        'nom_prenom_email' => libelle("msg_libelle_nom_prenom_email"),
        'organisme_mindef_id' => libelle("msg_libelle_organisme_armee"),
        'numero' => libelle("msg_libelle_numero"),
        'statut_dossier_mip_id' => libelle("msg_libelle_statut_dossier")));

    if ($this->objRequeteDoctrine != null ){
      $this->setQuery($this->objRequeteDoctrine);
    }

    $this->disableLocalCSRFProtection();
  }

  public function getFields() {
    $fields = parent::getFields();
    $fields['annee'] = 'Date';
    $fields['nom_prenom_email'] = 'Text';
    $fields['statut_projet'] = 'Choice';
    if ($this->boolRecherche) {
      $fields['etou_titre'] = 'Choice';
      $fields['etou_descriptif'] = 'Choice';
    }
    return $fields;
  }

  protected function addNomPrenomEmailColumnQuery($query, $field, $value) {
    if ($value['text'] != '') {
      Dossier_mipTable::getInstance()->appliquerFiltreNomPrenomEmail($query, $value['text']);
    }
  }

  protected function addStatutProjetColumnQuery($query, $field, $value) {
    if ($value == 1 || $value == 2) {
      Dossier_mipTable::getInstance()->appliquerFiltreStatutProjet($query, $value);
    }
  }

  protected function addAnneeColumnQuery($query, $field, $value) {
    Dossier_mipTable::getInstance()->appliquerFiltreAnneeByNumero($query, $value);
  }

  protected function addEtouTitreColumnQuery($query, $field, $value) {

  }

  protected function addTitreColumnQuery($query, $field, $value) {
    Dossier_mipTable::getInstance()->appliquerFiltreTitre($query, $value['text'], $this->getValue("etou_titre"));
  }

  protected function addEtouDescriptifColumnQuery($query, $field, $value) {

  }

  protected function addDescriptifColumnQuery($query, $field, $value) {
    Dossier_mipTable::getInstance()->appliquerFiltreDescriptif($query, $value['text'], $this->getValue("etou_descriptif"));
  }

}
