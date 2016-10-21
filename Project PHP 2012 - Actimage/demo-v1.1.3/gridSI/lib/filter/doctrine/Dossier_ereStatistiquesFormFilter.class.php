<?php

/**
 * Filtres pour affichages des statistiques des dossiers de stage ERE
 *
 * @author Jihad SAHEBDIN
 */
class Dossier_ereStatistiquesFormFilter extends BaseDossier_ereFormFilter {

  public function configure()
  {
    $this->useFields(array('domaine_scientifique_id'));

    $this->setWidget('annee', new sfWidgetFormDoctrineChoice(
                    array('model' => 'Dossier_ere',
                        'table_method' => 'getAnneesDossiers',
                        'method' => 'getAnnee',
                        'add_empty' => libelle('msg_libelle_toutes'))));

    $this->setWidget('domaine_scientifique_id', new sfWidgetFormDoctrineChoiceParametered(
                    array('model' => 'Domaine_scientifique',
                          'add_empty'=>libelle('msg_libelle_toutes'),
                          'table_method' => array('method' => 'getDomaineScientifiqueAAfficher',
                                                  'parameters' => array('Dossier_ere'))
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

    $this->widgetSchema->setNameFormat('stats_ere_filters[%s]');
    $this->disableCSRFProtection();

  }

  protected function addAnneeColumnQuery($query, $field, $value) {
    Dossier_ereTable::getInstance()->appliquerFiltreAnnee($query, $value);
  }

  protected function addRegionLaboratoireColumnQuery($query, $field, $value){
    Dossier_ereTable::getInstance()->appliquerFiltreRegionLaboratoire($query, $value);
  }

}
 

?>
