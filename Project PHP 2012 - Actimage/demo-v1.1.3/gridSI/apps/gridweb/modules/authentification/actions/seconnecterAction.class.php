<?php

/**
 * Action d'authentification
 * @author Gabor JAGER
 */
class seconnecterAction extends sfAction {

  /**
   * @var sfLogger
   */
  var $logger;

  public function preExecute() {
    $this->logger = sfContext::getInstance()->getLogger();
  }

  public function execute($request) {
    // formulaire
    $this->objForm = new UtilisateurLoginForm();
    $boolValide = false;
    // submit formulaire
    if ($request->isMethod('post')) {

      try {
        $this->objForm->bind($request->getParameter($this->objForm->getName()));
         
        $boolValide = $this->objForm->isValid();
      } catch (utilisateurLdapNonInscrisException $ex) {
        //utilisateur Ldap non trouvé sur grid
        $this->getUser()->setFlash("warning", libelle("msg_authentification_ldap_inconnu"));
      }
      // valeurs de formulaire
      $arrValeurs = $this->objForm->getTaintedValues();

      // login reussi
      if ($boolValide) {

        $this->logger->debug("{" . __CLASS__ . "} " . __FUNCTION__ . " - login correct - mail: " . $arrValeurs['email']);

        //        $objUtilisateur = UtilisateurTable::getInstance()->getUtilisateurParMailEtMotDePasse($arrValeurs['email'], $arrValeurs['mot_de_passe']);
        $objUtilisateur = UtilisateurTable::getInstance()->findOneByEmail($arrValeurs['email']);

        // on a bien l'utilisateur, on authentifie
        $this->getUser()->setAuthenticated(true);

        // Sauvegarde de l'objet dans la classe myUser
        // Met à jour les droits le component
        $this->getUser()->setUtilisateur($objUtilisateur);

        // ajout de la connexion au compteur de la supervision
        ConnexionTable::getInstance()->addToCompteur();

        $this->redirect("@accueil");
      }

      // erreur de login
      else {
        $this->logger->err("{" . __CLASS__ . "} " . __FUNCTION__ . " - login erreur - mail: " . $arrValeurs['email']);
        $this->getUser()->setFlash("erreur", libelle("msg_login_erreur"));

        $objUsrABloquer = UtilisateurTable::getInstance()->findOneByEmail($arrValeurs['email']);

        //Connection infructueuse
        //$objEchecAuth = Echec_authentificationTable::getInstance()->findOneByIdentidiantConnection($arrValeurs['email']);

        if ($objUsrABloquer)
        {
          $objEchecAuth = $objUsrABloquer->getEchecAuthentification();

          $intNbrEchecsAutorise = sfConfig::get("app_echec_authentification_nombre_tentatives");
          $intEspaceTempsMinutes = sfConfig::get("app_echec_authentification_espace_temps");

          if (!$objEchecAuth)
          {
            $objEchecAuth = new Echec_authentification();
            $objEchecAuth->setUtilisateur($objUsrABloquer);
            $objEchecAuth->setCompeurConnection(1);
            $objEchecAuth->setInfoSupplementaire("IP: ".$_SERVER["REMOTE_ADDR"]);
          } else
          {
            if ($objEchecAuth->existsEchecLesNDernierMinutes($intEspaceTempsMinutes))
            {
              $objEchecAuth->setCompeurConnection($objEchecAuth->getCompeurConnection()+1);
            } else
            {
              $objEchecAuth->setCompeurConnection(1);
            }

            $objEchecAuth->setInfoSupplementaire("IP: ".$_SERVER["REMOTE_ADDR"]);
          }

          try {
            $objEchecAuth->save();
          } catch (Exception $exc) {
            $this->logger->err("{" . __CLASS__ . "} " . __FUNCTION__ . " - erreur de sauvegarde de l'echec de connection - identifiant: ".$arrValeurs['email']." - IP: ".$_SERVER["REMOTE_ADDR"]);
          }

          if ($objEchecAuth->getCompeurConnection() >= $intNbrEchecsAutorise)
          {
            $objUsrABloquer->setEstActif(0);

            try {
              $objUsrABloquer->save();

              $this->getUser()->setFlash("erreur", libelle("msg_utilisateur_compte_bloque"));
            } catch (Exception $exc) {
              $this->logger->err("{" . __CLASS__ . "} " . __FUNCTION__ . " - erreur de bloquage de compte utilisateur - email: ".$arrValeurs['email']);
            }
          }
        }
      }
    }
  }

  public function postExecute() {
    
  }

}

