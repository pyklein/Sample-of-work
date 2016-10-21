<?php

/**
 * Engagement form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class EngagementForm extends BaseEngagementForm
{
  public function configure()
  {
    $this->usefields(array(
        'type_engagement_id',
        'date_engagement',
        'montant',
        'reference',
        'entite_id',
        'dossier_mip_id'
    ));

    $this->configureWidgets();

    $this->configureLabelles();

    $this->configureValidators();

    $this->disableCSRFProtection();

    parent::configure();
  }

  private function configureWidgets()
  {
    $this->widgetSchema['type_engagement_id']   ->setOption('add_empty', libelle('msg_libelle_aucun'));
    $this->widgetSchema['date_engagement']      = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['entite_id']            = new gridWidgetFormEntite(array('query'=>  EntiteTable::getInstance()->getQueryEntitesExecutantTrieAscPourSelectBox()));
  }

  private function configureLabelles()
  {
    $this->widgetSchema['type_engagement_id'] ->setLabel(libelle('msg_libelle_type'));
    $this->widgetSchema['date_engagement']    ->setLabel(libelle('msg_libelle_date'));
    $this->widgetSchema['montant']            ->setLabel(libelle('msg_libelle_montant'));
    $this->widgetSchema['reference']          ->setLabel(libelle('msg_libelle_reference'));
    $this->widgetSchema['entite_id']          ->setLabel(libelle('msg_libelle_service_executant'));
  }

  private function configureValidators()
  {
    $this->validatorSchema['type_engagement_id']  ->setMessage('required', libelle('msg_dossier_mip_engagement_type_required'));
    $this->validatorSchema['date_engagement']     = new gridValidatorDate(array(),array('required'=>  libelle('msg_libelle_date_required')));
    $this->validatorSchema['montant']             = new gridValidatorFloat(array(),array('required' => libelle('msg_dossier_mip_engagement_montant_required'), 'invalid' => libelle('msg_dossier_mip_financement_montant_invalid')));
    $this->validatorSchema['entite_id']           ->setMessage('required', libelle('msg_dossier_mip_engagement_service_exec_required'));
  }
}
