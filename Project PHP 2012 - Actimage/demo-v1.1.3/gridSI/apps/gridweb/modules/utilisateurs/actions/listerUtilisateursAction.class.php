<?php

/**
 * utilisateurs actions.
 *
 * @package    gridSI
 * @subpackage utilisateurs
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class listerUtilisateursAction extends gridAction
{

  public function  preExecute()
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    parent::preExecute();

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }

  /**
   * Surcharge la methode parent pour personnaliser le contenue
   *
   * @param <type> $request
   *
   * @author Simeon PETEV
   */
  public function execute($request)
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    $this->objMyUser = $this->getUser();

    $this->objFiltre = new UtilisateurFormFilter();

    if($request->isMethod('post')) {
      if (!$this->getRequest()->hasParameter('reset')){
        $this->objFiltre->bind($request->getParameter($this->objFiltre->getName()));
        $this->getUser()->setAttribute('filtre_utilisateurs', ($request->getParameter($this->objFiltre->getName())));
      } else
      {
        $this->getUser()->offsetUnset('filtre_utilisateurs');
      }
    }
    else if (($request->isMethod('get')) && ($this->getUser()->hasAttribute('filtre_utilisateurs')))
    {
      $arrParameters = $this->getUser()->getAttribute('filtre_utilisateurs');
      $this->objFiltre->bind($arrParameters);
    }
    
    $objQueryUtilisateurs = UtilisateurTable::getInstance()->getQueryUtilisateursAvecFiltre($this->objFiltre);
    
    if ($objQueryUtilisateurs)
    {
      $this->intNombreResUtilisateur = UtilisateurTable::getInstance()->getNombreResultatUtilisateurs($objQueryUtilisateurs);
      $this->utilisateurs = UtilisateurTable::getInstance()->getUtilisateursAvecQuery($objQueryUtilisateurs);
    }
    else
    {
      $this->intNombreResUtilisateur = 0;
      $this->utilisateurs = array();
    }

    $this->processPager($objQueryUtilisateurs, 'Utilisateur');

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
