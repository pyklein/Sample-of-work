<?php

/**
 * Téléchargement d'un modèle de lettre
 * @author Gabor JAGER
 */
class chargerModeleLettreAction extends gridAction
{
  public function preExecute()
  {
    if (!$this->request->hasParameter('cle'))
    {
      $this->redirect('interface/fichierIntrouvable');
    }
  }
  
  public function execute($request)
  {
    if (sfContext::hasInstance())
    {
      sfContext::getInstance()->getLogger()->debug(__CLASS__."->".__FUNCTION__."() Start");
    }

    $objModeleLettre = Modele_lettreTable::getInstance()->getModeleLettreParCle($request->getParameter("cle"));

    if (!$objModeleLettre)
    {
      $this->redirect('interface/fichierIntrouvable');
    }

    $this->redirect("interface/telechargerDocument?type=modele&fichier=".$objModeleLettre->getFichier()."&fichier_orig=".$objModeleLettre->getFichierOrig());
  }
}
