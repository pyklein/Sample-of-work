<?php

/**
 * Export CSV des rapports statistiques
 *
 * @author Alexandre WETTA
 */
class exporterRapportStatistiqueCSVAction extends gridAction {

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



    //le filtre
    $this->objFormFiltre = new Dossier_mipStatistiquesFormFilter();
    $strFilterName = $this->objFormFiltre->getName();

    if ($this->getUser()->hasAttributeAction('filtre_dossier_mips', "dossier_mip/voirRapportStatistique")) {
      $this->logger->debug("Avec le filtre");

      $this->getUser()->setAttributeAction('filtre_dossier_mips', $this->getUser()->getAttributeAction('filtre_dossier_mips', null, "dossier_mip/voirRapportStatistique"));
    } else {
      $this->logger->debug("Sans filtre");
    }

    $objRequeteDoctrine = Dossier_mipTable::getInstance()->getRequeteListeParUtilisateur($this->processFiltre(), $this->getUser());
    $this->results = $objRequeteDoctrine->execute();

    $this->resultatsStatuts = null;
    $this->resultatsAnnees = null;
    $this->resultatsOrganismesMindef = null;
    $this->resultatsNiveaux = null;


//On determine les groupements présents
    $this->boolStatuts = true;
    $this->boolAnnees = true;
    $this->boolOrganismesMindef = true;
    $this->boolNiveaux = true;
    if ($request->hasParameter($strFilterName)) {
      $arrParams = $request->getParameter($strFilterName);
      if ($arrParams['organisme_mindef_id'] != '') {
        $this->boolOrganismesMindef = false;
      }
      if ($arrParams['statut_dossier_mip_id'] != '') {
        $this->boolStatuts = false;
      }
      if ($arrParams['niveau_protection_id'] != '') {
        $this->boolNiveaux = false;
      }
      if ($arrParams['created_at']['to'] != '' && $arrParams['created_at']['from'] != '') {
        if (substr($arrParams['created_at']['to'], 7) == substr($arrParams['created_at']['from'], 7)) {
          $this->boolAnnees = false;
        }
      }
    }

//Récupération des résultats pour chaque tableau
    if ($this->boolStatuts && $request->getParameter('typeStat') == 'statut') {
      $this->resultatsStatuts = Dossier_mipTable::getInstance()->getCountsByStatuts($objRequeteDoctrine);
    }
    if ($this->boolAnnees && $request->getParameter('typeStat') == 'annees') {
      $this->resultatsAnnees = Dossier_mipTable::getInstance()->getCountsByAnnees($objRequeteDoctrine);
    }
    if ($this->boolOrganismesMindef && $request->getParameter('typeStat') == 'organismesMindef') {
      $this->resultatsOrganismesMindef = Dossier_mipTable::getInstance()->getCountsByOrganismesMindef($objRequeteDoctrine);
    }
    if ($this->boolNiveaux && $request->getParameter('typeStat') == 'niveaux') {
      $this->resultatsNiveaux = Dossier_mipTable::getInstance()->getCountsByNiveaux($objRequeteDoctrine);
    }
    if ($request->getParameter('typeStat') == 'etatsControle') {
      $this->restultatsEtatControle = Dossier_mipTable::getInstance()->getCountsByEtatsControle($objRequeteDoctrine);
    } 
    if ($request->getParameter('typeStat') == 'brevets') {
      $this->resultatsBrevets =  Dossier_mipTable::getInstance()->getCountsByBrevets($objRequeteDoctrine);
    }

