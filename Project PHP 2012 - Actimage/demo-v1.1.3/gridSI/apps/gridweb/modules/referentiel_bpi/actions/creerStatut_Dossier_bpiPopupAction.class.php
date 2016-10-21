<?php

/**
 * Popuo creation statut dossier BPI
 *
 * @author Jihad
 */
class creerStatut_Dossier_bpiPopupAction extends gridAction
{
  public function  preExecute()
  {
  }

  public function execute($request)
  {
    $objStatut = new Statut_dossier_bpi();
    //On affecte à created_by et à updated_by, l'id de l'utilisateur connecté

    $this->objForm = new Statut_dossier_bpiForm($objStatut);
    if($request->isMethod('post'))
    {
      if ($this->getRequest()->isXmlHttpRequest()) {
        $boolResultat = $this->processForm('creer', null, false, false);

        if ($boolResultat)
        {
          $arrRetour = array();
          $arrRetour["select"] = array("valeur" => $objStatut->getId(), "libelle" => $objStatut->getIntitule());

          $this->getResponse()->setHttpHeader('Content-Type','application/json');
          return $this->renderText(json_encode($arrRetour));
        }
      } else {
        $this->processForm('creer');
      }
    }
  }

  public function  postExecute()
  {
  }
}
?>
