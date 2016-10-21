<?php

if (sfContext::hasInstance()) {
  sfContext::getInstance()->getConfiguration()->loadHelpers(array("Format", "Url", "Partial"));
} else {
  $configuration = ProjectConfiguration::getApplicationConfiguration('gridweb', 'prod', true);
  $context = sfContext::createInstance($configuration);
  $configuration->loadHelpers(array("Format", "Url", "Partial"));
}

/**
 * Utilisateur form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class UtilisateurForm extends BaseUtilisateurForm {

  //Contient les valeurs d'un formulaire apres un submit
  private $arrValeursForm = array();

  //Liste des informations bloquées pour les utilisateurs LDAP
  private $arrBloqueLDAP = array();

  /**
   * Surcharge le constructeur par defaut pour introdur des validateur personnalisés
   *
   * @param <type> $object Voir BaseUtilisateurForm
   * @param <type> $options Voir BaseUtilisateurForm
   * @param <type> $CSRFSecret Voir BaseUtilisateurForm
   * @param <type> $objRequest - Le request qui a demander la forme et qui
   *                             contient les fields qui vont servir à personnaliser
   *                              les validateurs
   *
   * @author Simeon PETEV
   */
  public function __construct($object = null, $options = array(), $CSRFSecret = null, $objRequest=null) {
    //Recupere les champ LDAP par defaut
    $this->arrBloqueLDAP = UtilisateurTable::recupereCorrespondances();
    parent::__construct($object, $options, $CSRFSecret);

    if (($objRequest) && ($this->arrValeursForm = $objRequest->getParameter($this->getName()))) {
      $this->configurerValidateurs();
    }
    return $this;
  }

  /**
   * Surcharge le configure par defaut pour personnaliser
   *
   * @author Simeon PETEV
   */
  public function configure() {
    $this->useFields(array(
        'civilite_id',
        'nom',
        'nom_jeunefille',
        'prenom',
        'email',
        'email2',
        'email_perso',
        'date_naissance',
        'date_deces',
        'adresse_perso',
        'adresse_perso2',
        'adresse_perso3',
        'code_postal_perso',
        'complement_adresse_perso',
        'ville_perso_id',
        'telephone_fixe',
        'telephone_mobile',
        'telephone_autre',
        'fax',
        'telephone_fixe_perso',
        'telephone_mobile_perso',
        'photographie',
        'entite_id',
        'organisme_mindef_id',
        'grade_id',
        'statut_id',
        'domaines_scientifiques_list',
        'profils_list'
    ));



    $this->configureWidgets();

    $this->filtrerWidgetsLdap();

    $this->configurerLabelles();

    $this->configurerValidateurs();

    $this->disableCSRFProtection();




    parent::configure();
  }

  protected function filtrerWidgetsLdap(){
     //Filtrage des champs non disponible en édition pour les utilisateurs LDAP.
    $objUtilisateur = $this->getObject();
    if ($objUtilisateur && $objUtilisateur->getEstUtilisateurLdap()){
      foreach ($this->getWidgetSchema()->getFields() as $nom => $widget){
        if (isset($this->arrBloqueLDAP[$nom])){
          if ($nom == 'civilite_id'){
			if( $objUtilisateur->getCivilite()->getId() != null){
				$this->widgetSchema[$nom] = new sfWidgetFormReadOnly(array('content' => array('model' => 'Civilite')));
			} else {
				$this->widgetSchema[$nom] = new sfWidgetFormDoctrineChoice(array('model' => 'Civilite', 'add_empty' => false));
			}
          } elseif ($nom == 'ville_perso_id'){
			if( $objUtilisateur->getVillePersoId() != null){
				$this->widgetSchema[$nom] = new sfWidgetFormReadOnly(array('content' => array('model' => 'Ville')));
			} else {
				$this->widgetSchema[$nom] = new gridWidgetFormVille();
			}
          } elseif ($nom == 'entite_id'){
			if( $objUtilisateur->getEntiteId() != null){
				$this->widgetSchema[$nom] = new sfWidgetFormReadOnly(array('content' => array('model' => 'Entite')));
			} else {
				$this->widgetSchema[$nom] = new gridWidgetFormEntite(array('model' => 'Entite', 'add_empty' => true));
			}
          } elseif ($nom == 'organisme_mindef_id'){
			if( $objUtilisateur->getOrganismeMindefId() != null){
				$this->widgetSchema[$nom] = new sfWidgetFormReadOnly(array('content' => array('model' => 'Organisme_mindef')));
			} else {
				$this->widgetSchema[$nom] = new gridWidgetFormOrganismeMindef(array('model' => 'Organisme_mindef', 'add_empty' => true));
			}
          } elseif ($nom == 'grade_id'){
			if( $objUtilisateur->getGradeId() != null){
				$this->widgetSchema[$nom] = new sfWidgetFormReadOnly(array('content' => array('model' => 'Grade')));
			} else {
				$this->widgetSchema[$nom] = new gridWidgetFormGrade();
			}
		  } elseif ($nom == 'nom'){
			if( $objUtilisateur->getNom() != null){
				$this->widgetSchema[$nom] = new sfWidgetFormReadOnly();
			} else {
				$this->widgetSchema[$nom] = new sfWidgetFormInput();
			}
		  } elseif ($nom == 'prenom'){
			if( $objUtilisateur->getPrenom() != null){
				$this->widgetSchema[$nom] = new sfWidgetFormReadOnly();
			} else {
				$this->widgetSchema[$nom] = new sfWidgetFormInput();
			}
          } else {
            //$this->widgetSchema[$nom] = new sfWidgetFormReadOnly();
          }
        }
      }
    }
  }


  public function configureWidgets() {
    $this->widgetSchema['code_postal_perso'] = new gridWidgetFormCodePostal();
    $this->widgetSchema['email2'] = new sfWidgetFormInputEmail();
    $this->widgetSchema['email_perso'] = new sfWidgetFormInputEmail();
    $this->widgetSchema['telephone_fixe'] = new sfWidgetFormInputTelephone();
    $this->widgetSchema['telephone_mobile'] = new sfWidgetFormInputTelephone();
    $this->widgetSchema['telephone_autre'] = new sfWidgetFormInputTelephone();
    $this->widgetSchema['telephone_fixe_perso'] = new sfWidgetFormInputTelephone();
    $this->widgetSchema['telephone_mobile_perso'] = new sfWidgetFormInputTelephone();
    $this->widgetSchema['fax'] = new sfWidgetFormInputTelephone();
    $this->widgetSchema['date_naissance'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['date_deces'] = new sfWidgetFormInputJQueryDate();

    $this->widgetSchema['ville_perso_id'] = new gridWidgetFormVille(array('model' => $this->getRelatedModelName('Ville'), 'popup' => true));
    if (!$this->getObject()->isNew())
    {
      $this->widgetSchema['ville_perso_id']->setOption('query', VilleTable::getInstance()->buildQueryVilleActifsOrdreAscPourSelectBox($this->getObject()->getCodePostalPerso()));
    }
    $this->widgetSchema['code_postal_perso']->setWidgetFormVille('utilisateur_ville_perso_id');

    $this->widgetSchema['entite_id'] = new gridWidgetFormEntite(array('model' => $this->getRelatedModelName('Entite'), 'popup' => true));
    $this->widgetSchema['organisme_mindef_id'] = new gridWidgetFormOrganismeMindef(array('model' => $this->getRelatedModelName('Organisme_mindef'), 'popup' => true));
    $this->widgetSchema['grade_id'] = new gridWidgetFormGrade(array('popup' => true));
    $this->widgetSchema['statut_id']->setOption('add_empty', libelle('msg_libelle_aucun'));
    $this->widgetSchema['statut_id']->setOption('query', StatutTable::getInstance()->buildQueryStatutOrdreAscIntitule());

    if ($this->isNew()) {
      $this->widgetSchema['email'] = new sfWidgetFormReadOnly();
    } else {
      $this->widgetSchema['email'] = new sfWidgetFormInputEmail();
    }

    $objUtilArbo = new ServiceArborescence();

    $this->widgetSchema['photographie'] = new sfWidgetFormInputFileEditableJQuery(array(
                'label' => libelle("msg_utilisateur_libelle_photo"),
                'with_delete' => true,
                'delete_label' => libelle('msg_utilisateur_libelle_supp_fichier'),
                'file_src' => url_for("utilisateurs/chargerThumbnailUtilisateurs?path=" . bin2hex($objUtilArbo->getRepertoirePhotosUtilisateurs()). "&fichier=" . $this->getObject()->getPhotographie()),
                'is_image' => true,
                'extensions' => sfConfig::get("app_extensions_images"),
                'edit_mode' => !$this->isNew() && (strlen($this->getObject()->getPhotographie()) > 0),
                'template' => "%input% <br>
                      %delete_label% : %delete% <br>
                      <label></label>&nbsp;&nbsp;&nbsp;
                      <a id=\"img_photographie\" href=\"" . url_for("interface/telechargerPhoto?fichier=" . $this->getObject()->getPhotographie() . "&path=" . bin2hex($objUtilArbo->getRepertoirePhotosUtilisateurs())) . "\" target=\"_blank\">%file%</a>
                      ",
            ));

    $this->widgetSchema['domaines_scientifiques_list'] = new sfWidgetFormDoctrineChoice(
                    array('model' => $this->getRelatedModelName('DomainesScientifiques'),
                        'multiple' => true,
                        'expanded' => true,
                        'query' => Domaine_scientifiqueTable::getInstance()->buildQueryDomainesActifsOrdreAscPourSelectBox())
    );
  }

  /**
   * Personnalise les labelles de la forme
   *
   * @author Simeon PETEV
   */
  private function configurerLabelles() {
    $this->widgetSchema['civilite_id']->setLabel(libelle("msg_utilisateur_libelle_civilite"));
    $this->widgetSchema['nom']->setLabel(libelle("msg_libelle_nom"));
    $this->widgetSchema['nom_jeunefille']->setLabel(libelle("msg_utilisateur_libelle_nom_jeunefille"));
    $this->widgetSchema['prenom']->setLabel(libelle("msg_utilisateur_libelle_prenom"));
    $this->widgetSchema['email']->setLabel(libelle("msg_utilisateur_libelle_email"));
    $this->widgetSchema['email2']->setLabel(libelle("msg_utilisateur_libelle_email_pro"));
    $this->widgetSchema['email_perso']->setLabel(libelle("msg_utilisateur_libelle_email_perso"));
    $this->widgetSchema['date_naissance']->setLabel(libelle("msg_utilisateur_libelle_date_naissance"));
    $this->widgetSchema['date_deces']->setLabel(libelle("msg_utilisateur_libelle_date_deces"));
    $this->widgetSchema['adresse_perso']->setLabel(libelle("msg_utilisateur_libelle_addr_perso_voix"));
    $this->widgetSchema['adresse_perso2']->setLabel(libelle("msg_utilisateur_libelle_addr_perso_voix2"));
    $this->widgetSchema['adresse_perso3']->setLabel(libelle("msg_utilisateur_libelle_addr_perso_voix3"));
    $this->widgetSchema['code_postal_perso']->setLabel(libelle("msg_utilisateur_libelle_addr_perso_code_post"));
    $this->widgetSchema['complement_adresse_perso']->setLabel(libelle("msg_utilisateur_libelle_addr_perso_complem"));
    $this->widgetSchema['ville_perso_id']->setLabel(libelle("msg_utilisateur_libelle_addr_perso_ville"));
    $this->widgetSchema['telephone_fixe']->setLabel(libelle("msg_utilisateur_libelle_tel_fixe"));
    $this->widgetSchema['telephone_mobile']->setLabel(libelle("msg_utilisateur_libelle_tel_mobile"));
    $this->widgetSchema['telephone_autre']->setLabel(libelle("msg_utilisateur_libelle_tel_autre"));
    $this->widgetSchema['fax']->setLabel(libelle("msg_utilisateur_libelle_fax"));
    $this->widgetSchema['telephone_fixe_perso']->setLabel(libelle("msg_utilisateur_libelle_tel_perso_fixe"));
    $this->widgetSchema['telephone_mobile_perso']->setLabel(libelle("msg_utilisateur_libelle_tel_perso_mobile"));
    //$this->widgetSchema['photographie']                 ->setLabel(libelle("msg_utilisateur_libelle_photo"));
    $this->widgetSchema['entite_id']->setLabel(libelle("msg_utilisateur_libelle_entite_affect"));
    $this->widgetSchema['organisme_mindef_id']->setLabel(libelle("msg_utilisateur_libelle_orgmindef_affect"));
    $this->widgetSchema['grade_id']->setLabel(libelle("msg_utilisateur_libelle_grade"));
    $this->widgetSchema['statut_id']->setLabel(libelle("msg_utilisateur_libelle_statut"));
    $this->widgetSchema['domaines_scientifiques_list']->setLabel(libelle("msg_utilisateur_libelle_domaine_sci"));
  }

  /**
   * Personnalisation des validateurs
   *
   * @author Simeon PETEV
   */
  private function configurerValidateurs() {
    $utilPhp = new ServiceFichier();
    $objUtilArbo = new ServiceArborescence();
    
    $this->validatorSchema['photographie'] = new gridValidatorFile(
            array('max_size' => $utilPhp->getMaxUploadSizeEnBytes(),
                  'fichier_images' => true,
                  'path' => $objUtilArbo->getRepertoirePhotosUtilisateurs(),
                  'required' => false
                  ),
            array('max_size' => libelle("msg_libelle_taille_max_fichier", array($utilPhp->getMaxUploadSizeEnFormatHumain())))
    );


    $this->validatorSchema['photographie_delete'] = new sfValidatorBoolean();
    $this->validatorSchema['date_naissance'] = new gridValidatorDate(array('required' => false));
    $this->validatorSchema['date_deces'] = new gridValidatorDate(array('required' => false));
    $this->validatorSchema['telephone_fixe'] = new gridValidatorTelephone(array('required' => false), array('invalid' => libelle('msg_utilisateur_valid_tel')));
    $this->validatorSchema['telephone_mobile'] = new gridValidatorTelephone(array('required' => false), array('invalid' => libelle('msg_utilisateur_valid_tel')));
    $this->validatorSchema['telephone_autre'] = new gridValidatorTelephone(array('required' => false), array('invalid' => libelle('msg_utilisateur_valid_tel')));
    $this->validatorSchema['fax'] = new gridValidatorTelephone(array('required' => false), array('invalid' => libelle('msg_utilisateur_valid_fax')));
    $this->validatorSchema['telephone_fixe_perso'] = new gridValidatorTelephone(array('required' => false), array('invalid' => libelle('msg_utilisateur_valid_tel')));
    $this->validatorSchema['telephone_mobile_perso'] = new gridValidatorTelephone(array('required' => false), array('invalid' => libelle('msg_utilisateur_valid_tel')));
    $this->validatorSchema['email'] = new sfValidatorEmail(array('required' => true), array('invalid' => libelle("msg_form_error_champ_email_invalide"), 'required' => libelle('msg_utilisateur_valid_email_requis')));
    $this->validatorSchema['email2'] = new sfValidatorEmail(array('required' => false), array('invalid' => libelle("msg_form_error_champ_email_invalide")));
    $this->validatorSchema['email_perso'] = new sfValidatorEmail(array('required' => false), array('invalid' => libelle("msg_form_error_champ_email_invalide")));
    $this->validatorSchema['domaines_scientifiques_list'] = new sfValidatorDoctrineChoice(
                    array('model' => $this->getRelatedModelName('DomainesScientifiques'),
                        'multiple' => true,
                        'required' => false),
                    array('required' => libelle("msg_utilisateur_valid_domaine_sci"))
    );

    $this->validatorSchema['photographie']->setMessage('max_size', libelle('msg_utilisateur_valid_file_size'));
    $this->validatorSchema['photographie']->setMessage('mime_types', libelle('msg_utilisateur_valid_file_type'));
    $this->validatorSchema['nom']->setMessage('required', libelle("msg_utilisateur_valid_nom"));
    $this->validatorSchema['prenom']->setMessage('required', libelle("msg_utilisateur_valid_prenom"));

    $this->validatorSchema->setPostValidator(new sfValidatorCallback(array('callback' => array($this, 'validerDependences'))));
  }

  public function validerDependences($validator, $values) {
    $arrErreurs = array();

    //Valider e-mail
    if ((strcmp($this->getObject()->getEmail(), $values['email']) != 0) &&
            (UtilisateurTable::getInstance()->findOneByEmail($values['email']))) {
      $error = new sfValidatorError($validator, libelle('msg_utilisateur_valid_email_unique'));
      $this->putErreur($arrErreurs, 'email', $error);
    }

    //Valider les dates
    if (($values['date_deces'] != "") && ($values['date_naissance'] != "")) {
      if (strtotime($values['date_deces']) < strtotime($values['date_naissance'])) {
        $error = new sfValidatorError($validator, libelle('msg_utilisateur_valid_dates'));
        $this->putErreur($arrErreurs, 'date_naissance', $error);
        $this->putErreur($arrErreurs, 'date_deces', $error);
      }
    }

    $boolOrganMindefEstRenseigne = isset($values['organisme_mindef_id']);
    $boolEntiteEstRenseigne = isset($values['entite_id']);
    $boolGradeEstRenseigne = isset($values['grade_id']);

    // valider le grade
    if ($boolGradeEstRenseigne) {
      $boolEstCompatibleAvecMindef = true;
      $boolEstCompatibleAvecEntite = true;

      if ($boolOrganMindefEstRenseigne) {
        $boolEstCompatibleAvecMindef = GradeTable::getInstance()->estCompatibleGradeAvecOrganismeMindef(
                        $values['grade_id'],
                        $values['organisme_mindef_id']
        );
      }

      if ($boolEntiteEstRenseigne) {
        $boolEstCompatibleAvecEntite = EntiteTable::getInstance()->estCompatibleEntiteAvecGrade(
                        $values['entite_id'],
                        $values['grade_id']
        );
      }

      if (!$boolEstCompatibleAvecMindef) {
        if (!$boolEstCompatibleAvecEntite) {
          $error = new sfValidatorError($validator, libelle('msg_grade_err_incompatible_entite_org_mindef'));
          $this->putErreur($arrErreurs, 'grade_id', $error);
        } else {
          $error = new sfValidatorError($validator, libelle('msg_grade_err_incompatible_org_mindef'));
          $this->putErreur($arrErreurs, 'grade_id', $error);
        }
      } else if (!$boolEstCompatibleAvecEntite) {
        $error = new sfValidatorError($validator, libelle('msg_grade_err_incompatible_entite'));
        $this->putErreur($arrErreurs, 'grade_id', $error);
      }
    }

    //valider l'entite
    if ($boolEntiteEstRenseigne) {
      $boolEstCompatibleAvecMindef = true;
      $boolEstCompatibleAvecGrade = true;

      if ($boolOrganMindefEstRenseigne) {
        $boolEstCompatibleAvecMindef = EntiteTable::getInstance()->estCompatibleEntiteAvecOrganismeMindef(
                        $values['entite_id'],
                        $values['organisme_mindef_id']
        );
      }

      if ($boolGradeEstRenseigne) {
        $boolEstCompatibleAvecGrade = EntiteTable::getInstance()->estCompatibleEntiteAvecGrade(
                        $values['entite_id'],
                        $values['grade_id']
        );
      }

      if (!$boolEstCompatibleAvecMindef) {
        if (!$boolEstCompatibleAvecGrade) {
          $error = new sfValidatorError($validator, libelle('msg_entite_err_incompatible_grade_org_mindef'));
          $this->putErreur($arrErreurs, 'entite_id', $error);
        } else {
          $error = new sfValidatorError($validator, libelle('msg_entite_err_incompatible_org_mindef'));
          $this->putErreur($arrErreurs, 'entite_id', $error);
        }
      } else if (!$boolEstCompatibleAvecGrade) {
        $error = new sfValidatorError($validator, libelle('msg_entite_err_incompatible_grade'));
        $this->putErreur($arrErreurs, 'entite_id', $error);
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

  /**
   * Efface un thumbnail s'il existe
   *
   * @param string $field Nom de champ
   *
   * @author Simeon PETEV
   */
  protected function removeFile($field) {
    $utilArbo = new ServiceArborescence();
    $strNomImageThumb = nomImageThumbnail($utilArbo->getRepertoirePhotosUtilisateurs() . $this->getObject()->getPhotographie());
    if (strcmp($field, 'photographie_delete')) {
      $utilFichier = new UtilFichier();
      $utilFichier->supprimerFichier($strNomImageThumb);
    }

    parent::removeFile($field);

    //On efface le nom du fichier original
    $this->getObject()->setPhotographieOrig("");
  }

  /**
   * Surcharge la methode par defaut pour recuperer des données
   *
   * @param array $taintedValues Voir sfForm
   * @param array $taintedFiles Voir sfForm
   */
  public function bind(array $taintedValues = null, array $taintedFiles = null) {
    $secTaintedValues = $this->securiserTaintedValues($taintedValues);

    if (strlen($taintedValues["code_postal_perso"]) >= 2)
    {
      $this->widgetSchema['ville_perso_id']->setOption('query', VilleTable::getInstance()->buildQueryVilleActifsOrdreAscPourSelectBox($taintedValues["code_postal_perso"]));
    }

    parent::bind($secTaintedValues, $taintedFiles);
  }

  /**
   * Permet de securiser les valeurs submités en appliquant une logique de securité
   * liée à l'application courrant
   *
   * @param array $taintedValues Les valeurs réélement submités
   * @return array Les valeurs preNetoyer
   *
   * @author Simeon PETEV
   */
  private function securiserTaintedValues(array $taintedValues = null) {
    $taintedValuesFinaux = $taintedValues;

    //On securise les informations base sur les profils submités
    if (isset($taintedValues['profils_list'])) {
      $arrProfils = $taintedValues['profils_list'];

      //On efface les domaines scientifiques submitée si le profil MRIS n'est pas present
      if (($arrProfils != null) && (count($arrProfils) > 0)) {
        $intIdProfilCorMRIS = ProfilTable::getInstance()->getUnAvecCodeMetier('COR', 'MRIS')->getId();

        if (!in_array($intIdProfilCorMRIS, $arrProfils)) {
          $taintedValuesFinaux['domaines_scientifiques_list'] = array();
        }
      }
    } else { //si les profils ne sont pas submité 
      //On remet les profils deja existantes
      if (!$this->isNew()) {
        $taintedValuesFinaux['profils_list'] = $this->getObject()->getProfilsIds();
      }
    }


    return $taintedValuesFinaux;
  }

  /**
   * Surcharge la methode par defaut pour sauveguarder correctement des données
   *
   * @param <type> $con Voir sfFormObject
   * @return Voir sfFormObject
   *
   * @author Simeon PETEV
   */
  public function save($con = null) {
    $strMotDePasseClaire = "";
    $boolEstNouveau = $this->isNew();

    //Detection de creation d'Utilisateur et de sauveguarde d'informations
    if (isset($this->defaults['mot_de_passe']) && $boolEstNouveau) {

      $objUtilMotDePasse = new UtilMotDePasse(sfConfig::get("app_mot_de_passe_longueur"), sfConfig::get("app_mot_de_passe_alphabet"));

      $strMotDePasseClaire = $objUtilMotDePasse->getMotDePasseAleatoire();

      $this->values['mot_de_passe'] = sha1($strMotDePasseClaire);
    }

    //On sauvgarde le nom réel du photo
    if ($this->values['photographie']) {
      $this->values['photographie_orig'] = $this->values['photographie']->getOriginalName();
    }

    //On sauvgarde l'ancienne valeur de l'etité
    if (!$boolEstNouveau && ($this->values['entite_id'] != $this->getObject()->getEntiteId()))
    {
      $this->getObject()->setEntiteAncienne($this->getObject()->getEntite());
    }

    $objObjetRef = $this->getObject();

    $objObjetRef = parent::save($con);

    //Detection de creation d'Utilisateur et envoie de mail
    if (!empty($strMotDePasseClaire) && ($boolEstNouveau)) {
      try {
        //Envoi d'un mail à l'utilisateur contenant le mot de passe en clair
        $gestionnaireMail = new GestionnaireMail();
        $strContenuMail = get_partial('email/contenuMailCreationCompteUtilisateur', array('utilisateur' => $this->getObject(), 'motdepasse' => $strMotDePasseClaire));
        $gestionnaireMail->envoyerMailNouvelUtilisateur($this->getObject(), $strContenuMail, sfContext::getInstance()->getUser()->getUtilisateur());
      } catch (Exception $ex) {
        sfContext::getInstance()->getUser()->setFlash("erreur", libelle('msg_utilisateur_creer_succes_erreur_mail', array($this->getObject(), $ex->getMessage())));
        sfContext::getInstance()->getLogger()->debug("{" . __CLASS__ . "} [" . __FUNCTION__ . "] /Ligne: " . __LINE__ . "/ Message d'exception: " . $ex->getMessage());
      }
    }

    return $objObjetRef;
  }

}
