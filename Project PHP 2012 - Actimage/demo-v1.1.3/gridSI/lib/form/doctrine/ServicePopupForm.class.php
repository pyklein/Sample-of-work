<?php

/**
 * Formulaire pour la popup pour l'ajou d'un service
 *
 * @author Alexandre WETTA
 */
class ServicePopupForm extends BaseServiceForm {

  public function configure() {

    $this->useFields(array('organisme_id', 'intitule', 'abreviation'));

    //widget
    $this->widgetSchema['organisme_id'] = new gridWidgetFormOrganisme();

    //validateurs
    $this->validatorSchema['intitule'] = new sfValidatorString(array('required' => 'true'),
                    array('required' => libelle('msg_referentiel_intitule_requis')));

    $this->validatorSchema->setPostValidator(new sfValidatorDoctrineUnique(array(
                'model' => 'service', 'column' => array('intitule', 'organisme_id'), 'throw_global_error' => true, 'primary_key' => 'id'),
                    array('invalid' => libelle('msg_service_unique'))));


    //labels
    $this->widgetSchema->setLabels(array(
        'intitule' => libelle('msg_referentiel_libelle_intitule'),
        'abreviation' => libelle('msg_referentiel_libelle_abreviation'),
        'organisme_id' => libelle('msg_referentiel_libelle_organisme')));


    $this->disableLocalCSRFProtection();
    parent::configure();
  }

}
?>
