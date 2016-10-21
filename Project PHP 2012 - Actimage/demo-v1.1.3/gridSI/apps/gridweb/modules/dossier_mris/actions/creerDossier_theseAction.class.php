<?php

/**
 * Ajout d'un nouveau dossier de thèse
 *
 * @author Actimage
 */
class creerDossier_theseAction extends gridAction {

  public function execute($request) {

    $objDossier_these = new Dossier_these();

    //on recherche le statut "proposition" dans la table "statut_dossier_these"
    $objStatutDossierThese = Statut_dossier_theseTable::getInstance()->findOneByIntitule("Proposition");
    // on ajoute l'id du statut dans le dossier de thèse
    $objDossier_these->setStatutDossierTheseId($objStatutDossierThese->getId());


    $this->objForm = new Dossier_theseForm($objDossier_these);
    if ($request->isMethod('post')) {

      //on récupère les fichiers joints
      $this->arrFiles = $request->getFiles('dossier_these');

      //fichier PDF
      $file_pdf = $this->arrFiles['fichier_pdf'];
      $objDossier_these->setFichierPdfOrig($file_pdf['name']);
      
      
      //fichier editable
      $file_editable= $this->arrFiles['fichier_editable'];
      $objDossier_these->setFichierEditableOrig($file_editable['name']);

      //on lance le form
      $this->processForm('creer','',false);
      $utilFichier = new UtilFichier();
      $serviceArbo = new ServiceArborescence();
      try {
        $utilFichier->isExiste($serviceArbo->getRepertoirePartageDocumentsThese($objDossier_these->getRepertoirePartage()));
      } catch (Exception $e){
        $this->getUser()->setFlash('warning', libelle("msg_erreur_creation_dossier_partage"));
      }
      $this->redirect("dossier_mris/listerDossier_theses");
    }
  }
  
}
?>
