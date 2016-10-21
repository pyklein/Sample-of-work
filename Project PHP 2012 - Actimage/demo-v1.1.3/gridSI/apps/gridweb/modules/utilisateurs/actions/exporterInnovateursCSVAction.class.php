<?php
sfContext::getInstance()->getConfiguration()->loadHelpers("Format");

/**
 * Description of exporterInnovateursCSVAction
 *
 * @author Alexandre WETTA
 */
class exporterInnovateursCSVAction extends gridAction {

  /**
   * @var sfLogger
   */
  var $logger;

  public function preExecute() {
    if (sfContext::hasInstance()) {
      $this->logger = $this->getLogger();
    }
  }

  public function execute($request) {
    if (sfContext::hasInstance()) {
      $this->logger->debug(__CLASS__ . "->" . __FUNCTION__ . "() Start");
    }

    $strNomFichier = "export_innovateurs_" . date("YmdHis") . ".csv";

    $this->objFormFiltre = new InnovateurFormFilter();

    if ($this->getUser()->hasAttributeAction('filtre_utilisateurs', "utilisateurs/rechercherInnovateurs")) {
      $this->logger->debug("Avec le filtre");

      $this->getUser()->setAttributeAction('filtre_utilisateurs', $this->getUser()->getAttributeAction('filtre_utilisateurs', null, "utilisateurs/rechercherInnovateurs"));
    } else {
      $this->logger->debug("Sans filtre");
    }

    $objRequeteDoctrine = $this->processFiltre();
    $objRequeteDoctrine = UtilisateurTable::getInstance()->retrieveInnovateursByProfil($objRequeteDoctrine, $this->getUser()->getCredentials());

    $arrResultatsInnovateurs = $objRequeteDoctrine->orderBy('nom ASC')->execute();


    // creation du fichier + téléchargement
    $this->creerFichier($strNomFichier, $arrResultatsInnovateurs );
    
    if (sfContext::hasInstance()) {
      $this->logger->debug(__CLASS__ . "->" . __FUNCTION__ . "() End");
    }
  }

