<?php

/**
 * Popup creation Organisme
 *
 * @author Jihad
 */
class creerOrganismePopupAction extends gridAction
{
  public function execute($request)
  {
    $objOrganisme = new Organisme();

    $this->objForm = new OrganismeForm(true,$objOrganisme);

    if ($request->isMethod('post'))
    {
      if ($this->getRequest()->isXmlHttpRequest())
      {
        $boolResultat = $this->processForm('creer', null, false, false);
        if ($boolResultat)
        {
          $arrRetour = array();
          $arrRetour["select"] = array("valeur" => $objOrganisme->getId(), "libelle" => $objOrganisme->getIntitule());

          $this->getResponse()->setHttpHeader('Content-Type','application/json');
          return $this->renderText(json_encode($arrRetour));
        }
      } else {
        $this->processForm('creer');
      }
    }
  }
}
?>
