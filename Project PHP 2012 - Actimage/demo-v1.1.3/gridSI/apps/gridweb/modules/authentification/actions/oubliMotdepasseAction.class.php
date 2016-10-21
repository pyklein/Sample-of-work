<?php

/**
 * Action lors d'un oubli de mot de passe
 * @author Jihad
 */
class oubliMotdepasseAction extends sfAction
{
  /**
   * @var sfLogger
   */
  var $logger;
  
  public function preExecute()
  {
    $this->logger = sfContext::getInstance()->getLogger();

    // déjà connecté
    if (sfContext::getInstance()->getUser()->isAuthenticated())
    {
      $this->logger->debug("{".__CLASS__."} ".__FUNCTION__." - déjà connecté");
      $this->redirect("@accueil");
    }
  }

  public function execute($request)
  {
    // formulaire
    $this->objForm = new DemandeMotdepasseForm();

    // submit formulaire
    if ($request->isMethod('post'))
    {
      $this->objForm->bind($request->getParameter($this->objForm->getName()));

      // valeurs de formulaire
      $arrValeurs = $this->objForm->getTaintedValues();

      $this->logger->debug("{".__CLASS__."} ".__FUNCTION__." - essai - mail: ".$arrValeurs['email']);

      // demande de mot de passe reussi
      if ($this->objForm->isValid())
      {
        $this->logger->debug("{".__CLASS__."} ".__FUNCTION__." - reinitialisation correct - mail: ".$arrValeurs['email']);

        $objUtilisateur = UtilisateurTable::getInstance()->getUtilisateurParMail($arrValeurs['email']);

        //Interdiction de reinitialisation si dans LDAP
        if ($objUtilisateur && $objUtilisateur->getEstUtilisateurLdap())
        {
          $this->logger->debug("{".__CLASS__."} ".__FUNCTION__." - reinitialisation interompu (compte LDAP non initialisable) - mail: ".$arrValeurs['email']);
          $this->getUser()->setFlash("erreur", libelle('msg_utilisateur_reinit_mdp_interdit'));
          $this->redirect("@seconnecter");
        }

        $objUtilMotDePasse = new UtilMotDePasse(sfConfig::get("app_mot_de_passe_longueur"), sfConfig::get("app_mot_de_passe_alphabet"));

        $strMotDePasseTemporaire = $objUtilMotDePasse->getMotDePasseAleatoire();
        $objUtilisateur->setMotDePasse(sha1($strMotDePasseTemporaire));

        //Envoi d'un mail à l'utilisateur contenant le mot de passe en clair
        $gestionnaireMail = new GestionnaireMail();
        $strContenuMail = $this->getPartial('email/contenuMailReinitialisationMotDePasseUtilisateur',array('utilisateur' => $objUtilisateur,'motdepasse' => $strMotDePasseTemporaire));
        $gestionnaireMail->envoyerMailReinitialisationMotDePasseUtilisateur($objUtilisateur, $strContenuMail, null);

        try
        {
          $objUtilisateur->save();
          $this->getUser()->setFlash("succes", libelle('msg_utilisateur_reinit_mdp_succes',array($objUtilisateur->getNom())));
        }
        catch(Exception $ex)
        {
          $this->getUser()->setFlash("erreur", libelle('msg_utilisateur_reinit_mdp_echec',array($objUtilisateur->getNom(),$ex->getMessage())));
        }

        $this->redirect("@accueil");
      }

      // erreur de login
      else
      {
        $this->logger->err("{".__CLASS__."} ".__FUNCTION__." - reinitialisation erreur - mail: ".$arrValeurs['email']);
      }
    }
  }

    
  public function postExecute() {}
}

