<?php

/**
 * Action d'export CSV
 * @author Simeon Petev
 */
class exporterUtilisateursCSVAction extends gridAction
{
  /**
   * @var sfLogger
   */
  var $logger;

  public function preExecute() {
    $this->logger = sfContext::getInstance()->getLogger();
  }
  
  public function execute($request)
  {
    $this->logger->debug("{".__CLASS__."} ".__FUNCTION__."");

    $strNomFichier = "export_utilisateurs_".date("YmdHis").".csv";

    if ($this->getUser()->hasAttribute('filtre_utilisateurs'))
    {
      $objFiltre = new UtilisateurFormFilter();
      $objFiltre->bind($this->getUser()->getAttribute('filtre_utilisateurs'));
      $objQueryUtilisateurs = UtilisateurTable::getInstance()->getQueryUtilisateursAvecFiltre($objFiltre);
    }
    else
    {
      $objQueryUtilisateurs = UtilisateurTable::getInstance()->getQueryObject();
    }

    $arrResultatsUtilisateurs = $objQueryUtilisateurs->execute();

    // creation du fichier + téléchargement
    $this->creerFichier($strNomFichier, $arrResultatsUtilisateurs);

    // on ne devrait jamais y arriver
    $this->logger->error("{".__CLASS__."} ".__FUNCTION__." - strNomFichier: ".$strNomFichier);
  }

  /**
   * Créer le fichier CSV
   * @param string $strNomFichier
   * @param Utilisateur[] $arrResultatUtilisateurs
   * @author Gabor JAGER
   */
  private function creerFichier($strNomFichier, $arrResultatUtilisateurs=array())
  {
    $this->logger->debug("{".__CLASS__."} ".__FUNCTION__." - strNomFichier: ".$strNomFichier);

    $objUtilCsv = new UtilCsv($strNomFichier);

    // en tete
    $objUtilCsv->ajouterValeur(libelle("msg_libelle_nom"));
    $objUtilCsv->ajouterValeur(libelle("msg_utilisateur_libelle_prenom"));
    $objUtilCsv->ajouterValeur(libelle("msg_libelle_email"));
    $objUtilCsv->ajouterValeur(libelle("msg_libelle_statut"));
    $objUtilCsv->ajouterValeur(libelle("msg_libelle_org_mindef"));
    $objUtilCsv->ajouterValeur(libelle("msg_utilisateur_libelle_entite_affect"));
    $objUtilCsv->ajouterLigne();

    // contenu
    foreach ($arrResultatUtilisateurs as $objUtilisateur)
    {
      $objUtilCsv->ajouterValeur($objUtilisateur->getNom());
      $objUtilCsv->ajouterValeur($objUtilisateur->getPrenom());
      $objUtilCsv->ajouterValeur($objUtilisateur->getEmail());
      $objUtilCsv->ajouterValeur($objUtilisateur->getEstActif() ? libelle("msg_libelle_actif") : libelle("msg_libelle_inactif"));
      $objUtilCsv->ajouterValeur($objUtilisateur->getAbreviationOrganismeMindef());
      $objUtilCsv->ajouterValeur($objUtilisateur->getAbreviationEntite());

      $objUtilCsv->ajouterLigne();
    }

    $this->logger->debug("{".__CLASS__."} ".__FUNCTION__." - telecharger");

    // on télécharge le fichier
    $objUtilCsv->telechargerFichier();

  }
}
