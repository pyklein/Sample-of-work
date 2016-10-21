<?php

/**
 * Classe gérant l'enregistrement des mails à envoyer en base de donnée.
 * Projet: GRID
 * Module: email
 * Date de création: 28/02/2011
 * @author William Richards
 */
class GestionnaireMail {

  public function envoyerMailDemandePartage(Utilisateur $objSuperUtilisateur, $strContenuMail, Utilisateur $objDemandeur) {
    sfContext::getInstance()->getLogger()->debug('envoyerMailDemandePartage Start');

    //Création du mail
    $objEmail = new Mail();
    $objEmail->setSujet('Demande  de partage de dossier');
    $objEmail = $this->remplirChampsCommuns($objEmail, $objSuperUtilisateur, $objDemandeur, $strContenuMail);

    $objEmail->save();

    sfContext::getInstance()->getLogger()->debug('envoyerMailDemandePartage Fin');
  }

  /**
   * Construit l'objet Mail à enregistrer dans le cas de la création d'un compte utilisateur
   * @param Utilisateur   $objNouvelUtilisateur   Destinataire du mail (nouvel utilisateur)
   * @param String        $strContenuMail         Contenu du mail généré et rendu au préalable
   * @param Utilisateur   $objAdmin               Utilisateur créant le nouveau compte
   *
   * @author William Richards
   */
  public function envoyerMailNouvelUtilisateur(Utilisateur $objNouvelUtilisateur, $strContenuMail, Utilisateur $objAdmin) {
    sfContext::getInstance()->getLogger()->debug('envoyerMailNouvelUtilisateur Start');

    //Création du mail
    $objEmail = new Mail();
    $objEmail->setSujet('Bienvenue sur GRID');
    $objEmail = $this->remplirChampsCommuns($objEmail, $objNouvelUtilisateur, $objAdmin, $strContenuMail);

    $objEmail->save();

    sfContext::getInstance()->getLogger()->debug('envoyerMailNouvelUtilisateur Fin');
  }

  public function envoyerMailReinitialisationMotDePasseUtilisateur(Utilisateur $objUtilisateur, $strContenuMail) {
    sfContext::getInstance()->getLogger()->debug('envoyerMailReinitialisationMotDePasseUtilisateur Start');

    //Création du mail
    $objEmail = new Mail();
    $objEmail->setSujet('Reinitialisation de mot de passe GRID');
    $objEmail = $this->remplirChampsCommuns($objEmail, $objUtilisateur, null, $strContenuMail);

    $objEmail->save();

    sfContext::getInstance()->getLogger()->debug('envoyerMailReinitialisationMotDePasseUtilisateur Fin');
  }

  /**
   * Envoie de mail de apres un success de creation de utilisateur
   *
   * @param Utilisateur   $objNouvelUtilisateur   Destinataire du mail (nouvel utilisateur)
   * @param String        $strContenuMail         Contenu du mail généré et rendu au préalable
   * @param Utilisateur   $objAdmin               Utilisateur créant le nouveau compte
   *
   * @author Simeon PETEV
   */
  public function envoyerMailAuUtilisateurApresCreation(Utilisateur $objUtilisateur, $strContenuMail, Utilisateur $objAdmin) {
    sfContext::getInstance()->getLogger()->debug('envoyerMailAuUtilisateurApresCreation Start');

    //Création du mail
    $objEmail = new Mail();
    $objEmail->setSujet('Votre compte sur GRID a été créé');
    $objEmail = $this->remplirChampsCommuns($objEmail, $objUtilisateur, $objAdmin, $strContenuMail);

    $objEmail->save();

    sfContext::getInstance()->getLogger()->debug('envoyerMailAuUtilisateurApresCreation Fin');
  }

  public function envoyerMailDeRelanceDossierMIP(Utilisateur $objUtilisateur, $strContenuMail, $strNumeroDossierMip) {
    sfContext::getInstance()->getLogger()->debug('envoyerMailDeRelanceDossierMIP Start');

    //Création du mail
    $objEmail = new Mail();
    $objEmail->setSujet('GRID - Mail de relance - Dossier ' . $strNumeroDossierMip);
    $objEmail = $this->remplirChampsCommuns($objEmail, $objUtilisateur, new Utilisateur(), $strContenuMail);

    $objEmail->save();

    sfContext::getInstance()->getLogger()->debug('envoyerMailDeRelanceDossierMIP Fin');
  }

