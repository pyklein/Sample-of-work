<?php

if (sfContext::hasInstance()) {
  sfContext::getInstance()->getConfiguration()->loadHelpers(array("Format", "Url", "Partial"));
} else {
  $configuration = ProjectConfiguration::getApplicationConfiguration('gridweb', 'prod', true);
  $context = sfContext::createInstance($configuration);
  $configuration->loadHelpers(array("Format", "Url", "Partial"));
}

/**
 * Intervenant form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class IntervenantForm extends BaseIntervenantForm {

  public function configure() {
    $this->useFields(array(
        'civilite_id',
        'nom',
        'prenom',
        'titre',
        'est_participant_commission',
        'est_responsable',
        'email',
        'email2',
        'adresse',
        'adresse2',
        'adresse3',
        'code_postal',
        'complement_adresse',
        'ville_id',
        'telephone_fixe',
        'telephone_mobile',
        'fax',
        'organisme_id',
        'service_id',
        'laboratoire_id',
        'pays_id',
        'adresse_etrangere'
    ));

    //Changements des widgets par defaut qui n'arrivent pas remplir les fonctions
    $this->configureWidgets();

    //Personalisation des labelles
    $this->configureLabelles();

    //Personalisation des validateurs
    $this->configureValidators();

    $this->disableCSRFProtection();

    parent::configure();
  }

  private function configureWidgets() {
    $this->widgetSchema['email'] = new sfWidgetFormInputEmail();
    $this->widgetSchema['email2'] = new sfWidgetFormInputEmail();
    $this->widgetSchema['telephone_fixe'] = new sfWidgetFormInputTelephone();
    $this->widgetSchema['telephone_mobile'] = new sfWidgetFormInputTelephone();
    $this->widgetSchema['fax'] = new sfWidgetFormInputTelephone();

    $this->widgetSchema['code_postal'] = new gridWidgetFormCodePostal();
    $this->widgetSchema['code_postal']->setWidgetFormVille('intervenant_ville_id');

    $this->widgetSchema['organisme_id'] = new gridWidgetFormOrganisme(array('popup' => true));
    $this->widgetSchema['service_id'] = new gridWidgetFormService(array('popup' => true));
    $this->widgetSchema['laboratoire_id'] = new gridWidgetFormLaboratoire(array('popup' => true));
    
    $this->widgetSchema['ville_id'] = new gridWidgetFormVille(array('popup' => true));
    if (!$this->getObject()->isNew())
    {
      $this->widgetSchema['ville_id']->setOption('query', VilleTable::getInstance()->buildQueryVilleActifsOrdreAscPourSelectBox($this->getObject()->getCodePostal()));
    }

    $this->widgetSchema['pays_id']->setOption('query', PaysTable::getInstance()->buildQueryPaysOrdreAscNom());
    $this->widgetSchema['pays_id']->setOption('add_empty', libelle('msg_libelle_aucun'));
  }

  private function configureLabelles() {
    $this->widgetSchema['civilite_id']->setLabel(libelle('msg_intervenant_libelle_civilite'));
    $this->widgetSchema['nom']->setLabel(libelle('msg_libelle_nom'));
    $this->widgetSchema['prenom']->setLabel(libelle('msg_libelle_prenom'));
    $this->widgetSchema['titre']->setLabel(libelle('msg_libelle_titre'));
    $this->widgetSchema['est_participant_commission']->setLabel(libelle('msg_intervenant_libelle_participant_commission'));
    $this->widgetSchema['est_responsable']->setLabel(libelle('msg_intervenant_libelle_responsable'));
    $this->widgetSchema['email']->setLabel(libelle('msg_libelle_email'));
    $this->widgetSchema['email2']->setLabel(libelle('msg_libelle_email2'));
    $this->widgetSchema['adresse']->setLabel(libelle('msg_libelle_adresse'));
    $this->widgetSchema['adresse2']->setLabel(libelle('msg_libelle_adresse2'));
    $this->widgetSchema['adresse3']->setLabel(libelle('msg_libelle_adresse3'));
    $this->widgetSchema['code_postal']->setLabel(libelle('msg_libelle_code_postal'));
    $this->widgetSchema['complement_adresse']->setLabel(libelle('msg_libelle_complement_adresse'));
    $this->widgetSchema['ville_id']->setLabel(libelle('msg_libelle_ville'));
    $this->widgetSchema['telephone_fixe']->setLabel(libelle('msg_intervenant_libelle_tel_fixe'));
    $this->widgetSchema['telephone_mobile']->setLabel(libelle('msg_intervenant_libelle_tel_mobile'));
    $this->widgetSchema['fax']->setLabel(libelle('msg_intervenant_libelle_fax'));
    $this->widgetSchema['organisme_id']->setLabel(libelle('msg_libelle_organisme'));
    $this->widgetSchema['service_id']->setLabel(libelle('msg_intervenant_libelle_service'));
    $this->widgetSchema['laboratoire_id']->setLabel(libelle('msg_intervenant_libelle_laboratoire'));
    $this->widgetSchema['pays_id']->setLabel(libelle('msg_libelle_pays_etranger'));
    $this->widgetSchema['adresse_etrangere']->setLabel(libelle('msg_libelle_adresse_etrangere'));
  }

  public function configureValidators() {
    $this->getValidator('civilite_id')->setOption("required", true);
    $this->getValidator('civilite_id')->setMessage("required", libelle("msg_intervenant_valide_civilite"));

    $this->getValidator('nom')->setOption("required", true);
    $this->getValidator('nom')->setMessage("required", libelle("msg_intervenant_valide_nom"));

    $this->getValidator('prenom')->setOption("required", true);
    $this->getValidator('prenom')->setMessage("required", libelle("msg_intervenant_valide_prenom"));

    $this->setValidator('email', new sfValidatorEmail(array('required' => false), array("invalid" => libelle("msg_referentiel_email_invalide"))));
    $this->setValidator('email2', new sfValidatorEmail(array('required' => false), array("invalid" => libelle("msg_referentiel_email_invalide"))));
    $this->setValidator('telephone_fixe', new gridValidatorTelephone(array('required' => false), array('invalid' => libelle('msg_intervenant_valide_tel_fixe'))));
    $this->setValidator('telephone_mobile', new gridValidatorTelephone(array('required' => false), array('invalid' => libelle('msg_intervenant_valide_tel_mobile'))));
    $this->setValidator('fax', new gridValidatorTelephone(array('required' => false), array('invalid' => libelle('msg_intervenant_valide_fax'))));


    $this->validatorSchema->setPostValidator(new sfValidatorCallback(array('callback' => array($this, 'validerDependences'))));
  }

  public function validerDependences($validator, $values) {
    $arrErreurs = array();

    //Valider e-mail
    if ((strcmp($this->getObject()->getEmail(), $values['email']) != 0) &&
            (IntervenantTable::getInstance()->findOneByEmail($values['email']))) {
      $error = new sfValidatorError($validator, libelle('msg_utilisateur_valid_email_unique'));
      $this->putErreur($arrErreurs, 'email', $error);
    }

    //Valider le triplet laboratoire/service/organisme
    if ($values['laboratoire_id'] != "") {
      $objLaboratoire = LaboratoireTable::getInstance()->findOneById($values['laboratoire_id']);

      if ($values['service_id'] != "") {
        $objService = ServiceTable::getInstance()->findOneById($values['service_id']);

        if ($objLaboratoire->getServiceId() != $values['service_id']) {
          if ($objLaboratoire->getServiceId() == null || $objLaboratoire->getServiceId() == "") {
            $error = new sfValidatorError($validator, libelle('msg_referentiel_laboratoire_aucun_service_erreur', array($objLaboratoire->getIntitule())));
          } else {
            $error = new sfValidatorError($validator, libelle('msg_referentiel_laboratoire_appartenance_service_erreur', array($objLaboratoire->getIntitule(), $objLaboratoire->getService()->getIntitule())));
          }

          $this->putErreur($arrErreurs, 'service_id', $error);
        }

        if ($values['organisme_id'] != "") {
          if ($objLaboratoire->getOrganismeId() != $values['organisme_id']) {
            $error = null;
            if ($objLaboratoire->getOrganismeId() == null || $objLaboratoire->getOrganismeId() == "") {
              $error = new sfValidatorError($validator, libelle('msg_referentiel_laboratoire_aucun_organisme_erreur', array($objLaboratoire->getIntitule())));
            } else {
              $error = new sfValidatorError($validator, libelle('msg_referentiel_laboratoire_appartenance_organisme_erreur', array($objLaboratoire->getIntitule(), $objLaboratoire->getOrganisme()->getIntitule())));
            }

            $this->putErreur($arrErreurs, 'organisme_id', $error);
          }
        } else if ($objLaboratoire->getOrganismeId() != null && $objLaboratoire->getOrganismeId() != "") {
          $error = new sfValidatorError($validator, libelle('msg_intervenant_valid_laboratoire_require_organisme', array($objLaboratoire->getIntitule(), $objLaboratoire->getOrganisme()->getIntitule())));
          $this->putErreur($arrErreurs, 'organisme_id', $error);
        }
      } else if ($values['organisme_id'] != "") {
        if ($objLaboratoire->getServiceId() != null && $objLaboratoire->getServiceId() != "") {
          $error = new sfValidatorError($validator, libelle('msg_intervenant_valid_laboratoire_require_service', array($objLaboratoire->getIntitule(), $objLaboratoire->getService()->getIntitule())));
          $this->putErreur($arrErreurs, 'service_id', $error);
        }

        if ($objLaboratoire->getOrganismeId() != $values['organisme_id']) {
          if ($objLaboratoire->getOrganismeId() == null || $objLaboratoire->getOrganismeId() == "") {
            $error = new sfValidatorError($validator, libelle('msg_referentiel_laboratoire_aucun_organisme_erreur', array($objLaboratoire->getIntitule())));
          } else {
            $error = new sfValidatorError($validator, libelle('msg_referentiel_laboratoire_appartenance_organisme_erreur', array($objLaboratoire->getIntitule(), $objLaboratoire->getOrganisme()->getIntitule())));
          }

          $this->putErreur($arrErreurs, 'organisme_id', $error);
        }
      } else {
        if ($objLaboratoire->getOrganismeId() != null && $objLaboratoire->getOrganismeId() != "") {
          $error = new sfValidatorError($validator, libelle('msg_intervenant_valid_laboratoire_require_organisme', array($objLaboratoire->getIntitule(), $objLaboratoire->getOrganisme()->getIntitule())));
          $this->putErreur($arrErreurs, 'organisme_id', $error);
        }

        if ($objLaboratoire->getServiceId() != null && $objLaboratoire->getServiceId() != "") {
          $error = new sfValidatorError($validator, libelle('msg_intervenant_valid_laboratoire_require_service', array($objLaboratoire->getIntitule(), $objLaboratoire->getService()->getIntitule())));
          $this->putErreur($arrErreurs, 'service_id', $error);
        }
      }
    } else {
      if ($values['service_id'] != "") {
        $objService = ServiceTable::getInstance()->findOneById($values['service_id']);

        if ($values['organisme_id'] != "") {
          if ($objService->getOrganismeId() != $values['organisme_id']) {
            $error = new sfValidatorError($validator, libelle('msg_referentiel_laboratoire_service_erreur'));
            $this->putErreur($arrErreurs, 'service_id', $error);
          }
        } else if ($objService->getOrganismeId() != null && $objService->getOrganismeId() != "") {
          $error = new sfValidatorError($validator, libelle('msg_referentiel_laboratoire_service_require_organisme', array($objService->getIntitule(), $objService->getOrganisme()->getIntitule())));
          $this->putErreur($arrErreurs, 'organisme_id', $error);
        }
      }
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

  public function setCocheEtDisabledResposnable() {
    $this->widgetSchema['est_responsable']->setAttribute('disabled', 'true');
    $this->widgetSchema['est_responsable']->setAttribute('checked', 'true');
  }

  public function bind(array $taintedValues = null, array $taintedFiles = null)
  {
    if (strlen($taintedValues["code_postal"]) >= 2)
    {
      $this->widgetSchema['ville_id']->setOption('query', VilleTable::getInstance()->buildQueryVilleActifsOrdreAscPourSelectBox($taintedValues["code_postal"]));
    }

    parent::bind($taintedValues, $taintedFiles);
  }

}
