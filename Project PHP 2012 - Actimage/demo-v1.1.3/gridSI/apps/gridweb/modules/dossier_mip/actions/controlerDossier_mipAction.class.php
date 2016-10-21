<?php


/**
 * Contrôle pour un dossier mip
 */
class controlerDossier_mipAction extends gridAction {

  public function execute($objRequeteWeb) {
 
    //On redirige si on a pas le bon parametre
    if (!$objRequeteWeb->hasParameter('id')) {
      $this->redirect('@non_autorise');
    }
    $this->intIdDossierMip = $objRequeteWeb->getParameter('id');
    $this->objDossier = Dossier_mipTable::getInstance()->findOneById($this->intIdDossierMip);

    //redirection si dossier mip inexistant
    if (!$this->objDossier)
    {
      $this->redirect('@non_autorise');
    } 

    $factory = new ValidateurRegleMetierFactory();
    $this->arrErreurs = $factory->getValidateurMetier($this->objDossier)->getStatutValidation();

  }

}

?>
