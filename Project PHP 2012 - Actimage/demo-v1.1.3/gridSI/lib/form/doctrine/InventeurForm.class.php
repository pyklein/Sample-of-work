<?php

/**
 * Formulaire inventeur
 * @author Gabor JAGER
 */
class InventeurForm extends BaseInventeurForm
{
  private $arrPreFormulaire;
  private $boolLienPopup=true;
  /**
   * Constructeur
   * @param Inventeur $object
   * @param array $options
   * @param string $CSRFSecret
   * @param array $arrPreFormulaire valeurs de pré-formulaire
   * @author Gabor JAGER
   */
  public function __construct($boolLienPopup,$object = null, $options = array(), $CSRFSecret = null)
  {
    $this->arrPreFormulaire = array();

    if ($object->isNew())
    {
      $this->arrPreFormulaire["nom"] = $object->getNom();
      $this->arrPreFormulaire["est_exterieur"] = $object->getEstExterieur();
    }

    $this->boolLienPopup=$boolLienPopup;
    
    parent::__construct($object, $options, $CSRFSecret);
  }

  /**
   * Surcharge de fonction bind pour initialiser automatiquement les valeur de pré-formulaire
   * @param array $taintedValues
   * @param array $taintedFiles
   * @author Gabor JAGER
   */
  public function bind(array $taintedValues = null, array $taintedFiles = null)
  {
    foreach($this->arrPreFormulaire as $strCle => $strValeur)
    {
      $taintedValues[$strCle] = $strValeur;
    }
    if (strlen($taintedValues["code_postal_perso"]) >= 2)
    {
      $this->widgetSchema['ville_id']->setOption('query', VilleTable::getInstance()->buildQueryVilleActifsOrdreAscPourSelectBox($taintedValues["code_postal_perso"]));
    }
    
    parent::bind($taintedValues, $taintedFiles);
  }

