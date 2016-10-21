<?php

/**
 * Description of modifierAboutissement_Dossier_theseAction
 *
 * @author Simeon Petev
 */
class modifierAboutissement_Dossier_theseAction extends gridAction
{
  public function  preExecute()
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    $idDossier = $this->getRequest()->getParameter('dossier_these_id');

    $this->objDossier = Dossier_theseTable::getInstance()->findOneById(($idDossier) ? $idDossier : 0);

    if (($this->objDossier == null) || ($this->objDossier->getId()==0))
    {
      if ($idDossier != null)
      {
        $this->getUser()->setFlash("erreur", libelle('msg_dossier_these_droit_aboutissement'));
      }

      $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN AVANT REDIRECTION; ");

      $this->redirect(url_for('dossier_mris/listerDossier_theses'));
    }

    parent::preExecute();

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }

  public function  execute($request)
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    $objAboutissement = $this->objDossier->getAboutissementThese();


    $this->objForm = new Aboutissement_theseForm($objAboutissement);

    if ($request->isMethod('post'))
    {
      $this->processForm('modifier', "", false);
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