  /**
   * Enregiste le mail d'alert à envoyer - action à mener
   * @param Utilisateur $objUtilisateur
   * @param string $strContenuMail
   * @param string $strNumeroDossierBpi
   * @author Gabor JAGER
   */
  public function envoyerMailAlerteBpiActionAMener(Utilisateur $objUtilisateur, $strContenuMail, $strNumeroDossierBpi) {
    sfContext::getInstance()->getLogger()->debug(__CLASS__ . "->" . __FUNCTION__ . "() - Début");

    // Création du mail
    $objEmail = new Mail();
    $objEmail->setSujet("GRID - Mail d'alerte - Dossier " . $strNumeroDossierBpi);
    $objEmail = $this->remplirChampsCommuns($objEmail, $objUtilisateur, new Utilisateur(), $strContenuMail);

    $objEmail->save();

    sfContext::getInstance()->getLogger()->debug(__CLASS__ . "->" . __FUNCTION__ . "() - Fin");
  }

  /**
   * Enregiste le mail d'alert à envoyer - alertes regroupées
   * @param Utilisateur[] $arrUtilisateur
   * @param string $strContenuMail
   * @param string $strNumeroDossierBpi
   * @author Gabor JAGER
   */
  public function envoyerMailAlerteBpi($arrUtilisateurs, $strContenuMail, $strNumeroDossierBpi) {
    sfContext::getInstance()->getLogger()->debug(__CLASS__ . "->" . __FUNCTION__ . "() - Début");

    foreach ($arrUtilisateurs as $objUtilisateur) {
      // Création du mail
      $objEmail = new Mail();
      $objEmail->setSujet("GRID - Mail d'alerte - Dossier " . $strNumeroDossierBpi);
      $objEmail = $this->remplirChampsCommuns($objEmail, $objUtilisateur, new Utilisateur(), $strContenuMail);
      $objEmail->save();
    }

    sfContext::getInstance()->getLogger()->debug(__CLASS__ . "->" . __FUNCTION__ . "() - Fin");
  }

  public function envoyerMailImportationIXarm($arrUtilisateurs, $strContenuMail) {
    sfContext::getInstance()->getLogger()->debug(__CLASS__ . "->" . __FUNCTION__ . "() - Début");
    foreach ($arrUtilisateurs as $objUtilisateur) {
      $objEmail = new Mail();
      $objEmail->setSujet("GRID - Mail de suivi des importations MRIS");
      $objEmail = $this->remplirChampsCommuns($objEmail, $objUtilisateur, new Utilisateur(), $strContenuMail);
      $objEmail->save();
    }
    sfContext::getInstance()->getLogger()->debug(__CLASS__ . "->" . __FUNCTION__ . "() - Fin");
  }

  /**
   *
   * @param   Mail        $objEmail         Email à remplir
   * @param   Utilisateur $objDestinataire  Destinataire du mail
   * @param   Utilisateur $objAdmin         Responsable de la création du mail
   * @param   string      $strContenu       Corp du mail
   * @return  Mail  Email complété avec les champs génériques (destinataire, date, etc.)
   *
   */
  protected function remplirChampsCommuns(Mail $objEmail, Utilisateur $objDestinataire, $objAdmin, $strContenu) {
    sfContext::getInstance()->getLogger()->debug('remplirChampsCommuns Debut');

    $objEmail->setDestinataire($objDestinataire->getEmail());
    $objEmail->setMessage($strContenu);
    if ($objAdmin && !$objAdmin->isNew())
      $objEmail->setUtilisateurCreatedBy($objAdmin);
    $objEmail->setDateEnvoi(date('Y-m-d H:i:s'));
    $objEmail->setStatutId('1');
    $objEmail->setNombreTentative('0');

    sfContext::getInstance()->getLogger()->debug('remplirChampsCommuns Fin');
    return $objEmail;
  }

}

?>
