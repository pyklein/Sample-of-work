<?php

/**
 * Action pour l'édition du profil de l'utilisateur connecté
 *
 * @author Alexandre WETTA
 */
class editerProfilAction extends gridAction {

  public function preExecute() {

  }

  public function execute($request) {


    $this->userId = $this->getUser()->getUtilisateur()->getId();

    $this->objUser = UtilisateurTable::getInstance()->findOneById($this->userId);

    if ($this->objUser) {

      $this->objForm = new GestionUtilisateurProfilForm(null, $this->objUser);

      $this->arrFiles = array();

      //POST du formulaire
      if ($request->isMethod('post')) {

        //on récupère les fichiers joints
        $this->arrFiles = $request->getFiles('utilisateur');

        //on vérifie que le processForm a bien fonctionné et on crée ensuite la miniature
        $this->processForm('modifier', "editerProfil");

      }
    } else {
      $this->redirect('@non_autorise');
    }
  }

}
?>