    // creation du fichier + téléchargement
    if ($request->getParameter('typeStat') == 'statut') {
      $strNomFichier = "export_rapport_statistique_statut_" . date("YmdHis") . ".csv";
      $this->creerFichier($strNomFichier, $this->resultatsStatuts);
    } else if ($request->getParameter('typeStat') == 'annees') {
      $strNomFichier = "export_rapport_statistique_annees_" . date("YmdHis") . ".csv";
      $this->creerFichier($strNomFichier, $this->resultatsAnnees);
    } else if ($request->getParameter('typeStat') == 'organismesMindef') {
      $strNomFichier = "export_rapport_statistique_orgMindef_" . date("YmdHis") . ".csv";
      $this->creerFichier($strNomFichier, $this->resultatsOrganismesMindef);
    } else if ($request->getParameter('typeStat') == 'niveaux') {
      $strNomFichier = "export_rapport_statistique_niveaux_" . date("YmdHis") . ".csv";
      $this->creerFichier($strNomFichier, $this->resultatsNiveaux);
    } else if ($request->getParameter('typeStat') == 'etatsControle') {
      $strNomFichier = "export_rapport_statistique_etat_controle_" . date("YmdHis") . ".csv";
      $this->creerFichier($strNomFichier, $this->restultatsEtatControle);
    }else if ($request->getParameter('typeStat') == 'brevets') {
      $strNomFichier = "export_rapport_statistique_brevets_" . date("YmdHis") . ".csv";
      $this->creerFichier($strNomFichier, $this->resultatsBrevets);
    }


    if (sfContext::hasInstance()) {
      $this->logger->debug(__CLASS__ . "->" . __FUNCTION__ . "() End");
    }
  }

  /**
   * Créer le fichier CSV
   * @param string $strNomFichier
   * @param $arrResultats[] $arrResultatsDossiers
   * @author Alexandre WETTA
   */
  private function creerFichier($strNomFichier, $arrResultats=array()) {
    $this->logger->debug("{" . __CLASS__ . "} " . __FUNCTION__ . " - strNomFichier: " . $strNomFichier);

    $objUtilCsv = new UtilCsv($strNomFichier);

    

    // contenu en fonction du type de classement
    if ($this->getRequest()->getParameter('typeStat') == 'annees') {

      // en tete
      $objUtilCsv->ajouterValeur(libelle("msg_libelle_annee"));
      $objUtilCsv->ajouterValeur(libelle("msg_libelle_nombre_dossier_ouvert"));
      $objUtilCsv->ajouterValeur(libelle("msg_libelle_nombre_dossier_clos"));

      $objUtilCsv->ajouterLigne();

      foreach ($arrResultats as $objResultat => $count) {
        $objUtilCsv->ajouterValeur($objResultat);
        $objUtilCsv->ajouterValeur($count['ouvert']);
        $objUtilCsv->ajouterValeur($count['clos']);
        $objUtilCsv->ajouterLigne();
      }
    } else {

      // en tete
      if ($this->getRequest()->getParameter('typeStat') == 'statut') {
        $objUtilCsv->ajouterValeur(libelle("msg_libelle_statut"));
      }else if($this->getRequest()->getParameter('typeStat') == 'organismesMindef'){
        $objUtilCsv->ajouterValeur(libelle("msg_libelle_organisme_armee"));
      }else if($this->getRequest()->getParameter('typeStat') == 'niveaux'){
        $objUtilCsv->ajouterValeur(libelle("msg_libelle_niveau_protection"));
      }else if($this->getRequest()->getParameter('typeStat') == 'etatsControle'){
        $objUtilCsv->ajouterValeur(libelle("msg_libelle_etat_controle"));
      }else if($this->getRequest()->getParameter('typeStat') == 'brevets'){
        $objUtilCsv->ajouterValeur(libelle("msg_libelle_type_information"));
      }
      $objUtilCsv->ajouterValeur(libelle("msg_libelle_nombre_dossier"));
      $objUtilCsv->ajouterLigne();

      //données
      foreach ($arrResultats as $objResultat => $count) {
        //on remplace les -- par des espaces
        //(sinon excel interprète les données en tant que formule)
        if(preg_match('#^\-\-#', $objResultat)){
          $objResultat = substr_replace($objResultat, '  ', 0, 2);
        }
        $objUtilCsv->ajouterValeur($objResultat);
        $objUtilCsv->ajouterValeur($count);
        $objUtilCsv->ajouterLigne();
      }
    }


    $this->logger->debug("{" . __CLASS__ . "} " . __FUNCTION__ . " - telecharger");

    // on télécharge le fichier
    $objUtilCsv->telechargerFichier();
  }

}
?>
