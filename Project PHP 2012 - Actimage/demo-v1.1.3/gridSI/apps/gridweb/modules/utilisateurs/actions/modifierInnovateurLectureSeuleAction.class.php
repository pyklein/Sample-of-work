<?php

/**
 * Action pour la vue d'un innovateur pour les utilisateurs MIP (hors Super utilisateur MIP)
 *
 * @author Alexandre WETTA
 */
class modifierInnovateurLectureSeuleAction extends gridAction {

  public function preExecute() {
    if (!$this->request->hasParameter('id')) {
      $this->getUser()->setFlash("erreur", libelle("msg_utilisateur_droit_modifier"));
      $this->redirect(url_for("utilisateurs/rechercherInnovateurs"));
    }
  }

  public function execute($request) {

    $userId = $request->getParameter('id');
    $boolEstClientMip = false;

    $objInnovateur = UtilisateurTable::getInstance()->findOneById($userId);

    //on vérifie que l'utilisateur qu'on affiche a bien un profil 'client MIP'
    $arrProfilUtilisateur = Utilisateur_profilTable::getInstance()->findByUtilisateurId($userId);
    foreach($arrProfilUtilisateur as $profil){
      if($profil->getProfilId() == ProfilTable::CLI_MIP) {
        $boolEstClientMip = true;
      }
      
    }

    if($objInnovateur && $boolEstClientMip ){
      $this->objForm = new GestionUtilisateurProfilForm('innovateurLectureSeule', $objInnovateur);
    }else{
      $this->getUser()->setFlash("erreur", libelle("msg_utilisateur_droit_modifier"));
      $this->redirect(url_for("utilisateurs/rechercherInnovateurs"));
    }
    
  }

}
?>
