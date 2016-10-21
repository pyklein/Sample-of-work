<?php

/**
 * Brevet form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BrevetForm extends BaseBrevetForm {

  public function __construct($dossierId, $object = null, $options = array(), $CSRFSecret = null) {

    $this->dossierId = $dossierId;
    $this->brevet = $object;

    parent::__construct($object, $options, $CSRFSecret);
  }

  public function configure() {

    $this->useFields(array('parent_id', 'numero_demande', 'numero_publication', 'titre', 'type_depot_id', 'phase_depot_brevet_id', 'pays_id',
        'responsable_id', 'date_decision_depot', 'date_objectif_depot', 'date_depot', 'date_rapport_recherche', 'date_obtention',
        'date_rejet', 'date_cession', 'contrat_id', 'date_reference', 'somme_frais'
    ));

    //fieldset Description du brevet
    $this->widgetSchema['parent_id'] = new sfWidgetFormDoctrineChoiceParametered(array(
                'model' => $this->getRelatedModelName('Parent'),
                'add_empty' => libelle('msg_libelle_aucun'),
                'table_method' => array('method' => 'retrieveBrevetsActifsByDossierBpi',
                'parameters' => array($this->dossierId, $this->brevet->getId())),
                'method' => 'getNumeroTitre'
            ));

    $this->widgetSchema['type_depot_id'] = new sfWidgetFormDoctrineChoice(array(
                'model' => $this->getRelatedModelName('Type_depot'),
                'method' => 'getIntituleComplet',
                'add_empty' => false,
                    )
    );

    $this->widgetSchema['phase_depot_brevet_id'] = new sfWidgetFormDoctrineChoice(array(
                'model' => $this->getRelatedModelName('Phase_depot_brevet'),
                'table_method' => 'retrevePhasesParcoursProfondeur',
                'method' => 'getIntituleDansArbre',
                'add_empty' =>false,
                    )
    );

    $this->widgetSchema['pays_id'] = new sfWidgetFormDoctrineChoice(array(
                'model' => $this->getRelatedModelName('Pays'),
                'method' => 'getNom',
                'order_by' => array('nom', 'ASC'),
                'add_empty' => libelle('msg_libelle_aucun'),
                    )
    );

    //fieldset Responsable
    $this->widgetSchema['responsable_id'] = new sfWidgetFormDoctrineChoice(array(
                'model' => $this->getRelatedModelName('Responsable'),
                'table_method' => 'retrieveResponsableBpi',
                'order_by' => array('nom', 'ASC'),
                'add_empty' => libelle('msg_libelle_aucun'),
                    )
    );

    //Fieldset Frais engagés
    $this->widgetSchema['date_reference'] = new sfWidgetFormInputJQueryDate();

    //Fieldset Repères temporels
    $this->widgetSchema['date_decision_depot'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['date_objectif_depot'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['date_rapport_recherche'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['date_cession'] = new sfWidgetFormInputJQueryDate();

    $this->widgetSchema['date_depot'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['date_obtention'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['date_rejet'] = new sfWidgetFormInputJQueryDate();

    $this->widgetSchema['contrat_id'] = new gridWidgetFormContrat(array(
                'table_method' => array('method' => 'retrieveQueryContratParDossierPourSelectbox', 'parameters' => array($this->dossierId)),
                    )
    );



    //validateurs
    $this->validatorSchema['date_decision_depot'] = new gridValidatorDate(array('required' => false));
    $this->validatorSchema['date_objectif_depot'] = new gridValidatorDate(array('required' => false));
    $this->validatorSchema['date_rapport_recherche'] = new gridValidatorDate(array('required' => false));
    $this->validatorSchema['date_cession'] = new gridValidatorDate(array('required' => false));
    $this->validatorSchema['date_reference'] = new gridValidatorDate(array('required' => false));
    $this->validatorSchema['somme_frais'] = new sfValidatorRegex(array('pattern' => '/^[0-9]+\.?[0-9]{0,2}$/', 'required'=>false), array('invalid'=> libelle('msg_libelle_somme_frais_invalid')));
    $this->validatorSchema['date_depot'] = new gridValidatorDate(array('required' => false));
    $this->validatorSchema['date_obtention'] = new gridValidatorDate(array('required' => false));
    $this->validatorSchema['date_rejet'] = new gridValidatorDate(array('required' => false));
    $this->validatorSchema['phase_depot_brevet_id'] = new sfValidatorDoctrineChoice(array(
            'model' => 'Phase_depot_brevet',
            'required' => true,
            'multiple' => false),
              array('required' => libelle('msg_brevet_phase_depot_requise')));
    $this->validatorSchema['responsable_id'] = new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Responsable')),
            array('required'=>libelle('msg_brevet_responsable_required'))
            );

    $this->validatorSchema->setPostValidator(new sfValidatorAnd(array(
                new sfValidatorCallback(array('callback' => array($this, 'checkBrevetExtension'))),
                new sfValidatorCallback(array('callback' => array($this, 'checkPaysExtension'))),
            )));


    //Labels
    $this->widgetSchema->setLabels(array(
        'parent_id' => libelle("msg_libelle_brevet_parent"),
        'numero_demande' => libelle("msg_libelle_numero_demande"),
        'numero_publication' => libelle("msg_libelle_numero_publication"),
        'titre' => libelle("msg_libelle_titre"),
        'type_depot_id' => libelle("msg_libelle_type_depot"),
        'phase_depot_brevet_id' => libelle("msg_libelle_phase_depot"),
        'pays_id' => libelle("msg_libelle_pays_extension"),
        'responsable_id' => libelle("msg_libelle_responsable"),
        'date_decision_depot' => libelle("msg_libelle_date_decision_depot"),
        'date_objectif_depot' => libelle("msg_libelle_date_objectif_depot"),
        'date_rapport_recherche' => libelle("msg_libelle_date_rapport_recherche"),
        'date_cession' => libelle("msg_libelle_date_cession"),
        'date_depot' => libelle("msg_libelle_date_depot"),
        'date_obtention' => libelle("msg_libelle_date_obtention"),
        'date_rejet' => libelle("msg_libelle_date_rejet"),
        'contrat_id' => libelle("msg_libelle_contrat"),
        'date_reference' => libelle("msg_libelle_date_reference"),
        'somme_frais' => libelle("msg_libelle_somme_frais_engages"),

    ));

    $this->validatorSchema->setOption('allow_extra_fields', true);

    $this->disableLocalCSRFProtection();
    parent::configure();
  }

  public function bind(array $taintedValues = null, array $taintedFiles = null) {

    if ($taintedValues["type_depot_id"] != Type_depotTable::EXTENSION) {
      $taintedValues["pays_id"] = null;
    }

    parent::bind($taintedValues, $taintedFiles);
  }

  public function  save($con = null) {

    if( $this->values['somme_frais'] == ""){
      $this->values['somme_frais'] = null ;
    }

    parent::save($con);
  }

  /**
   * Permet de vérifier qu'un brevet de type extension a un brevet parent
   * @param object $validator
   * @param string[] $values
   * @return string[]
   * @author Actimage
   */
  public function checkBrevetExtension($validator, $values) {

    if ($values['parent_id'] == "" && $values['type_depot_id'] == Type_depotTable::EXTENSION) {
      $error = new sfValidatorError($validator, libelle('msg_brevet_creer_type_extension_erreur'));
      // throw an error bound to the val field
      throw new sfValidatorErrorSchema($validator, array('parent_id' => $error));
    }

    return $values;
  }

  /**
   * Permet de vérifier qu'un brevet de type extension a un brevet parent
   * @param object $validator
   * @param string[] $values
   * @return string[]
   * @author Actimage
   */
  public function checkPaysExtension($validator, $values) {

    if ($values["type_depot_id"] == Type_depotTable::EXTENSION && $values["pays_id"] == null) {
      $error = new sfValidatorError($validator, libelle('msg_brevet_creer_pays_extension_erreur'));
      // throw an error bound to the val field
      throw new sfValidatorErrorSchema($validator, array('pays_id' => $error));
    }

    return $values;
  }

}
