<?php


/**
 * Affichage des alertes pour un dossier bpi
 * @author Gabor JAGER
 */
class alertesDossier_bpiAction extends gridAction
{
  public function execute($objRequeteWeb)
  {
    // On redirige si on n'a pas le bon parametre
    if (!$objRequeteWeb->hasParameter('id'))
    {
      $this->redirect('@non_autorise');
    }

    $this->intIdDossierBpi = $objRequeteWeb->getParameter('id');
    $this->objDossier = Dossier_bpiTable::getInstance()->findOneById($this->intIdDossierBpi);

    // redirection si dossier bpi inexistant
    if (!$this->objDossier)
    {
      $this->redirect('@non_autorise');
    } 

    $factory = new ValidateurRegleMetierFactory();
    $this->arrErreurs = $factory->getValidateurMetier($this->objDossier)->getStatutValidation();
  }
}
