<?php

/**
 * Description of creerConvention_organismeAction
 *
 * @author Simeon Petev
 */
class creerConvention_organismeAction extends gridAction
{
  public function  preExecute()
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    parent::preExecute();

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }

  public function  execute($request)
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    $objNouvelleConvention = new Convention_organisme();

    $objNouvelleConvention->setUtilisateurCreatedBy($this->getUser()->getUtilisateur());
    $objNouvelleConvention->setUtilisateurUpdatedBy($this->getUser()->getUtilisateur());

    $this->objForm = new Convention_organismeForm($objNouvelleConvention);

    if ($this->getRequest()->isMethod('post'))
    {
      $this->arrFiles = $this->getRequest()->getFiles($this->objForm->getName());

      $this->processForm('creer');
    }

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");
  }

  public function  postExecute()
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    parent::postExecute();

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }
}
?>
