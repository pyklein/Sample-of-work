<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Dossier_bpiStatistiquesFormFilter
 *
 * @author Julien GAUTIER
 */
class Dossier_bpiStatistiquesFormFilter extends BaseDossier_bpiFormFilter {

  public function configure() {
    $this->useFields(array('created_at'));

    $this->setWidgets(array(
        'created_at' => new sfWidgetFormFilterDate(array(
            'from_date' => new sfWidgetFormInputJQueryDate(),
            'to_date' => new sfWidgetFormInputJQueryDate(),
            'with_empty' => false,
            'template' => "%from_date% <b>" . libelle("msg_remarque_et_le") . "</b> : %to_date%"
        ))));

    $this->setWidget('organisme_mindef_id', new sfWidgetFormDoctrineChoice(
                    array('model' => 'Organisme_mindef',
                        'add_empty' => 'Tous',
                        'method' => 'getLabelFiltre',
                        'table_method' => 'retrieveOrganismesMindef')));
    $this->setWidget('entite_id', new gridWidgetFormEntite(array("model" => $this->getRelatedModelName('AutoriteDecision'), 'add_empty' => 'Tous')));

    $this->setValidators(array(
        'created_at' => new sfValidatorDateRange(array(
            'from_date' => new gridValidatorDate(array('required' => false)),
            'to_date' => new gridValidatorDate(array('required' => false)),
            'required' => false
                ), array(
            'invalid' => libelle('msg_rapport_statistique_date_incoherente')
        ))));

    $this->validatorSchema['organisme_mindef_id'] = new sfValidatorPass(array("required"=>false));
    $this->validatorSchema['entite_id'] = new sfValidatorPass(array("required"=>false));

    $this->widgetSchema->setLabels(array(
        'created_at' => libelle("msg_statistiques_bpi_libelle_date"),
        'organisme_mindef_id' => libelle("msg_libelle_organisme_armee"),
        'entite_id' => libelle("msg_statistiques_bpi_libelle_entite")
    ));

    $this->widgetSchema->setNameFormat('stats_bpi_filters[%s]');
    $this->setTableMethod('retrieveStatistiquesQuery');
    $this->disableCSRFProtection();
    parent::configure();
  }

  public function dobuildQuery(array $values) {
    //si filtre par date, ajout d'un jour à la date max (pour inclure date sup)
    if (array_key_exists('date', $values) && $values['date']['to'] != null) {
      $dateMax = $values['date'];
      $dateMax = new DateTime($dateMax['to']);
      $dateMax->modify('+1 day');
      $values['date']['to'] = $dateMax->format('Y-m-d');
    }
    $result = parent::doBuildQuery($values);
    return $result;
  }

  public function getFields() {
    $fields = parent::getFields();
    $fields['organisme_mindef_id'] = 'Choice';
    $fields['entite_id'] = 'Choice';
    return $fields;
  }

  protected function addOrganismeMindefIdColumnQuery($query, $field, $value) {
    if ($value != "") {
      Dossier_bpiTable::getInstance()->appliquerFiltreOrganismeMindef($query, $value);
    }
  }

  protected function addEntiteIdColumnQuery($query, $field, $value) {
    if ($value != "") {
      Dossier_bpiTable::getInstance()->appliquerFiltreEntite($query, $value);
    }
  }

}

?>
