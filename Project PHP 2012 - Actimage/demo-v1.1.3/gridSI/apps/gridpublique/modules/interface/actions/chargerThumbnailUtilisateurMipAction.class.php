<?php

sfContext::getInstance()->getConfiguration()->loadHelpers("Url");

/**
 * Chargement des images par les utilisateurs MIP
 *
 * @author Actimage
 */
class chargerThumbnailUtilisateurMipAction extends gridAction {

  public function preExecute() {
    if (!$this->request->hasParameter('fichier') || !$this->request->hasParameter('modele') ) {
      $this->getUser()->setFlash("erreur", libelle("msg_utilisateur_droit_photo"));
      $this->redirect(url_for("interface/listerDossier_mip_publiques"));
    }
  }

  public function execute($request) {
    if (sfContext::hasInstance()) {
      sfContext::getInstance()->getLogger()->debug('chargerThumbnailUtilisateurMipAction->execute() Start');
    }

    $strModele = $request->getParameter('modele');

    $strThumbPath = "";

    //on crée le nom du fichier thumbnail
    $strFichier = $request->getParameter('fichier');
    $utilFichier = new UtilFichier();
    $arrThumbs = sfConfig::get("app_photos_thumbnails");
    $strFichier = $utilFichier->getFilename($strFichier) . "." . $arrThumbs['postfix'] . "." . $utilFichier->getExtension($strFichier);

    if (sfContext::hasInstance()) {
      sfContext::getInstance()->getLogger()->debug('chargerThumbnailUtilisateurMipAction->execute() End');
    }

    //On demande le fichier
    $this->redirect(url_for("interface/telechargerPhoto?fichier=" . $strFichier . "&modele=".$strModele));
    exit;
  }

}
?>
