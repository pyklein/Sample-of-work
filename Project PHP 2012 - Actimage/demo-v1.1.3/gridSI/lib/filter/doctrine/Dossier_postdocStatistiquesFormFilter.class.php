<?php

/**
 * Filtres pour affichages des statistiques des dossiers de stage postdoctoraux
 *
 * @author Jihad SAHEBDIN
 */
class Dossier_postdocStatistiquesFormFilter extends BaseDossier_postdocFormFilter {

  public function configure()
  {
    $this->useFields(array('domaine_scientifique_id'));

    $this->setWidget('annee', new sfWidgetFormDoctrineChoice(
                    array('model' => 'Dossier_postdoc',
                        'table_method' => 'getAnneesDossiers',
                        'method' => 'getAnnee',
                        'add_empty' => libelle('msg_libelle_toutes'))));

    $this->setWidget('domaine_scientifique_id', new sfWidgetFormDoctrineChoiceParametered(
                    array('model' => 'Domaine_scientifique',
                          'add_empty'=>libelle('msg_libelle_toutes'),
                          'table_method' => array('method' => 'getDomaineScientifiqueAAfficher',
                                                  'parameters' => array('Dossier_postdoc'))
                          )));

    $this->setWidget('region_laboratoire', new sfWidgetFormDoctrineChoice(
                    array('model' => 'Region',
                        'order_by' => array('intitule', 'ASC'),
                        'add_empty' => libelle('msg_libelle_aucune'))));

    $this->widgetSchema->setPositions(array('annee','domaine_scientifique_id','region_laboratoire'));

    $this->validatorSchema['annee'] = new sfValidatorPass();
    $this->validatorSchema['region_laboratoire'] = new sfValidatorPass();

    $this->widgetSchema->setLabels(array(
        'annee' => libelle("msg_libelle_annee"),
        'region_laboratoire' => libelle("msg_libelle_region_laboratoire"),

         ));

    $this->widgetSchema->setNameFormat('stats_postdoc_filters[%s]');
    $this->disableCSRFProtection();

  }

  protected function addAnneeColumnQuery($query, $field, $value) {
    Dossier_postdocTable::getInstance()->appliquerFiltreAnnee($query, $value);
  }

  protected function addRegionLaboratoireColumnQuery($query, $field, $value){
    Dossier_postdocTable::getInstance()->appliquerFiltreRegionLaboratoire($query, $value);
  }

}
 

?>
