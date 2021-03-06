<?php

sfContext::getInstance()->getConfiguration()->loadHelpers("Libelle");

/**
 * Description of creerStatut_Dossier_bpiAction
 *
 * @author Simeon Petev
 */
class creerStatut_Dossier_bpiAction extends gridAction
{
  public function  preExecute()
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    parent::preExecute();

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }

  public function execute($request)
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    $objStatut = new Statut_dossier_bpi();

    $this->objForm = new Statut_dossier_bpiForm($objStatut);
    if($request->isMethod('post'))
    {
      $this->processForm('creer', 'listerStatut_Dossier_bpis');
    }

    //Jamais atteint
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }

  public function  postExecute()
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    parent::postExecute();

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }
}
?>
