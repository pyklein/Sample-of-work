<?php

/**
 * Gestion des libellés des organismes
 *
 * @author Alexandre WETTA
 */
class modifierLibelleOrganismeAction extends gridAction {

  public function preExecute() {
    if (!$this->getRequest()->hasParameter('Organisme_mindef')) {
      $this->getUser()->setFlash('warning', libelle('msg_credentials_acces_non_autorise'));
      $this->redirect('referentiel/listerOrganisme_mindefs');
    }
  }

  public function execute($request) {


    //on cherche le metier de l'utilisateur
    $objMetier = $this->getUser()->getUtilisateur()->getProfil()->getMetier();

    //on cherche les libellés en fonction du metier et de l'organisme
    $queryLibelle = Libelle_organismeTable::getInstance()->retrieveLibelleByMetier($request->getParameter('Organisme_mindef'), $objMetier->getId());

    //on regarde si on a trouvé un objet sinon on en crée un nouveau
    if ($queryLibelle->count() > 0) {
      $arrLibelle = $queryLibelle->execute();
      $objLibelle = $arrLibelle[0];

      $this->objForm = new Libelle_organismeForm($objLibelle);
    } else {

      $objLibelle = new Libelle_organisme();
      $objLibelle->setMetier($objMetier);
      $objLibelle->setOrganismeMindefId($request->getParameter('Organisme_mindef'));

      $this->objForm = new Libelle_organismeForm($objLibelle);
    }

    //POST du formulaire
    if ($request->isMethod('post')) {
      $this->processForm('modifier', 'listerOrganisme_mindefs');
    }

  }

}
?>
