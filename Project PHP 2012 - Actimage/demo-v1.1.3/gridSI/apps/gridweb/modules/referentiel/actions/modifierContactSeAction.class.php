<?php

/**
 * Description of modifierContactSeAction
 *
 * @author Simeon Petev
 */
class modifierContactSeAction extends gridAction
{
  public function  preExecute()
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    $idContactSe = $this->getRequest()->getParameter('contact_se_id');

    $this->objContactSe = Contact_seTable::getInstance()->findOneById(($idContactSe) ? $idContactSe : 0);

    if (($this->objContactSe == null) || 
        ($this->objContactSe->getId()==0) ||
        (!$this->getUser()->getUtilisateur()->peutGererContactSe($this->objContactSe)))
    {
      $this->getUser()->setFlash("erreur", libelle('msg_contact_se_droit'));

      $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN AVANT REDIRECTION; ");

      $this->redirect(url_for('referentiel/listerContactSes'));
    }

    parent::preExecute();

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }

  public function execute($request)
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");
    
    $this->objContactSe->setUtilisateurUpdatedBy($this->getUser()->getUtilisateur());

    $this->objForm = new Contact_seForm($this->objContactSe);
    
    // on recharge le formulaire avec les villes (version sans Javascript)
    if ($request->isMethod('post') && $request->hasParameter("chargerVilles"))
    {
      $this->objForm->bind($request->getParameter($this->objForm->getName()));
    }

    // submit de formulaire
    else if ($this->getRequest()->isMethod('post'))
    {
      $this->processForm('modifier','listerContactSes');
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
