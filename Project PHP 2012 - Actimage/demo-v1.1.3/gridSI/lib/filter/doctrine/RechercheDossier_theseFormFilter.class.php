<?php

/**
 * Description of RechercheDossier_theseFormFilter
 *
 * @author Alexandre WETTA
 */
class RechercheDossier_theseFormFilter extends BaseDossier_theseFormFilter {

  public function configure() {

    $this->useFields(array('domaine_scientifique_id', 'organisme_mindef_id', 'organisme_id', 'titre'));

    $this->setWidget('annee', new sfWidgetFormDoctrineChoice(
                    array('model' => 'Dossier_these',
                        'table_method' => 'getAnneesDossiers',
                        'method' => 'getAnnee',
                        'add_empty' => libelle('msg_libelle_toutes'))));

    $this->setWidget('etudiant', new sfWidgetFormFilterInput(array(
                'with_empty' => false)));
    

    $this->setWidget('domaine_scientifique_id', new sfWidgetFormDoctrineChoice(
                    array('model' => $this->getRelatedModelName('Domaine_scientifique'),
                        'order_by' => array('intitule', 'ASC'),
                        'add_empty' => libelle('msg_libelle_aucun'))
    ));

    $this->setWidget('organisme_mindef_id', new gridWidgetFormOrganismeMindef());
    $this->setWidget('organisme_id', new gridWidgetFormOrganisme());

    $this->setWidget('laboratoire', new sfWidgetFormDoctrineChoice(
                    array('model' => 'Dossier_these_laboratoire',
                        'table_method' => 'getLaboratoiresDossier',
                        'method' => 'afficheLaboratoireComplet',
                        'key_method' => 'getLaboratoireId',
                        'add_empty' => libelle('msg_libelle_aucun'))));

     $this->setWidget('region_laboratoire', new sfWidgetFormDoctrineChoice(
                    array('model' => 'Region',
                        'order_by' => array('intitule', 'ASC'),
                        'add_empty' => libelle('msg_libelle_aucune'))));

     $this->setWidget('encadrant', new sfWidgetFormFilterInput(array(
                'with_empty' => false)));

     $this->setWidget('titre', new sfWidgetFormFilterInput(array('with_empty' => false,
                'template' => "%input%")));

    $this->setWidget('etou_titre', new gridWidgetFormEtOu());


    //position des éléments
    $this->widgetSchema->setPositions(array('annee', 'domaine_scientifique_id', 'organisme_mindef_id', 
        'organisme_id','laboratoire' ,'region_laboratoire', 'etudiant', 'encadrant', 'titre', 'etou_titre'));


    //validateurs
    $this->validatorSchema['annee'] = new sfValidatorPass();
    $this->validatorSchema['etudiant'] = new sfValidatorPass();
    $this->validatorSchema['laboratoire'] = new sfValidatorPass();
    $this->validatorSchema['region_laboratoire'] = new sfValidatorPass();
    $this->validatorSchema['encadrant'] = new sfValidatorPass();
    $this->validatorSchema['etou_titre'] = new sfValidatorPass();

    //labels
    $this->widgetSchema->setLabels(array(
        'annee' => libelle("msg_libelle_annee_debut_these"),
        'etudiant' => libelle("msg_libelle_etudiant_simple"),
        'domaine_scientifique_id' => libelle("msg_libelle_domaine_scientifique"),
        'organisme_mindef_id' => libelle("msg_libelle_organisme_mindef"),
        'organisme_id' => libelle("msg_libelle_organisme_exterieur"),
        'laboratoire' => libelle("msg_libelle_laboratoire_accueil"),
        'region_laboratoire' => libelle("msg_libelle_region_laboratoire"),
        'encadrant' => libelle("msg_libelle_encadrant"),
        'titre' => libelle("msg_libelle_titre"),
    ));

    $this->disableLocalCSRFProtection();
  }

  protected function addEtudiantColumnQuery($query, $field, $value) {
    if ($value['text'] != '') {
      Dossier_theseTable::getInstance()->appliquerFiltreEtudiant($query, $value['text']);
    }
  }

  protected function addAnneeColumnQuery($query, $field, $value) {
    Dossier_theseTable::getInstance()->appliquerFiltreAnnee($query, $value);
  }

  protected function addLaboratoireColumnQuery($query, $field, $value){
    Dossier_theseTable::getInstance()->appliquerFiltreLaboratoire($query, $value);
  }

  protected function addRegionLaboratoireColumnQuery($query, $field, $value){
    Dossier_theseTable::getInstance()->appliquerFiltreRegionLaboratoire($query, $value);
  }

   protected function addEncadrantColumnQuery($query, $field, $value) {
    if ($value['text'] != '') {
      Dossier_theseTable::getInstance()->appliquerFiltreEncadrant($query, $value['text']);
    }
  }

  protected function addEtouTitreColumnQuery($query, $fiel, $value) {}

  protected function addTitreColumnQuery($query, $fiel, $value) {
    Dossier_theseTable::getInstance()->appliquerFiltreTitre($query, $value['text'], $this->getValue("etou_titre"));
  }

}
?>