  /**
   * Créer le fichier CSV
   * @param string $strNomFichier
   * @param $arrResultatsInnovateurs[] $arrResultatsDossiers
   * @author Alexandre WETTA
   */
  private function creerFichier($strNomFichier, $arrResultatsInnovateurs=array())
  {
    $this->logger->debug("{".__CLASS__."} ".__FUNCTION__." - strNomFichier: ".$strNomFichier);

    $objUtilCsv = new UtilCsv($strNomFichier);

    // en tete
    $objUtilCsv->ajouterValeur(libelle("msg_libelle_civilite"));
    $objUtilCsv->ajouterValeur(libelle("msg_libelle_nom"));
    $objUtilCsv->ajouterValeur(libelle("msg_utilisateur_libelle_nom_jeunefille"));
    $objUtilCsv->ajouterValeur(libelle("msg_libelle_prenom"));

    $objUtilCsv->ajouterValeur(libelle("msg_utilisateur_libelle_date_naissance"));
    $objUtilCsv->ajouterValeur(libelle("msg_utilisateur_libelle_date_deces"));
    $objUtilCsv->ajouterValeur(libelle("msg_utilisateur_libelle_statut"));

    $objUtilCsv->ajouterValeur(libelle("msg_libelle_email"));
    $objUtilCsv->ajouterValeur(libelle("msg_libelle_email2"));
    $objUtilCsv->ajouterValeur(libelle("msg_libelle_org_mindef") ." " . libelle("msg_libelle_entite_affectation"));
    $objUtilCsv->ajouterValeur(libelle("msg_utilisateur_libelle_grade"));
    $objUtilCsv->ajouterValeur(libelle("msg_utilisateur_libelle_tel_fixe"));
    $objUtilCsv->ajouterValeur(libelle("msg_utilisateur_libelle_tel_mobile"));
    $objUtilCsv->ajouterValeur(libelle("msg_utilisateur_libelle_tel_autre"));
    $objUtilCsv->ajouterValeur(libelle("msg_utilisateur_libelle_fax"));

    $objUtilCsv->ajouterValeur(libelle("msg_utilisateur_libelle_email_perso"));
    $objUtilCsv->ajouterValeur(libelle("msg_utilisateur_libelle_addr_perso_voix"));
    $objUtilCsv->ajouterValeur(libelle("msg_utilisateur_libelle_addr_perso_voix2"));
    $objUtilCsv->ajouterValeur(libelle("msg_utilisateur_libelle_addr_perso_voix3"));
    $objUtilCsv->ajouterValeur(libelle("msg_utilisateur_libelle_addr_perso_code_post"));
    $objUtilCsv->ajouterValeur(libelle("msg_utilisateur_libelle_addr_perso_ville"));
    $objUtilCsv->ajouterValeur(libelle("msg_utilisateur_libelle_addr_perso_complem"));
    $objUtilCsv->ajouterValeur(libelle("msg_utilisateur_libelle_tel_perso_fixe"));
    $objUtilCsv->ajouterValeur(libelle("msg_utilisateur_libelle_tel_perso_mobile"));

    
    $objUtilCsv->ajouterValeur(libelle("msg_libelle_etat"));
    $objUtilCsv->ajouterLigne();

    // contenu
    foreach ($arrResultatsInnovateurs as $objUtilisateur)
    {
      $objUtilCsv->ajouterValeur($objUtilisateur->getCivilite());
      $objUtilCsv->ajouterValeur($objUtilisateur->getNom());
      $objUtilCsv->ajouterValeur($objUtilisateur->getNom_jeunefille());
      $objUtilCsv->ajouterValeur($objUtilisateur->getPrenom());
      
      $dateNaissance = " ";
      if($objUtilisateur->getDate_naissance() != NULL)
      {
        $dateNaissance = formatDate($objUtilisateur->getDate_naissance());
      }
      $objUtilCsv->ajouterValeur($dateNaissance);

      $dateDeces = " ";
      if($objUtilisateur->getDate_deces() != NULL)
      {
        $dateDeces = formatDate($objUtilisateur->getDate_deces());
      }
      $objUtilCsv->ajouterValeur($dateDeces);
      
      $objUtilCsv->ajouterValeur($objUtilisateur->getStatut());
      $objUtilCsv->ajouterValeur($objUtilisateur->getEmail());
      $objUtilCsv->ajouterValeur($objUtilisateur->getEmail2());
      if($objUtilisateur->getEntiteId() != null) {
        $objUtilCsv->ajouterValeur($objUtilisateur->getEntite()->getNomHierarchique());
      }else{
        $objUtilCsv->ajouterValeur("");
      }

      $strGrade = " ";
      if($objUtilisateur->getGrade() != NULL)
      {
        $strGrade = $objUtilisateur->getGrade();
      }
      $objUtilCsv->ajouterValeur($strGrade);
      
      $objUtilCsv->ajouterValeur($objUtilisateur->getTelephone_fixe());
      $objUtilCsv->ajouterValeur($objUtilisateur->getTelephone_mobile());
      $objUtilCsv->ajouterValeur($objUtilisateur->getTelephone_autre());
      $objUtilCsv->ajouterValeur($objUtilisateur->getFax());

      $objUtilCsv->ajouterValeur($objUtilisateur->getEmail_perso());
      $objUtilCsv->ajouterValeur($objUtilisateur->getAdresse_perso());
      $objUtilCsv->ajouterValeur($objUtilisateur->getAdresse_perso2());
      $objUtilCsv->ajouterValeur($objUtilisateur->getAdresse_perso3());
      $objUtilCsv->ajouterValeur($objUtilisateur->getCode_postal_perso());

      $strVillePerso = " ";
      $intVillePersoId = $objUtilisateur->getVille_perso_id();
      if($intVillePersoId)
      {
        $strVillePerso = VilleTable::getInstance()->findOneById($intVillePersoId);
      }
      $objUtilCsv->ajouterValeur($strVillePerso);
      
      $objUtilCsv->ajouterValeur($objUtilisateur->getComplement_adresse_perso());
      $objUtilCsv->ajouterValeur($objUtilisateur->getTelephone_fixe_perso());
      $objUtilCsv->ajouterValeur($objUtilisateur->getTelephone_mobile_perso());


      $objUtilCsv->ajouterValeur($objUtilisateur->getEstActif() ? libelle("msg_libelle_actif") : libelle("msg_libelle_inactif"));

      $objUtilCsv->ajouterLigne();
    }

    
    $this->logger->debug("{".__CLASS__."} ".__FUNCTION__." - telecharger");

    // on télécharge le fichier
    $objUtilCsv->telechargerFichier();
  }
  

}
?>
