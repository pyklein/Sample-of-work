<?php

/**
 * Description of telechargerConvention_organismeAction
 *
 * @author Simeon Petev
 */
class telechargerConvention_organismeAction extends gridAction
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

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");
  }

  public function  execute($request)
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    $objUtilTelecharcher = new UtilTelecharger();
    $objUtilArbo = new ServiceArborescence();
    $objUtilTelecharcher->telechargerFichier($objUtilArbo->getRepertoireConventionsOrganismes().$this->objConventionOrganisme->getFichier(),$this->objConventionOrganisme->getFichierOrig(),true);

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
