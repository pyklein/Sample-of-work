<?php

/**
 * Chargement de la miniature pour les user avec un profil MIP
 *
 * @author Alexandre WETTA
 */
class chargerThumbnailProfilMipAction extends gridAction {

  public function preExecute() {
  }

  public function execute($request) {
    if (sfContext::hasInstance()) {
      sfContext::getInstance()->getLogger()->debug('chargerThumbnailProfilMipAction->execute() Start');
    }

    $this->chargerThumbnail($request->getParameter("path"), $request->getParameter("fichier"));
    exit;
  }

}
?>
