<?php

/**
 * Description of creerStatut_Dossier_mipPopupAction
 *
 * @author Simeon Petev
 */
class creerStatut_Dossier_mipPopupAction extends gridAction
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
