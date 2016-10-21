<?php

/**
 * Suppression d'une ligne budgétaire
 *
 * @author Jihad Sahebdin
 */
class supprimerBudgetAction extends gridAction {

  public function execute($objRequeteWeb)
  {
    if (!$objRequeteWeb->hasParameter('id'))
    {
      $this->redirect("@non_autorise");
    }
    $objBudget = BudgetTable::getInstance()->findOneById($objRequeteWeb->getParameter('id'));
    
    if (!$objBudget) {
      $this->redirect('@non_autorise');
    }

    $this->strContenant = 'dossier_mip';
    $this->idContenant = $objRequeteWeb->getParameter('dossier_mip');

    $this->objDossierMip = $objBudget->getDossier_mip();
    $this->objBudget = $objBudget;

    if ($objRequeteWeb->isMethod('post'))
    {
      try
      {
        $objBudget->delete();
        $this->getUser()->setFlash('succes', libelle("msg_budget_suppression_reussie"));
      }
      catch (Exception $ex)
      {
        $this->getUser()->setFlash('erreur', libelle("msg_budget_suppression_erreur"));
      }
      $this->redirect('dossier_mip/suiviFinancierDossier_mips?dossier_mip='.$this->idContenant);
      
    }
  }

}

?>
