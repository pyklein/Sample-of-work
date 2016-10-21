<?php

if (sfContext::hasInstance()) {
  sfContext::getInstance()->getConfiguration()->loadHelpers(array("Format", "Url", "Partial"));
} else {
  $configuration = ProjectConfiguration::getApplicationConfiguration('gridweb', 'prod', true);
  $context = sfContext::createInstance($configuration);
  $configuration->loadHelpers(array("Format", "Url", "Partial"));
}

/**
 * Formulaire pour la création d'un nouvel innovateur
 *
 * @author Alexandre WETTA
 */
class InnovateurForm extends BaseUtilisateurForm {

  public function configure() {

    $this->useFields(array('civilite_id', 'nom', 'prenom', 'email', 'email2', 'organisme_mindef_id', 'entite_id'));

    $this->widgetSchema['civilite_id'] = new sfWidgetFormDoctrineChoice(
                    array('model' => $this->getRelatedModelName('Civilite'),
                        'multiple' => false,
                        'expanded' => true
            ));

    $this->widgetSchema['organisme_mindef_id'] = new gridWidgetFormOrganismeMindef();
    $this->widgetSchema['entite_id'] = new gridWidgetFormEntite();

    // on configure les libellés
    $this->setLibelles();

    // on configure les validateurs
    $this->setValidateurs();

    $this->disableLocalCSRFProtection();

    parent::configure();
  }

  /**
   * Configuration des libellés
   *
   * @author Alexandre WETTA
   */
  private function setLibelles() {

    $this->widgetSchema->setLabels(array('civilite_id' => libelle('msg_utilisateur_libelle_civilite'),
        'nom' => libelle('msg_libelle_nom'),
        'prenom' => libelle('msg_utilisateur_libelle_prenom'),
        'email' => libelle('msg_utilisateur_libelle_email'),
        'email2' => libelle('msg_utilisateur_libelle_email_pro'),
        'organisme_mindef_id' => libelle('msg_utilisateur_libelle_orgmindef_affect'),
        'entite_id' => libelle('msg_utilisateur_libelle_entite_affect'),
    ));
  }

  /**
   * Configuration des validateurs
   *
   * @author Alexandre WETTA
   */
  private function setValidateurs() {

    $this->validatorSchema['civilite_id'] = new sfValidatorString(array('required' => 'true'), array('required' => libelle('msg_utilisateur_valid_civilite')));
    $this->validatorSchema['nom'] = new sfValidatorString(array('required' => 'true'), array('required' => libelle('msg_utilisateur_valid_nom')));
    $this->validatorSchema['prenom'] = new sfValidatorString(array('required' => 'true'), array('required' => libelle('msg_utilisateur_valid_prenom')));
    $this->validatorSchema['organisme_mindef_id'] = new sfValidatorDoctrineChoice(
                    array('model' => $this->getRelatedModelName('Organisme_mindef'), 'required' => true),
                    array('required' => libelle('msg_utilisateur_required_organisme'))
    );
    $this->validatorSchema['entite_id'] = new sfValidatorDoctrineChoice(
                    array('model' => $this->getRelatedModelName('Entite'), 'required' => true),
                    array('required' => libelle('msg_utilisateur_required_entite'))
    );

    $this->setValidator('email', new sfValidatorAnd(array(new sfValidatorEmail(), new sfValidatorDoctrineUnique(array('model' => 'Utilisateur', 'column' => 'email'))),
                    array('required' => true),
                    array('invalid' => libelle("msg_innovateur_valid_email_format"), 'required' => libelle('msg_innovateur_valid_email_required'))
    ));
    
    $this->setValidator('email2', new sfValidatorAnd(array(new sfValidatorEmail(), new sfValidatorDoctrineUnique(array('model' => 'Utilisateur', 'column' => 'email'))),
                    array('required' => false),
                    array('invalid' => libelle("msg_innovateur_valid_email_format"))
    ));

    $this->validatorSchema->setPostValidator(new sfValidatorCallback(array('callback' => array($this, 'checkEntite'))));
  }

  /**
   * Surcharge de la fonction save()
   *
   * @author Alexandre WETTA
   */
  public function save($con = null) {

    $strMotDePasseClaire = "";
    $boolEstNouveau = $this->isNew();

    //Detection de creation d'Utilisateur et de sauveguarde d'informations
    if (isset($this->defaults['mot_de_passe'])) {

      $objUtilMotDePasse = new UtilMotDePasse(sfConfig::get("app_mot_de_passe_longueur"), sfConfig::get("app_mot_de_passe_alphabet"));

      $strMotDePasseClaire = $objUtilMotDePasse->getMotDePasseAleatoire();

      $this->values['mot_de_passe'] = sha1($strMotDePasseClaire);
    }


    //on sauvegarde le nouvel utilisateur
    $objInnovateur = parent::save($con);

    //on crée et sauvegarde le profil de l'utilisateur 
    $objUtilisateur_profil = new Utilisateur_profil();
    $objUtilisateur_profil->setUtilisateurId($objInnovateur->getId());
    $objUtilisateur_profil->setProfilId(ProfilTable::CLI_MIP);
    $objUtilisateur_profil->save();

    //Detection de creation d'Utilisateur et envoie de mail
    if (!empty($strMotDePasseClaire) && ($boolEstNouveau)) {
      try {
        //Envoi d'un mail à l'utilisateur contenant le mot de passe en clair
        $gestionnaireMail = new GestionnaireMail();
        $strContenuMail = get_partial('email/contenuMailCreationCompteUtilisateur', array('utilisateur' => $this->getObject(), 'motdepasse' => $strMotDePasseClaire));
        $gestionnaireMail->envoyerMailNouvelUtilisateur($this->getObject(), $strContenuMail, sfContext::getInstance()->getUser()->getUtilisateur());
      } catch (Exception $ex) {
        sfContext::getInstance()->getUser()->setFlash("erreur", libelle('msg_utilisateur_creer_succes_erreur_mail', array($this->getObject()->getNom(), $ex->getMessage())));
      }
    }
  }

  /**
   * Vérifie que l'entité et l'organisme MINDEF sont compatibles
   * @param object $validator
   * @param string[] $values
   * @return string[]
   * @author Alexandre WETTA
   */
  public function checkEntite($validator, $values) {

    if ($values['organisme_mindef_id'] != '' && $values['entite_id'] != '') {
      $boolEstCompatibleAvecEntite = EntiteTable::getInstance()->estCompatibleEntiteAvecOrganismeMindef(
                      $values['entite_id'],
                      $values['organisme_mindef_id']
      );

      if(!$boolEstCompatibleAvecEntite){
        $error = new sfValidatorError($validator, libelle('msg_entite_err_incompatible_org_mindef'));
        throw new sfValidatorErrorSchema($validator, array('entite_id' => $error));
      }
    }

    return $values;
  }

}
?>
