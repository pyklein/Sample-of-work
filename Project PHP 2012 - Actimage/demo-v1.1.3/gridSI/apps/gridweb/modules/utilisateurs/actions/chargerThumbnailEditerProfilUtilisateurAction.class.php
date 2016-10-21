<?php

/**
 * Chargement de la miniature lors de l'affichage de "editer mon profil"
 *
 * @author Actimage
 */
class chargerThumbnailEditerProfilUtilisateurAction extends gridAction {

  public function preExecute() {

    //on vérifie qu'il y a un parametre "id" et que l'id de l'utilisateur connecté soit le même que l'id demandé
    if (!$this->getRequest()->hasParameter('id')) {
      $this->redirect('@non_autorise');
    }else if ($this->getUser()->getUtilisateur()->getId() != $this->request->getParameter('id')) {
      $this->redirect('@non_autorise');
    }

  }

  public function execute($request) {
    if (sfContext::hasInstance()) {
      sfContext::getInstance()->getLogger()->debug('chargerThumbnailEditerProfilUtilisateurAction->execute() Start');
    }
    $this->chargerThumbnail($request->getParameter("path"),$request->getParameter("fichier"));
  }

}
?>
