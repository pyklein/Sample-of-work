<?php
/**
 * Ajouter une ligne budgetaire

 * @author Jihad Sahebdin
 */
class creerBudgetAction extends gridAction
{
  public function execute($request)
  {
    $objBudget = new Budget();

    $this->idContenant = $request->getParameter('dossier_mip');
    $this->strContenant = 'dossier_mip';
    $this->objContenant = Dossier_mipTable::getInstance()->findOneById($this->idContenant);
    
    if (!$this->objContenant){
      $this->redirect("@non_autorise");
    }

    $objBudget->setDossierMipId($this->idContenant);
    
    $this->objForm = new BudgetForm($objBudget);
    if($request->isMethod('post'))
    {
      $this->processForm('creer',"suiviFinancierDossier_mips?dossier_mip=".$this->idContenant, true);
    }
  }


  
}
