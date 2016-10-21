<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Dossier_mipStatistiquesFormFilter
 *
 * @author William
 */
class Dossier_mipStatistiquesFormFilter extends BaseDossier_mipFormFilter {

  public function configure() {
    $this->useFields(array('date_bascule', 'organisme_mindef_id', 'statut_dossier_mip_id', 'niveau_protection_id'));

    $this->setWidgets(array(
        'date_bascule' => new sfWidgetFormFilterDate(array(
            'from_date' => new sfWidgetFormInputJQueryDate(),
            'to_date' => new sfWidgetFormInputJQueryDate(),
            'with_empty' => false,
            'template' => "%from_date% <b>" . libelle("msg_remarque_et_le") . "</b> : %to_date%"
        )),
        'organisme_mindef_id' => new gridWidgetFormOrganismeMindef(array('add_empty' => libelle('msg_libelle_tous'))),
        'statut_dossier_mip_id' => new sfWidgetFormDoctrineChoiceParametered(array(
            'model' => $this->getRelatedModelName('Statut_dossier_mip'),
            'add_empty' => libelle("msg_libelle_tous"),
            'table_method' => array('method' => 'retrieveStatutsParOrdre', 'parameters' => array(true)))),
        'niveau_protection_id' => new sfWidgetFormDoctrineChoice(array(
            'model' => $this->getRelatedModelName('Niveau_protection'),
            'add_empty' => libelle("msg_libelle_tous"))),
    ));

    $this->setValidators(array(
        'date_bascule' => new sfValidatorDateRange(array(
            'from_date' => new gridValidatorDate(array('required' => false)),
            'to_date' => new gridValidatorDate(array('required' => false)),
            'required' => false
                ), array(
            'invalid' => libelle('msg_rapport_statistique_date_incoherente')
        )),
        'organisme_mindef_id' => $this->validatorSchema['organisme_mindef_id'],
        'statut_dossier_mip_id' => $this->validatorSchema['statut_dossier_mip_id'],
        'niveau_protection_id' => $this->validatorSchema['niveau_protection_id'],
    ));


    $this->widgetSchema->setLabels(array(
        'date_bascule' => libelle("msg_evenement_mip_libelle_date"),
        'organisme_mindef_id' => libelle("msg_libelle_organisme_armee"),
        'statut_dossier_mip_id' => libelle("msg_libelle_statut_dossier"),
        'niveau_protection_id' => libelle("msg_libelle_niveau_protection")
    ));

    $this->widgetSchema->setNameFormat('stats_mip_filters[%s]');
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

}

?>
