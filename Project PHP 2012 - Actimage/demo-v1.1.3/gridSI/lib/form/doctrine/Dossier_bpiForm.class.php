<?php

/**
 * Dossier_bpi form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     William Richards
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Dossier_bpiForm extends BaseDossier_bpiForm
{
  public function configure()
  {
    $this->useFields(array(
        'numero',
        'titre',
        'description',
        'statut_declaration_id',
        'statut_dossier_bpi_id',
        'date_predeclaration',
        'date_declaration_conforme',
        'hierarchie_locale_id',
        'autorite_decision_id',
        'etat_partage_id',
        'est_classifie'
        ));
    $this->setWidgets(array(
        'numero' => new sfWidgetFormReadOnly(),
        'titre'  => $this->widgetSchema['titre'],
        'description' => new sfWidgetFormTextareaCKEditor(),
        'statut_declaration_id' => $this->widgetSchema['statut_declaration_id'],
        'statut_dossier_bpi_id' => new gridWidgetFormStatutDossierBpi(array("model" => $this->getRelatedModelName('Statut_dossier_bpi'), "popup" => true)),
        'date_predeclaration' => new sfWidgetFormInputJQueryDate(),
        'date_declaration_conforme' => new sfWidgetFormInputJQueryDate(),
        'hierarchie_locale_id' => new gridWidgetFormEntite(array("model" => $this->getRelatedModelName('HierarchieLocale'), "popup" => true)),
        'autorite_decision_id' => new gridWidgetFormEntite(array("model" => $this->getRelatedModelName('AutoriteDecision'), "popup" => true, "popupDeuxiemeFois" => true)),
        'etat_partage_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Etat_partage'), 'add_empty' => false)),
        'est_classifie'             => new sfWidgetFormInputCheckbox()
    ));

    $this->setValidators(array(
        'numero'                    => new sfValidatorString(array('max_length' => 255, 'required' => true),array('required'=> libelle('msg_dossier_bpi_numero_requis'))),
        'titre'                     => new sfValidatorString(array('max_length' => 255,'required' => true),array('required'=> libelle('msg_dossier_bpi_titre_requis'))),
        'description'               => new gridValidatorTextarea(array('required'=>false)),
        'statut_declaration_id'     => $this->validatorSchema['statut_declaration_id'],
        'statut_dossier_bpi_id'     => $this->validatorSchema['statut_dossier_bpi_id'],
        'date_predeclaration'       => new gridValidatorDate(array('required' => false)),
        'date_declaration_conforme' => new gridValidatorDate(array('required' => false)),
        'autorite_decision_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('AutoriteDecision'), 'required' => true)),
        'hierarchie_locale_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('HierarchieLocale'), 'required' => true)),
        'etat_partage_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Etat_partage'), 'required' => true)),
        'est_classifie'             => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->validatorSchema['titre']->setMessages(array('required' => libelle('msg_dossier_bpi_titre_requis')));
    $this->validatorSchema['statut_declaration_id']->setMessages(array('required' => libelle('msg_dossier_bpi_statut_declaration_id_requis')));
    $this->validatorSchema['statut_dossier_bpi_id']->setMessages(array('required' => libelle('msg_dossier_bpi_statut_dossier_bpi_id_requis')));
    $this->validatorSchema['hierarchie_locale_id']->setMessages(array('required' => libelle('msg_dossier_bpi_hierarchie_locale_id_requis')));
    $this->validatorSchema['autorite_decision_id']->setMessages(array('required' => libelle('msg_dossier_bpi_autorite_decision_id_requis')));
    $this->validatorSchema['date_predeclaration']->setMessages(array('required' => libelle('msg_dossier_bpi_date_predeclaration_requise')));

    $this->widgetSchema->setLabels(array(
        'numero' => libelle("msg_dossier_bpi_libelle_numero"),
        'titre' => libelle("msg_dossier_bpi_libelle_titre"),
        'description' => libelle("msg_dossier_bpi_libelle_description"),
        'statut_declaration_id' => libelle("msg_dossier_bpi_libelle_statut_declaration"),
        'statut_dossier_bpi_id' => libelle("msg_dossier_bpi_libelle_statut_dossier_bpi"),
        'date_predeclaration' => libelle("msg_dossier_bpi_libelle_date_predeclaration"),
        'date_declaration_conforme' => libelle("msg_dossier_bpi_libelle_date_declaration_conforme"),
        'hierarchie_locale_id' => libelle("msg_dossier_bpi_libelle_hierarchie_locale"),
        'autorite_decision_id' => libelle("msg_dossier_bpi_libelle_autorite_decision"),
        'etat_partage_id' => libelle("msg_libelle_etat_partage"),
        'est_classifie' => libelle("msg_libelle_classification")
    ));

    if ($this->isNew()){
      $this->getObject()->setNumero(Dossier_bpiTable::getInstance()->getIncrement());
    }

    $this->validatorSchema->setPostValidator(
      new sfValidatorCallback(array('callback' => array($this,'validationDates'))
      ));

    $this->widgetSchema->setNameFormat('dossier_bpi_form[%s]');
    $this->disableLocalCSRFProtection();
    parent::configure();
  }

  public function validationDates($validator,$values){
    if (isset($values['date_declaration_conforme']) && ($values['date_declaration_conforme'] < $values['date_predeclaration'])){
      $error = new sfValidatorError($validator, libelle('msg_dossier_bpi_dates_invalides'));
      throw new sfValidatorErrorSchema($validator, array('date_declaration_conforme' => $error));
    }
    return $values;
  }
}
