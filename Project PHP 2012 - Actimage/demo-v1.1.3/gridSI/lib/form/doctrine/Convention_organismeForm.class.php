<?php

/**
 * Convention_organisme form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Convention_organismeForm extends BaseConvention_organismeForm {

  public function configure() {
    $this->useFields(array(
        'type_convention_organisme_id',
        'organisme_id',
        'date_signature',
        'date_notification',
        'date_prise_effet',
        'date_fin_effet',
        'date_archivage',
        'fichier',
        'montant',
        'numero_convention'
    ));

    $this->configureWidgets();

    $this->configureLabelles();

    $this->configureValidators();

    $this->disableCSRFProtection();

    parent::configure();
  }

  private function configureWidgets() {
    $this->widgetSchema['type_convention_organisme_id']->setOption('query', Type_convention_organismeTable::getInstance()->buildQueryTypesOrdreAscIntitule());
    $this->widgetSchema['type_convention_organisme_id']->setOption('add_empty', libelle('msg_libelle_aucun'));
    $this->widgetSchema['organisme_id'] = new gridWidgetFormOrganisme();
    $this->widgetSchema['date_signature'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['date_notification'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['date_prise_effet'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['date_fin_effet'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['date_archivage'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['fichier'] = new sfWidgetFormInputFileEditableJQuery(array(
                'label' => libelle("msg_utilisateur_libelle_photo"),
                'with_delete' => true,
                'delete_label' => libelle('msg_libelle_supprimer_fichier'),
                'file_src' => url_for(""),
                'is_image' => false,
                'extensions' => sfConfig::get("app_extensions_bureau"),
                'edit_mode' => !$this->isNew() && (strlen($this->getObject()->getFichier()) > 0),
                'template' => "%input% <br>
                                            %delete_label% : %delete%
                                            ",
            ));
  }

  private function configureLabelles() {
    $this->widgetSchema['numero_convention']->setLabel(libelle('msg_convention_libelle_numero'));
    $this->widgetSchema['type_convention_organisme_id']->setLabel(libelle('msg_convention_libelle_type'));
    $this->widgetSchema['organisme_id']->setLabel(libelle('msg_libelle_signataire_organisme'));
    $this->widgetSchema['montant']->setLabel(libelle('msg_libelle_montant'));
    $this->widgetSchema['date_signature']->setLabel(libelle('msg_convention_libelle_date_signature'));
    $this->widgetSchema['date_notification']->setLabel(libelle('msg_convention_libelle_date_notification'));
    $this->widgetSchema['date_prise_effet']->setLabel(libelle('msg_convention_libelle_date_prise_effet'));
    $this->widgetSchema['date_fin_effet']->setLabel(libelle('msg_convention_libelle_date_fin_effet'));
    $this->widgetSchema['date_archivage']->setLabel(libelle('msg_convention_libelle_date_archivage'));
    $this->widgetSchema['fichier']->setLabel(libelle('msg_libelle_fichier'));
  }

  private function configureValidators() {
    $utilPhp = new ServiceFichier();
    $srvArbo = new ServiceArborescence();
    $this->validatorSchema['type_convention_organisme_id']->setMessage('required', libelle('msg_convention_valide_type_required'));
    $this->validatorSchema['organisme_id']->setMessage('required', libelle('msg_convention_valide_organisme_required'));
    $this->validatorSchema['montant']->setOption('min', 0);
    $this->validatorSchema['montant']->setMessage('min', libelle('msg_convention_valide_montant_minimal', array(0)));
    $this->validatorSchema['montant']->setMessage('required', libelle('msg_convention_valide_montant_required'));
    $this->validatorSchema['date_signature'] = new gridValidatorDate(array('required' => false));
    $this->validatorSchema['date_notification'] = new gridValidatorDate(array('required' => false));
    $this->validatorSchema['date_prise_effet'] = new gridValidatorDate(array(), array('required' => libelle('msg_convention_valide_date_prise_effet_required')));
    $this->validatorSchema['date_fin_effet'] = new gridValidatorDate(array('required' => false));
    $this->validatorSchema['date_archivage'] = new gridValidatorDate(array('required' => false));
    $this->validatorSchema['fichier'] = new gridValidatorFile(
            array('max_size' => $utilPhp->getMaxUploadSizeEnBytes(),
                  'fichier_bureau' => true,
                  'path' => $srvArbo->getRepertoireConventionsOrganismes(),
                  'required' => false
                  ),
            array('max_size' => libelle("msg_libelle_taille_max_fichier", array($utilPhp->getMaxUploadSizeEnFormatHumain())))
    );

    $this->validatorSchema['fichier']->setMessage('max_size', libelle('msg_libelle_taille_max_fichier', array($utilPhp->getMaxUploadSizeEnBytes())));
    $this->validatorSchema['fichier']->setMessage('mime_types', libelle('msg_libelle_type_incorect_fichier'));
    $this->validatorSchema['fichier_delete'] = new sfValidatorBoolean();

    $this->validatorSchema->setPostValidator(new sfValidatorCallback(array('callback' => array($this, 'validerDependences'))));
  }

  public function validerDependences($validator, $values) {
    $arrErreurs = array();
    $boolDateValides = true;

    //Valider les dates prise-fin effet
    if (($values['date_fin_effet'] != "") && ($values['date_prise_effet'] != "")) {
      if (strtotime($values['date_fin_effet']) <= strtotime($values['date_prise_effet'])) {
        $error = new sfValidatorError($validator, libelle('msg_convention_valide_dates_prise_fin_effet'));
        $this->putErreur($arrErreurs, 'date_prise_effet', $error);
        $this->putErreur($arrErreurs, 'date_fin_effet', $error);
        $boolDateValides = false;
      }
    }

    if ((Convention_organismeTable::getInstance()->estEnConflit($values['organisme_id'], $values['type_convention_organisme_id'], $values['date_prise_effet'], $values['date_fin_effet'], $this->getObject()->getId())) && $boolDateValides) {
      $error = new sfValidatorError($validator, libelle('msg_convention_valide_dates_prise_fin_effet_type_conv'));
      $this->putErreur($arrErreurs, 'date_prise_effet', $error);
      $this->putErreur($arrErreurs, 'date_fin_effet', $error);
    }

    // s'il y a des erreurs on balance l'exception
    if (count($arrErreurs) > 0) {
      throw new sfValidatorErrorSchema($validator, $arrErreurs);
    }

    return $values;
  }

  /**
   * Permet de rajouter un erreur aux erreur schema
   * @param array $arrErreurs tableauy des erreurs déjà detectés
   * @param string $strChamp nom du champ
   * @param sfValidatorError $objErreur
   * @author Gabor JAGER
   */
  private function putErreur(&$arrErreurs, $strChamp, $objErreur) {
    if (!isset($arrErreurs[$strChamp])) {
      $arrErreurs[$strChamp] = $objErreur;
    } else if (!is_array($arrErreurs[$strChamp])) {
      $arrErreurs[$strChamp] = array($arrErreurs[$strChamp], $objErreur);
    } else {
      $arrErreurs[$strChamp] = array_push($arrErreurs[$strChamp], $objErreur);
    }
  }

  public function removeFile($field) {
    parent::removeFile($field);

    //on efface le nom du fichier original
    $this->getObject()->setFichierOrig("");
  }

  public function save($con = null) {
    if ($this->values['fichier']) {
      $this->values['fichier_orig'] = $this->values['fichier']->getOriginalName();
    }

    parent::save($con);
  }

}
