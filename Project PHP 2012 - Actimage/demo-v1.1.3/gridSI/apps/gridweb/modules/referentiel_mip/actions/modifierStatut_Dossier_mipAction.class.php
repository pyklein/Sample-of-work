<?php
sfContext::getInstance()->getConfiguration()->loadHelpers("Libelle");

/**
 * Modifier une notification
 * @author     Jihad Sahebdin
 */
class modifierStatut_Dossier_mipAction extends gridAction
{
  public function  preExecute()
  {
  }

  public function execute($request)
  {
    $objStatut = Statut_dossier_mipTable::getInstance()->findOneById($request->getParameter('id'));
    if (!$objStatut || !$objStatut->getEstActif()){
      $this->redirect("@non_autorise");
    }

    $this->objForm = new Statut_dossier_mipForm($objStatut);

    if ($request->isMethod('post')) {
      $this->processForm('modifier', 'listerStatut_Dossier_mips');
    }
  }

  public function  postExecute()
  {
  }
}
