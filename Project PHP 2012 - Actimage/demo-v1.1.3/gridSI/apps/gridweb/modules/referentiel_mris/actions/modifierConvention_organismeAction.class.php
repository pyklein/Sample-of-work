<?php

/**
 * Description of modifierConvention_organismeAction
 *
 * @author Simeon Petev
 */
class modifierConvention_organismeAction extends gridAction
{
  public function  preExecute()
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    $intIdConvention = $this->getRequest()->getParameter('id');

    $this->objConventionOrganisme = Convention_organismeTable::getInstance()->findOneById(($intIdConvention) ? $intIdConvention : 0);

    if ((!$intIdConvention) || (!$this->objConventionOrganisme) || ($this->objConventionOrganisme->getId() == 0))
    {
      $this->getUser()->setFlash('erreur', libelle('msg_convention_droit'));

      $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN AVANT REDIRECT; ");

      $this->redirect(url_for('referentiel_mris/listerConvention_organismes'));
    }

    parent::preExecute();

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }

  public function  execute($request)
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    $this->objConventionOrganisme->setUtilisateurUpdatedBy($this->getUser()->getUtilisateur());

    $this->objForm = new Convention_organismeForm($this->objConventionOrganisme);

    if ($this->getRequest()->isMethod('post'))
    {
      $this->arrFiles = $this->getRequest()->getFiles($this->objForm->getName());

      $this->processForm('modifier');
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
