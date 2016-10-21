<?php

/**
 * Gestion des lignes budgetaires 
 *
 * @author JihadS
 */
class suiviFinancierDossier_mipsAction extends gridAction
{
  public function execute($objRequeteWeb)
  {
    if ($objRequeteWeb->hasParameter('dossier_mip'))
    {
      $this->strId = $objRequeteWeb->getParameter('dossier_mip');
    }
    else
    {
      $this->redirect("@non_autorise");
    }
 
    $this->strModelContenant = 'dossier_mip';
    $this->idContenant = $objRequeteWeb->getParameter('dossier_mip');
    $this->objContenant = Dossier_mipTable::getInstance()->findOneById($this->idContenant);
    if (!$this->objContenant){
      $this->redirect("@non_autorise");
    }

    $arrTotalAnnee = array();
    $this->intTotalGlobal = 0;

    $this->arrBudgets = BudgetTable::getInstance()->getBudgetParDossierId($this->idContenant);

    foreach($this->arrBudgets as $budget)
    {
      $objDateBudget = substr($budget->getDate_budget(),0,4);

      if(!array_key_exists($objDateBudget, $arrTotalAnnee))
      {
        $arrTotalAnnee[$objDateBudget] = 0;
      }

      if($budget->getBudget_type()->getId() == Budget_typeTable::ALLOUE)
      {
        $arrTotalAnnee[$objDateBudget] += $budget->getMontant();
      }
      else if($budget->getBudget_type()->getId() == Budget_typeTable::RESTITUE)
      {
        $arrTotalAnnee[$objDateBudget] -= $budget->getMontant();
      }
    }

    foreach($arrTotalAnnee as $date => $intTotal)
    {
      $this->intTotalGlobal += $intTotal;
    }

    $this->arrTotalAnnee = $arrTotalAnnee;
  }

}
