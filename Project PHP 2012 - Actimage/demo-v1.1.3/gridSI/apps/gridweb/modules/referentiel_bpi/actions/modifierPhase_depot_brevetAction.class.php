<?php

sfContext::getInstance()->getConfiguration()->loadHelpers("Libelle");

/**
 * Description of modifierPhase_depot_brevetAction
 *
 * @author Simeon Petev
 */
class modifierPhase_depot_brevetAction extends gridAction
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

    $objPhase = Phase_depot_brevetTable::getInstance()->findOneById($request->getParameter('id'));

    $this->objForm = new Phase_depot_brevetForm($objPhase);

    if ($request->isMethod('post')) {
      $this->processForm('modifier');
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
