<?php

/**
 * Description of EntitePopupForm
 *
 * @author Alexandre WETTA
 */
class EntitePopupForm extends BaseEntiteForm {

  public function configure() {

    $this->useFields(array('organisme_mindef_id', 'entite_id', 'intitule', 'abreviation'));

    $this->widgetSchema['entite_id'] = new sfWidgetFormDoctrineChoiceParametered(array(
                'model' => 'Entite',
                'add_empty' => libelle('msg_libelle_aucune'),
                'table_method' => array('method' => 'retrieveEntiteFiltre', 'parameters' => array(null)),
                'method' => 'getNomHierarchique',
                'order_by' => array('intitule', 'asc'),
            ));
    
    $this->widgetSchema['organisme_mindef_id'] = new sfWidgetFormDoctrineChoice(array(
                'model' => $this->getRelatedModelName('Organisme_mindef'),
                'table_method' => 'retrieveOrganismesMindefActif',
                'method' => 'getAbreviation',
                'order_by' => array('intitule', 'asc'),
            ));
    


    //libelle
    $this->widgetSchema->setLabels(array(
        'intitule' => libelle('msg_entite_libelle_intitule'),
        'abreviation' => libelle('msg_entite_libelle_abreviation'),
        'organisme_mindef_id' => libelle('msg_entite_libelle_organisme_mindef'),
        'entite_id' => libelle('msg_entite_libelle_entite'),
    ));

    $this->validatorSchema['abreviation']->setMessage('required', libelle('msg_form_error_champ_obligatoire'));
    $this->validatorSchema['abreviation']->setMessage('invalid', libelle('msg_form_error_champ_invalide'));

    $this->validatorSchema['intitule']->setMessage('required', libelle('msg_form_error_champ_obligatoire'));
    $this->validatorSchema['intitule']->setMessage('invalid', libelle('msg_form_error_champ_invalide'));


    $this->disableLocalCSRFProtection();

    parent::configure();
  }

}
?>
