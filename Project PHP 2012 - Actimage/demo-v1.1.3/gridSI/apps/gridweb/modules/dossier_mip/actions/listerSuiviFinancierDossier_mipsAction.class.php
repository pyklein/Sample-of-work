<?php

/**
 * Description of listerSuiviFinancierDossier_mipsAction
 *
 * @author Simeon Petev / Update : Alexandre WETTA
 */
class listerSuiviFinancierDossier_mipsAction extends gridAction
{


  public function execute($request)
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    //Historique de tous les financements
    $this->arrBudgets = BudgetTable::getInstance()->getBudgetTotalParDossier();


    //Pour recupere la somme courrant du budget au moment du financement
    $this->utilArray = new UtilArray();

    $this->objFinancementFiltre = new FinancementTousDossier_mipFormFilter();

    //On recupere les financements
    if ($this->getRequest()->isMethod('post'))
    {
      $arrValues = $this->getRequest()->getParameter($this->objFinancementFiltre->getName());

      $this->objFinancementFiltre->bind($arrValues);

      $this->arrFinancements = FinancementTable::getInstance()->retreveFinancementsPourAnnee($arrValues['annee']);

      //Pour l'export csv
      $this->getUser()->setAttribute('suivi_financier_dossier_mip_filtre', $arrValues);
    } else
    {
      $this->arrFinancements = FinancementTable::getInstance()->retreveFinancementsPourAnnee($this->objFinancementFiltre->getDefault('annee'));

      //Pour l'export csv
      $this->getUser()->setAttribute('suivi_financier_dossier_mip_filtre', array('annee'=>$this->objFinancementFiltre->getDefault('annee')));
    }

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


    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
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
