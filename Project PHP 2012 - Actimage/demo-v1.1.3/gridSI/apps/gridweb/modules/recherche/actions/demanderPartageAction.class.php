<?php

sfContext::getInstance()->getConfiguration()->loadHelpers(array("Partial"));

/**
 * Description of demanderPartageAction
 *
 * @author William
 */
class demanderPartageAction extends gridAction {

  public function preExecute() {
    if (!$this->getRequest()->hasParameter('id')) {
      $this->redirect('@non_autorise');
    }
  }

  public function execute($request) {
    $id = $request->getParameter('id');
    $this->objDossierVue = View_rechercheTable::getInstance()->findOneById($id);
    if (!$this->objDossierVue) {
      $this->redirect('@non_autorise');
    }
    $this->objDossier = $this->objDossierVue->getDossier();

    if (!(is_a($this->objDossier,'Dossier_mip') || is_a($this->objDossier, 'Dossier_bpi'))){
      $this->redirect('@non_autorise');
    }

    $this->objForm = new Demande_partageForm(get_class($this->objDossier));

    if ($request->isMethod('post')) {
      if ($this->processDemande()) {
        $arrObjetsContenuDansMail = array(
            'utilisateur' => $this->getUser()->getUtilisateur(),
            'dossier' => $this->objDossier,
            'commentaire' => html_entity_decode($this->objForm->getValue('commentaire')));

        if (isset($this->objForm['dossier_lie'])) {
          $schema = $this->objForm->getWidgetSchema();
          $arrObjetsContenuDansMail['dossier_lie'] = Doctrine_Core::getTable($schema['dossier_lie']->getOption('model'))
                          ->findOneById($this->objForm->getValue('dossier_lie'));
        }

        $gestionnaireMail = new GestionnaireMail();
        foreach (UtilisateurTable::getInstance()->retrieveSuperUtilisateursByMetierId($this->objDossierVue->getMetierId()) as $objSuperUtilisateur) {
          $strContenuMail = get_partial('email/contenuMailDemandePartage', $arrObjetsContenuDansMail);
          $gestionnaireMail->envoyerMailDemandePartage($objSuperUtilisateur, $strContenuMail, $this->getUser()->getUtilisateur());
        }
        if ($this->objDossierVue->getDossierMipId() && $this->objDossier->getPilote() != null) {
          $strContenuMail = get_partial('email/contenuMailDemandePartage', $arrObjetsContenuDansMail);
          $gestionnaireMail->envoyerMailDemandePartage($this->objDossier->getPilote(), $strContenuMail, $this->getUser()->getUtilisateur());
        }

        $this->redirect("recherche/listerView_recherches");
      }
    }
  }

  public function processDemande() {
    $objForm = $this->objForm;
    $logger = $this->getLogger();
    $request = $this->getRequest();
    $objForm->bind($request->getParameter($objForm->getName()));

    $logger->debug("{demanderPartageAction} processDemande début");

    if ($objForm->isValid()) {
      $this->getUser()->setFlash("succes", libelle("msg_recherche_demande_succes"));
      $logger->debug("{demanderPartageAction} processDemande réussi");
      return true;
    } else {
      $logger->debug("{demanderPartageAction} processDemande invalide");
      $this->getUser()->setFlash("erreur", libelle("msg_recherche_demande_invalide"));
      return false;
    }
  }

}

?>
