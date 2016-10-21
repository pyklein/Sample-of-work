<?php
sfContext::getInstance()->getConfiguration()->loadHelpers("Libelle");
/**
 * Ajouter une notification

 * @author     Jihad Sahebdin
 */
class creerStatut_Dossier_mipAction extends gridAction
{
  public function  preExecute()
  {
  }

  public function execute($request)
  {
    $objStatut = new Statut_dossier_mip();

    $this->objForm = new Statut_dossier_mipForm($objStatut);
    if($request->isMethod('post'))
    {
      $this->processForm('creer', 'listerStatut_Dossier_mips');
    }
  }

  public function  postExecute()
  {
  }
  
}
