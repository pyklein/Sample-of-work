<?php
sfContext::getInstance()->getConfiguration()->loadHelpers("Format");
/**
 * Description of exporterSuiviFinancierDossier_mipCSVAction
 *
 * @author Simeon Petev / Update Alexandre WETTA
 */
class exporterSuiviFinancierDossier_mipCSVAction extends gridAction
{
  public function  preExecute()
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    if (!$this->getUser()->hasAttribute('suivi_financier_dossier_mip_filtre'))
    {
      $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ Erreur: attribut filtre manquant; ");

      $this->getUser()->setFlash('erreur', libelle('msg_dossier_mip_financement_droit'));

      $this->redirect(url_for('dossier_mip/listerSuiviFinancierDossier_mips'));
    }

    parent::preExecute();

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }

  public function execute($request)
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    //Historique de tous les financements
    $this->arrBudgets = BudgetTable::getInstance()->getBudgetTotalParDossier();

    //Pour recupere la somme courrant du budget au moment du financement
    $this->utilArray = new UtilArray();

    $strNomFichier = "export_suivis_financier_dossiers_mip".date("YmdHis").".csv";

    $arrValues = $this->getUser()->getAttribute('suivi_financier_dossier_mip_filtre');

    $this->arrFinancements = FinancementTable::getInstance()->retreveFinancementsPourAnnee($arrValues['annee']);

    //On calcule le global des financements
    $this->floatTotalGlobalFinancements = 0;
    foreach ($this->arrFinancements as $objFinancement)
    {
      if ($objFinancement->getBudget_type()->getEstNegatif())
      {
        $this->floatTotalGlobalFinancements -= $objFinancement->getMontant();
      } else
      {
        $this->floatTotalGlobalFinancements += $objFinancement->getMontant();
      }
    }


    $this->arrTotauxParOrgMindef = $this->getFinancementParOrganismeMindef($this->arrFinancements);

    $this->arrTotauxParEntite = $this->getFinancementParEntite($this->arrFinancements);

    // creation du fichier + téléchargement
    $this->creerFichier($strNomFichier);

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }


  /**
   * Créer le fichier CSV
   * @param string $strNomFichier
   * 
   * @author Simeon PETEV
   */
  private function creerFichier($strNomFichier)
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    $objUtilCsv = new UtilCsv($strNomFichier);

    // en tete
    $objUtilCsv->ajouterValeur(libelle("msg_libelle_numero"));
    $objUtilCsv->ajouterValeur(libelle("msg_libelle_titre"));
    $objUtilCsv->ajouterValeur(libelle("msg_libelle_pilote"));
    $objUtilCsv->ajouterValeur(libelle("msg_libelle_service_executant"));
    $objUtilCsv->ajouterValeur(libelle("msg_libelle_code_se"));
    $objUtilCsv->ajouterValeur(libelle("msg_libelle_reference_financement"));
    $objUtilCsv->ajouterValeur(libelle("msg_dossier_mip_suivi_financement_libelle_budget_moment_financement"));
    $objUtilCsv->ajouterValeur(libelle("msg_libelle_montant_financement"));
    $objUtilCsv->ajouterLigne();

    // contenu
    foreach ($this->arrFinancements as $objFinancement)
    {
      $objUtilCsv->ajouterValeur($objFinancement->getDossier_mip()->getNumero());
      $objUtilCsv->ajouterValeur($objFinancement->getDossier_mip()->getTitre());
      $objUtilCsv->ajouterValeur($objFinancement->getDossier_mip()->getPilote());
      $objUtilCsv->ajouterValeur($objFinancement->getEntite()->getNomHierarchique());
      $objUtilCsv->ajouterValeur("(".$objFinancement->getEntite()->getCodeExecutant().")");
      $objUtilCsv->ajouterValeur($objFinancement->getReference());
      $objUtilCsv->ajouterValeur(formatMontantFr($this->arrBudgets[$objFinancement->getDossierMipId()]));
      $objUtilCsv->ajouterValeur(formatMontantFr($objFinancement->getMontantAvecSigne()));



      $objUtilCsv->ajouterLigne();
    }

    $objUtilCsv->ajouterValeur(" ");
    $objUtilCsv->ajouterValeur(" ");
    $objUtilCsv->ajouterValeur(" ");
    $objUtilCsv->ajouterValeur(" ");
    $objUtilCsv->ajouterValeur(" ");
    $objUtilCsv->ajouterValeur(" ");
    $objUtilCsv->ajouterValeur(libelle('msg_libelle_total_global'));
    $objUtilCsv->ajouterValeur(formatMontantFr($this->floatTotalGlobalFinancements));
    $objUtilCsv->ajouterLigne();

    foreach ($this->arrTotauxParOrgMindef as $OrgMindef => $montant) {
      $objUtilCsv->ajouterValeur(" ");
      $objUtilCsv->ajouterValeur(" ");
      $objUtilCsv->ajouterValeur(" ");
      $objUtilCsv->ajouterValeur(" ");
      $objUtilCsv->ajouterValeur(" ");
      $objUtilCsv->ajouterValeur(" ");
      $objUtilCsv->ajouterValeur(libelle('msg_libelle_total') . ' ' . $OrgMindef);
      $objUtilCsv->ajouterValeur(formatMontantFr($montant));
      $objUtilCsv->ajouterLigne();
    }

    foreach ($this->arrTotauxParEntite as $entiteCodeExec => $montant) {
      $objUtilCsv->ajouterValeur(" ");
      $objUtilCsv->ajouterValeur(" ");
      $objUtilCsv->ajouterValeur(" ");
      $objUtilCsv->ajouterValeur(" ");
      $objUtilCsv->ajouterValeur(" ");
      $objUtilCsv->ajouterValeur(" ");
      $objUtilCsv->ajouterValeur(libelle('msg_libelle_total') . ' ' . $entiteCodeExec);
      $objUtilCsv->ajouterValeur(formatMontantFr($montant));
      $objUtilCsv->ajouterLigne();
    }

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ telecharget; ");

    // on télécharge le fichier
    $objUtilCsv->telechargerFichier();

  }

 

  /**
   * Récupère les montants total par organisme MINDEF
   *
   * @param array $arrFinancements
   * @return array Un tableau sous la forme suivante $arrOrganisme["str_abreviation_organisme"] = "float_montant_total"
   * @author Alexandre WETTA
   */
  private function getFinancementParOrganismeMindef($arrFinancements) {

    //initialisation de variables
    $arrOrganisme = array();
    $totalTemp = 0;

    foreach ($arrFinancements as $objFinancement) {
      $orgMindef = $objFinancement->getDossier_mip()->getOrganisme_mindef()->getAbreviation();
      $boolEstNegatif = $objFinancement->getBudget_type()->getEstNegatif();
      if(!key_exists($orgMindef, $arrOrganisme)){
        $floatMontant = ($boolEstNegatif) ? -$objFinancement->getMontant() : $objFinancement->getMontant();
        $arrOrganisme[$orgMindef] = $floatMontant;
      }else{
        $floatMontant = ($boolEstNegatif) ? -$objFinancement->getMontant() : $objFinancement->getMontant();
        $totalTemp = $arrOrganisme[$orgMindef] + $floatMontant ;
        $arrOrganisme[$orgMindef] = $totalTemp ;
      }

    }

    return $arrOrganisme ;

  }

  /**
   * Récupère les montants total par entité
   *
   * @param array $arrFinancements
   * @return array  Tableau sous la forme suivante $arrEntite["str_entite_code_executant"] = "float_montant_total"
   * @author Alexandre WETTA
   */
  private function getFinancementParEntite($arrFinancements){

    //initialisation de variables
    $arrEntite = array();
    $totalTemp = 0;

    foreach ($arrFinancements as $objFinancement) {
        $strCodeEntite = $objFinancement->getEntite()->getCodeExecutant();
        $boolEstNegatif = $objFinancement->getBudget_type()->getEstNegatif();
        if(!key_exists($strCodeEntite, $arrEntite)){
          $floatMontant = ($boolEstNegatif) ? -$objFinancement->getMontant() : $objFinancement->getMontant();
          $arrEntite[$strCodeEntite] = $floatMontant;
        }else{
          $floatMontant = ($boolEstNegatif)? -$objFinancement->getMontant() : $objFinancement->getMontant();
          $totalTemp = $arrEntite[$strCodeEntite] + $floatMontant ;
          $arrEntite[$strCodeEntite] = $totalTemp;
        }
    }

    return $arrEntite ;

  }
}
?>
