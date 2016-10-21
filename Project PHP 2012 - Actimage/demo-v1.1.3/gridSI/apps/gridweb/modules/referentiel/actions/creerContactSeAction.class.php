<?php


/**
 * Description of creerContactSeAction
 *
 * @author Simeon Petev
 */
class creerContactSeAction extends gridAction
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

    $objMetierSeperUser = null;

    if ($this->getUser()->getUtilisateur()->hasProfil(ProfilTable::SUP_MIP))
    {
      $objMetierSeperUser = MetierTable::getInstance()->findOneByIntitule(MetierTable::MIP);
    } else if ($this->getUser()->getUtilisateur()->hasProfil(ProfilTable::SUP_MRIS))
    {
      $objMetierSeperUser = MetierTable::getInstance()->findOneByIntitule(MetierTable::MRIS);
    } else if ($this->getUser()->getUtilisateur()->hasProfil(ProfilTable::SUP_BPI))
    {
      $objMetierSeperUser = MetierTable::getInstance()->findOneByIntitule(MetierTable::BPI);
    }

    $objContactSe = new Contact_se();
    $objContactSe->setMetier($objMetierSeperUser);
    $objContactSe->setUtilisateurCreatedBy($this->getUser()->getUtilisateur());
    $objContactSe->setUtilisateurUpdatedBy($this->getUser()->getUtilisateur());

    $this->objForm = new Contact_seForm($objContactSe);

    // on recharge le formulaire avec les villes (version sans Javascript)
    if ($request->isMethod('post') && $request->hasParameter("chargerVilles"))
    {
      $this->objForm->bind($request->getParameter($this->objForm->getName()));
    }

    // submit de formulaire
    else if ($this->getRequest()->isMethod('post'))
    {
      $this->processForm('creer','listerContactSes');
    }

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
