<?php

sfContext::getInstance()->getConfiguration()->loadHelpers("Libelle");

/**
 * Formulaire de login de l'Utilisateur
 * @author Gabor JAGER
 */
class UtilisateurLoginForm extends BaseUtilisateurForm {

  /**
   * Configurer le formulaire de login
   * @author Gabor JAGER
   */
  public function configure() {
    $this->useFields(array('email', 'mot_de_passe'));

    $this->setWidgets(array(
        'email' => new sfWidgetFormInputEmail(),
        'mot_de_passe' => new sfWidgetFormInputPassword()
    ));

    $this->disableCSRFProtection();

    $this->validatorSchema['email'] = new sfValidatorEmail(array('max_length' => 255, 'required' => true),
                    array('required' => libelle('msg_form_error_champ_obligatoire'),
                        'invalid' => libelle('msg_form_error_champ_email_invalide')));
    $this->validatorSchema['mot_de_passe'] = new sfValidatorString(array('max_length' => 255, 'required' => true),
                    array('required' => libelle('msg_form_error_champ_obligatoire'),
                        'invalid' => libelle('msg_form_error_champ_invalide')));

    $this->widgetSchema['email']->setLabel(libelle("msg_utilisateur_libelle_email_connexion"));
    $this->widgetSchema['mot_de_passe']->setLabel(libelle("msg_utilisateur_libelle_mot_de_passe"));

    // validateur de mail / mot de passe
    $this->validatorSchema->setPostValidator(new sfValidatorCallback(array('callback' => array($this, 'checkLogin'))));

    $this->widgetSchema->setNameFormat('utilisateur_login[%s]');

    parent::configure();
  }

  /**
   * Permet de valider si le login et le mot de passe correcte
   * @param object $validator
   * @param string[] $values
   * @return string[]
   */
  public function checkLogin($validator, $values) {

    if ($values['email'] != "" && $values['mot_de_passe'] != "") {
      //Tentative de connection via LDAP
      $boolAuthLDAPReussie = false;
      $objUtilisateur = null;
      try {
        $srvLdap = new ServiceLdap();
        $boolAuthLDAPReussie = $srvLdap->authentifierUtilisateurLDAP($values['email'], $values['mot_de_passe']);
      } catch (Exception $e) {
        $objUtilisateur = UtilisateurTable::getInstance()->getUtilisateurParMailEtMotDePasse($values['email'], $values['mot_de_passe']);
      }
      if ($boolAuthLDAPReussie) {
        $objUtilisateur = UtilisateurTable::getInstance()->getUtilisateurParMail($values['email']);
        if ($objUtilisateur != null && $objUtilisateur->getId() > 0) {
		  $objUtilisateur->mettreAJourInformations($srvLdap->recupereInformations($values['email']));
		  $objUtilisateur->setEstUtilisateurLdap(true);
          $objUtilisateur->setMotDePasse(sha1($values['mot_de_passe']));
          $objUtilisateur->save();
        } else {
          throw new utilisateurLdapNonInscrisException();
        }
      }
      

      if (!$objUtilisateur) {
        $error = new sfValidatorError($validator, libelle('msg_libelle_erreur'));
        // throw an error bound to the val field
        throw new sfValidatorErrorSchema($validator, array('email' => $error));
      }
    }

    return $values;
  }

}