  /**
   * Configurer le formulaire
   * @author Gabor JAGER
   */
  public function configure()
  {
    $this->useFields(array('civilite_id', 'nom', 'prenom',
                           'date_naissance', 'date_retraite',
                           'date_deces', 'email', 'email2', 'organisme_mindef_id',
                           'entite_id', 'grade_id', 'organisme_id',
                           'service_id', 'telephone_fixe',
                           'telephone_mobile', 'telephone_autre', 'fax',
                           'email_perso', 'adresse_perso', 'adresse_perso2', 'adresse_perso3',
                           'code_postal_perso', 'ville_id', 'complement_adresse_perso',
                           'telephone_fixe_perso', 'telephone_mobile_perso',
                           'est_exterieur'));

    // civilité
    $this->widgetSchema['civilite_id']->setLabel(libelle("msg_libelle_civilite"));
    $this->validatorSchema['civilite_id']->setMessage('required', libelle('msg_form_error_champ_obligatoire'));
    $this->validatorSchema['civilite_id']->setMessage('invalid', libelle('msg_form_error_champ_invalide'));

    // nom
    $this->widgetSchema['nom']->setAttribute('disabled', $this->isNew());
    $this->widgetSchema['nom']->setLabel(libelle("msg_libelle_nom"));
    $this->validatorSchema['nom']->setMessage('required', libelle('msg_form_error_champ_obligatoire'));
    $this->validatorSchema['nom']->setMessage('invalid', libelle('msg_form_error_champ_invalide'));

    // prénom
    $this->widgetSchema['prenom']->setLabel(libelle("msg_libelle_prenom"));
    $this->validatorSchema['prenom']->setMessage('invalid', libelle('msg_form_error_champ_invalide'));
    
    // date de naissance
    $this->widgetSchema['date_naissance'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['date_naissance']->setLabel(libelle("msg_libelle_date_naissance"));
    $this->validatorSchema['date_naissance'] = new gridValidatorDate(array('required'=>false),
                                                                     array('invalid'=> libelle('msg_form_error_champ_invalide')));

    // date de retraite
    $this->widgetSchema['date_retraite'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['date_retraite']->setLabel(libelle("msg_libelle_date_retraite"));
    $this->validatorSchema['date_retraite'] = new gridValidatorDate(array('required'=>false),
                                                                    array('invalid'=> libelle('msg_form_error_champ_invalide')));

    // date de retraite
    $this->widgetSchema['date_deces'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['date_deces']->setLabel(libelle("msg_libelle_date_deces"));
    $this->validatorSchema['date_deces'] = new gridValidatorDate(array('required'=>false),
                                                                 array('invalid'=> libelle('msg_form_error_champ_invalide')));

    // e-mail
    $this->widgetSchema['email'] = new sfWidgetFormInputEmail();
    $this->widgetSchema['email']->setLabel(libelle("msg_libelle_email"));
    $this->validatorSchema['email']->setMessage('invalid', libelle('msg_form_error_champ_email_invalide'));

    $this->widgetSchema['email2'] = new sfWidgetFormInputEmail();
    $this->widgetSchema['email2']->setLabel(libelle("msg_libelle_email2"));
    $this->validatorSchema['email2']->setMessage('invalid', libelle('msg_form_error_champ_email_invalide'));
    
    // téléphone fixe
    $this->widgetSchema['telephone_fixe'] = new sfWidgetFormInputTelephone();
    $this->widgetSchema['telephone_fixe']->setLabel(libelle("msg_libelle_telephone"));
    $this->validatorSchema['telephone_fixe'] = new gridValidatorTelephone(array('required'=>false),
                                                                          array('invalid'=> libelle('msg_form_error_champ_invalide')));

    // téléphone mobile
    $this->widgetSchema['telephone_mobile'] = new sfWidgetFormInputTelephone();
    $this->widgetSchema['telephone_mobile']->setLabel(libelle("msg_libelle_telephone_mobile"));
    $this->validatorSchema['telephone_mobile'] = new gridValidatorTelephone(array('required'=>false),
                                                                            array('invalid'=> libelle('msg_form_error_champ_invalide')));

    // téléphone autre
    $this->widgetSchema['telephone_autre'] = new sfWidgetFormInputTelephone();
    $this->widgetSchema['telephone_autre']->setLabel(libelle("msg_libelle_telephone_autre"));
    $this->validatorSchema['telephone_autre'] = new gridValidatorTelephone(array('required'=>false),
                                                                           array('invalid'=> libelle('msg_form_error_champ_invalide')));

    // fax
    $this->widgetSchema['fax'] = new sfWidgetFormInputTelephone();
    $this->widgetSchema['fax']->setLabel(libelle("msg_libelle_fax"));
    $this->validatorSchema['fax'] = new gridValidatorTelephone(array('required'=>false),
                                                                           array('invalid'=> libelle('msg_form_error_champ_invalide')));

    // e-mail perso
    $this->widgetSchema['email_perso'] = new sfWidgetFormInputEmail();
    $this->widgetSchema['email_perso']->setLabel(libelle("msg_libelle_email_perso"));
    $this->validatorSchema['email_perso']->setMessage('invalid', libelle('msg_form_error_champ_email_invalide'));

    // adresse perso
    $this->widgetSchema['adresse_perso']->setLabel(libelle("msg_libelle_adresse"));
    $this->validatorSchema['adresse_perso']->setMessage('invalid', libelle('msg_form_error_champ_invalide'));
    $this->widgetSchema['adresse_perso2']->setLabel(libelle("msg_libelle_adresse2"));
    $this->validatorSchema['adresse_perso2']->setMessage('invalid', libelle('msg_form_error_champ_invalide'));
    $this->widgetSchema['adresse_perso3']->setLabel(libelle("msg_libelle_adresse3"));
    $this->validatorSchema['adresse_perso3']->setMessage('invalid', libelle('msg_form_error_champ_invalide'));

    // code postal perso
    $this->widgetSchema['code_postal_perso'] = new gridWidgetFormCodePostal();
    $this->widgetSchema['code_postal_perso']->setLabel(libelle("msg_libelle_code_postal"));
    $this->validatorSchema['code_postal_perso'] = new gridValidatorCodePostal(array('required'=>false),
                                                                              array('invalid'=> libelle('msg_form_error_champ_invalide')));
    $this->widgetSchema['code_postal_perso']->setWidgetFormVille('inventeur_ville_id');

    // ville perso
    $this->widgetSchema['ville_id'] = new gridWidgetFormVille(array("model" => $this->getRelatedModelName('Ville'), 'popup'=>$this->boolLienPopup));
    $this->widgetSchema['ville_id']->setLabel(libelle("msg_libelle_ville"));
    $this->validatorSchema['ville_id']->setMessage('invalid', libelle('msg_form_error_champ_invalide'));
    if (!$this->getObject()->isNew())
    {
      $this->widgetSchema['ville_id']->setOption('query', VilleTable::getInstance()->buildQueryVilleActifsOrdreAscPourSelectBox($this->getObject()->getCodePostalPerso()));
    }

    // adresse perso
    $this->widgetSchema['complement_adresse_perso']->setLabel(libelle("msg_libelle_complement"));
    $this->validatorSchema['complement_adresse_perso']->setMessage('invalid', libelle('msg_form_error_champ_invalide'));

    // téléphone perso
    $this->widgetSchema['telephone_fixe_perso'] = new sfWidgetFormInputTelephone();
    $this->widgetSchema['telephone_fixe_perso']->setLabel(libelle("msg_libelle_telephone"));
    $this->validatorSchema['telephone_fixe_perso'] = new gridValidatorTelephone(array('required'=>false),
                                                                                array('invalid'=> libelle('msg_form_error_champ_invalide')));

    // téléphone perso mobile
    $this->widgetSchema['telephone_mobile_perso'] = new sfWidgetFormInputTelephone();
    $this->widgetSchema['telephone_mobile_perso']->setLabel(libelle("msg_libelle_telephone_mobile"));
    $this->validatorSchema['telephone_mobile_perso'] = new gridValidatorTelephone(array('required'=>false),
                                                                                  array('invalid'=> libelle('msg_form_error_champ_invalide')));

    // entité
    $this->widgetSchema['entite_id'] = new gridWidgetFormEntite(array("model" => $this->getRelatedModelName('Entite'), 'popup'=>$this->boolLienPopup));
    $this->widgetSchema['entite_id']->setLabel(libelle("msg_libelle_entite"));
    $this->validatorSchema['entite_id']->setMessage('invalid', libelle('msg_form_error_champ_invalide'));

    // organisme mindef
    $this->widgetSchema['organisme_mindef_id'] = new gridWidgetFormOrganismeMindef(array("model" => $this->getRelatedModelName('Organisme_mindef'), "popup" => $this->boolLienPopup));
    $this->widgetSchema['organisme_mindef_id']->setLabel(libelle("msg_libelle_org_mindef"));
    $this->validatorSchema['organisme_mindef_id']->setMessage('invalid', libelle('msg_form_error_champ_invalide'));

    // grade
    $this->widgetSchema['grade_id'] = new gridWidgetFormGrade(array('popup'=>  $this->boolLienPopup));
    $this->widgetSchema['grade_id']->setLabel(libelle("msg_libelle_grade"));
    $this->validatorSchema['grade_id']->setMessage('invalid', libelle('msg_form_error_champ_invalide'));

    // organisme
    $this->widgetSchema['organisme_id'] = new gridWidgetFormOrganisme(array("model" => $this->getRelatedModelName('Organisme'),'popup' => $this->boolLienPopup));
    $this->widgetSchema['organisme_id']->setLabel(libelle("msg_libelle_organisme"));
    $this->validatorSchema['organisme_id']->setMessage('invalid', libelle('msg_form_error_champ_invalide'));

    // service
    $this->widgetSchema['service_id'] = new gridWidgetFormService(array('popup' => $this->boolLienPopup));
    $this->widgetSchema['service_id']->setLabel(libelle("msg_libelle_service"));
    $this->validatorSchema['service_id']->setMessage('invalid', libelle('msg_form_error_champ_invalide'));

    // validateur de l'entité, l'organisme mindef, l'organisme, le grade et le service
    $this->validatorSchema->setPostValidator(new sfValidatorCallback(array('callback' => array($this, 'validerDependences'))));

    $this->disableLocalCSRFProtection();
    parent::configure();
  }

  /**
   * Permet de valider si les dependences entre les differents valeurs saisies
   * @param object $validator
   * @param string[] $values
   * @return string[]
   * @author Gabor JAGER
   */
  public function validerDependences($validator, $values)
  {
    $arrErreurs = array();

    // valider le grade
    if ($values['grade_id'] != "")
    {
      $objGrade = GradeTable::getInstance()->getGradeActifById($values['grade_id']);

      if ($objGrade == null)
      {
        $error = new sfValidatorError($validator, libelle('msg_form_error_champ_grade'));
        $this->putErreur($arrErreurs, 'grade_id', $error);
      }
      elseif ($objGrade->getOrganismeMindefId() != $values['organisme_mindef_id'])
      {
        $error = new sfValidatorError($validator, libelle('msg_form_error_champ_grade'));
        $this->putErreur($arrErreurs, 'grade_id', $error);
      }
    }

    // valider l'entité
    if ($values['entite_id'] != "")
    {
      $objEntite = EntiteTable::getInstance()->getEntiteActifById($values['entite_id']);

      if ($objEntite == null)
      {
        $error = new sfValidatorError($validator, libelle('msg_form_error_champ_entite'));
        $this->putErreur($arrErreurs, 'entite_id', $error);
      }
      elseif ($objEntite->getOrganismeMindefId() != $values['organisme_mindef_id'])
      {
        $error = new sfValidatorError($validator, libelle('msg_form_error_champ_entite'));
        $this->putErreur($arrErreurs, 'entite_id', $error);
      }
    }

    // valider le service
    if ($values['service_id'] != "")
    {
      $objService = ServiceTable::getInstance()->getServiceActifById($values['service_id']);

      if ($objService == null)
      {
        $error = new sfValidatorError($validator, libelle('msg_form_error_champ_service'));
        $this->putErreur($arrErreurs, 'service_id', $error);
      }
      elseif ($objService->getOrganismeId() != $values['organisme_id'])
      {
        $error = new sfValidatorError($validator, libelle('msg_form_error_champ_service'));
        $this->putErreur($arrErreurs, 'service_id', $error);
      }
    }

    // s'il y a des erreurs on balance l'exception
    if (count($arrErreurs) > 0)
    {
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
  private function putErreur(&$arrErreurs, $strChamp, $objErreur)
  {
    if (!isset($arrErreurs[$strChamp]))
    {
      $arrErreurs[$strChamp] = $objErreur;
    } 

    else if (!is_array($arrErreurs[$strChamp]))
    {
      $arrErreurs[$strChamp] = array($arrErreurs[$strChamp], $objErreur);
    }

    else
    {
      $arrErreurs[$strChamp] = array_push($arrErreurs[$strChamp], $objErreur);
    }
  }
}
