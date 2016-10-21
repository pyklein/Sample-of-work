<?php

/**
 * Convention_dossier_these form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Convention_dossier_theseForm extends BaseConvention_dossier_theseForm {

  private $srvArbo;

  public function  __construct($object = null, $options = array(), $CSRFSecret = null) {
    $this->srvArbo = new ServiceArborescence();
    parent::__construct($object, $options, $CSRFSecret);
  }

  public function configure() {
    $this->useFields(array('numero_convention', 'type_convention_organisme_id', 'montant', 'date_signature', 'date_notification',
        'date_prise_effet', 'date_fin_effet', 'date_archivage', 'fichier'));

    //set Widget
    $type_dossier = 'Dossier_these';
    $this->widgetSchema['type_convention_organisme_id'] = new sfWidgetFormDoctrineChoiceParametered(array(
                'model' => $this->getRelatedModelName('TypeConventionOrganisme'),
                'add_empty' => libelle('msg_libelle_aucun'),
                'table_method' => array('method' => 'retrieveTypeConventionByTypeDossier', 'parameters' => array($type_dossier)),
            ));
    $this->widgetSchema['date_signature'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['date_notification'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['date_prise_effet'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['date_fin_effet'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['date_archivage'] = new sfWidgetFormInputJQueryDate();

    //lien de téléchargement
    if(strlen($this->getObject()->getFichier()) > 0){
      $strfichierLien =  url_for('referentiel_mris/telechargerFichierConvention?id='.$this->getObject()->getId().
              "&type_dossier=".$type_dossier, true);
    }else{
      $strfichierLien = "";
    }
    
    $this->widgetSchema['fichier'] = new sfWidgetFormInputFileEditableJQuery(array(
                'with_delete' => true,
                'label' => libelle("msg_libelle_fichier"),
                'delete_label' => libelle('msg_libelle_supprimer_fichier'),
                'file_src' => '',
                'is_image' => false,
                'extensions' => sfConfig::get("app_extensions_bureau"),
                'edit_mode' => !$this->isNew() && strlen($this->getObject()->getFichier()) > 0,
                'template' => '%input% <br>
                      %delete_label% : <a href="'. $strfichierLien .'">' . $this->getObject()->getFichierOrig() . '</a> %delete% <br>
                      '
            ));

    //configurations des libellés
    $this->configureLabelles();

    //configuration des validateurs
    $this->validatorSchema['date_signature'] = new gridValidatorDate(array('required' => false));
    $this->validatorSchema['date_notification'] = new gridValidatorDate(array('required' => false));
    $this->validatorSchema['date_prise_effet'] = new gridValidatorDate(array(), array('required' => libelle('msg_convention_valide_date_prise_effet_required')));
    $this->validatorSchema['date_fin_effet'] = new gridValidatorDate(array('required' => false));
    $this->validatorSchema['date_archivage'] = new gridValidatorDate(array('required' => false));

    $utilPhp = new ServiceFichier();
    $this->validatorSchema['fichier_delete'] = new sfValidatorBoolean();

    $this->validatorSchema['fichier'] = new gridValidatorFile(
            array('max_size' => $utilPhp->getMaxUploadSizeEnBytes(),
                  'fichier_bureau' => true,
                  'path' => $this->srvArbo->getRepertoireConventionDossierThese($this->getObject()->getDossierThese()->getNumeroAAfficher()),
                  'required' => false
                  ),
            array('max_size' => libelle("msg_libelle_taille_max_fichier", array($utilPhp->getMaxUploadSizeEnFormatHumain())))
    );

    $this->validatorSchema->setPostValidator(
            new sfValidatorCallback(array('callback' => array($this, 'checkDate')))
    );

    $this->disableLocalCSRFProtection();
    parent::configure();
  }

  private function configureLabelles() {
    $this->widgetSchema['numero_convention']->setLabel(libelle('msg_convention_libelle_numero'));
    $this->widgetSchema['type_convention_organisme_id']->setLabel(libelle('msg_convention_libelle_type'));
    $this->widgetSchema['montant']->setLabel(libelle('msg_libelle_montant'));
    $this->widgetSchema['date_signature']->setLabel(libelle('msg_convention_libelle_date_signature'));
    $this->widgetSchema['date_notification']->setLabel(libelle('msg_convention_libelle_date_notification'));
    $this->widgetSchema['date_prise_effet']->setLabel(libelle('msg_convention_libelle_date_prise_effet'));
    $this->widgetSchema['date_fin_effet']->setLabel(libelle('msg_convention_libelle_date_fin_effet'));
    $this->widgetSchema['date_archivage']->setLabel(libelle('msg_convention_libelle_date_archivage'));
    $this->widgetSchema['fichier']->setLabel(libelle('msg_libelle_fichier'));
  }


  public function save($con = null) {
    if ($this->values['fichier']) {
      $this->values['fichier_orig'] = $this->values['fichier']->getOriginalName();
    }

    parent::save($con);
  }

  /**
   * Permet de vérifier que la date fin effet est supérieure à la date début effet
   * @param object $validator
   * @param string[] $values
   * @return string[]
   * @author Alexandre WETTA
   */
  public function checkDate($validator, $values) {


    //Valider les dates prise-fin effet
    if (($values['date_fin_effet'] != "") && ($values['date_prise_effet'] != "")) {

      if (strtotime($values['date_fin_effet']) < strtotime($values['date_prise_effet'])) {
        $error = new sfValidatorError($validator, libelle('msg_convention_valide_dates_prise_fin_effet'));
        throw new sfValidatorErrorSchema($validator, array('date_prise_effet' => $error));
      }
    }

    return $values;
  }

}
