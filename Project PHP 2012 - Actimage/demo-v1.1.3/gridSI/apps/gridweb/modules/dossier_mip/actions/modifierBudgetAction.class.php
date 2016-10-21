
<?php

/**
 * Modifier une ligne budgetaire
 * @author     Jihad Sahebdin
 */
class modifierBudgetAction extends gridAction
{
  public function execute($request)
  {
    if (!$request->hasParameter('id')){
     $this->redirect('@non_autorise');
    }
    
    $objBudget = BudgetTable::getInstance()->findOneById($request->getParameter('id'));
    if (!$objBudget){
      $this->redirect('@non_autorise');
    }
    
    $this->idContenant = $request->getParameter('dossier_mip');
    $this->strContenant = 'dossier_mip';
    $this->objContenant = Dossier_mipTable::getInstance()->findOneById($this->idContenant);
    
    if (!$this->objContenant){
      $this->redirect("@non_autorise");
    }
    
    $this->objForm = new BudgetForm($objBudget);

    if ($request->isMethod('post')) {
      $this->processForm('modifier', "suiviFinancierDossier_mips?dossier_mip=".$this->idContenant, true);
    }
  }
}
