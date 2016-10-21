<?php

/**
 * Contrat form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ContratForm extends BaseContratForm {

  public function configure() {
    $this->useFields(array(
        'date_proposition',
        'date_signature',
        'date_inscription_mb',
        'date_redaction',
        'juriste_id',
        'statut_contrat_id',
        'type_contrats_list',
        'numero_mb',
        'dossier_bpi_id'
    ));

    $this->configureWidgets();

    $this->configureLibelles();

    $this->configureValidateurs();

    $this->disableCSRFProtection();

    parent::configure();
  }

  private function configureWidgets() {
    $this->widgetSchema['date_proposition'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['date_signature'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['date_inscription_mb'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['date_redaction'] = new sfWidgetFormInputJQueryDate();

    $this->widgetSchema['juriste_id']->setOption('query', UtilisateurTable::getInstance()->retrieveResponsableBpi());
    $this->widgetSchema['juriste_id']->setOption('add_empty', libelle('msg_libelle_aucun'));

    $this->widgetSchema['statut_contrat_id']->setOption('order_by', array('intitule', 'ASC'));
    $this->widgetSchema['statut_contrat_id']->setOption('add_empty', libelle('msg_libelle_aucun'));

    $this->widgetSchema['type_contrats_list']->setOption('expanded', true);
    $this->widgetSchema['type_contrats_list']->setOption('order_by', array('intitule', 'ASC'));
  }

  private function configureLibelles() {
    $this->widgetSchema['date_proposition']->setLabel(libelle('msg_contrat_libelle_date_proposition'));
    $this->widgetSchema['date_signature']->setLabel(libelle('msg_contrat_libelle_date_signature'));
    $this->widgetSchema['date_inscription_mb']->setLabel(libelle('msg_contrat_libelle_date_inscription_mb'));
    $this->widgetSchema['numero_mb']->setLabel(libelle('msg_contrat_libelle_numero_mb'));
    $this->widgetSchema['date_redaction']->setLabel(libelle('msg_contrat_libelle_date_redaction'));
    $this->widgetSchema['juriste_id']->setLabel(libelle('msg_contrat_libelle_juriste'));
    $this->widgetSchema['statut_contrat_id']->setLabel(libelle('msg_contrat_libelle_statut_contrat'));
    $this->widgetSchema['type_contrats_list']->setLabel(libelle('msg_contrat_libelle_type_contrats_list'));
  }

  private function configureValidateurs() {
    $this->validatorSchema['date_proposition'] = new gridValidatorDate(array('required' => false));
    $this->validatorSchema['date_signature'] = new gridValidatorDate(array('required' => false));
    $this->validatorSchema['date_inscription_mb'] = new gridValidatorDate(array('required' => false));
    $this->validatorSchema['date_redaction'] = new gridValidatorDate(array('required' => false));
    $this->validatorSchema['statut_contrat_id']->setMessage('required', libelle('msg_contrat_valid_statut_required'));
  }

  /**
   * Remet à 0 les erreurs sur le formulaire
   *
   * @author Simeon PETEV
   */
  public function resetErrorSchema() {
    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema, array());
  }

}
