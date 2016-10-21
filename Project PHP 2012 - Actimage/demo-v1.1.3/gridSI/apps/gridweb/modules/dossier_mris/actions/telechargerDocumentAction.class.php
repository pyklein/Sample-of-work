<?php

/**
 * Action de téléchargement pour les dossier mris (référencés et joints, tous types)
 *
 * @author William
 */
class telechargerDocumentAction extends gridAction {

  public function execute($objRequeteWeb) {
    $logger = $this->getLogger();

    //Verification de la validité de la requête
    if (!$objRequeteWeb->hasParameter('id')) {
      $this->redirect('@non_autorise');
    }
    $objDocument = Document_mrisTable::getInstance()->findOneById($objRequeteWeb->getParameter('id'));
    if (!$objDocument) {
      $this->redirect('@non_autorise');
    }
    $this->strModelContenant = 'Dossier_' . $objDocument->getTypeDossier();
    $this->strIdContenant = $objDocument[$this->strModelContenant]->getId();
    $this->objContenant = Doctrine_Core::getTable($this->strModelContenant)->findOneById($this->strIdContenant);
    if (!$this->objContenant) {
      $this->redirect("@non_autorise");
    }
    $objUtilArbo = new ServiceArborescence();
    $strMethodeArbo = "getRepertoireDocumentsDossier" . ucfirst($objDocument->getTypeDossier());

    
    //redirection vers le service de téléchargement avec les paramètres apropriés
    $this->numDossier = str_replace('/', '_', $this->objContenant->getNumeroAAfficher());
    if ($objDocument->getEstJoint()){
      $strRedirectionTelechargement = "interface/telechargerDocument?path=" . bin2hex($objUtilArbo->$strMethodeArbo($this->objContenant->getNumeroAAfficher())) . "&fichier=" . $objDocument->getFichier() . "&fichier_orig=" . $objDocument->getFichierOrig();
      $logger->debug("{telechargerDocumentAction} redirection vers service de téléchargement fichier joint: ". $strRedirectionTelechargement);
      $this->redirect($strRedirectionTelechargement);
    } else {
      $strRedirectionTelechargement = "interface/telechargerDocumentReference?fichier=".$objDocument->getFichier().
              "&fichier_orig=".$objDocument->getFichier()."&numDossier=".$this->objContenant->getRepertoirePartage() ."&type=".$objDocument->getTypeDossier();
      $logger->debug("{telechargerDocumentAction} redirection vers service de téléchargement fichier référencé: ". $strRedirectionTelechargement);
      
      $this->redirect($strRedirectionTelechargement);
    }

  }

}

?>
