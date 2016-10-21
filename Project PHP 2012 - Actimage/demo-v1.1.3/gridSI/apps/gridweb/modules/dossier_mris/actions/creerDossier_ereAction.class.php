<?php

/**
 * Ajout d'un nouveau dossier de stage ere
 *
 * @author Jihad
 */
class creerDossier_ereAction extends gridAction {

  public function execute($request) {

    $objDossierEre = new Dossier_ere();

    //on recherche le statut "proposition" dans la table "statut_dossier_ere"
    $objStatutDossierEre = Statut_dossier_ereTable::getInstance()->findOneByIntitule("Proposition");
    // on ajoute l'id du statut dans le dossier de stage ere
    $objDossierEre->setStatutDossierEreId($objStatutDossierEre->getId());

    //set du numéro
    $objDossierEre->setNumeroDefinitif('Num_dossier');


    $this->objForm = new Dossier_ereForm($objDossierEre);
    $this->arrFiles = $request->getFiles($this->objForm->getName());
    
    if ($request->isMethod('post'))
    {
      //on récupère les fichiers joints
      $this->arrFiles = $request->getFiles($this->objForm->getName());

      //fichier PDF
      $file_pdf = $this->arrFiles['fichier_pdf'];
      $objDossierEre->setFichierPdfOrig($file_pdf['name']);
      
      
      //fichier editable
      $file_editable= $this->arrFiles['fichier_editable'];
      $objDossierEre->setFichierEditableOrig($file_editable['name']);

      //on lance le form
      $this->processForm('creer','',false);

      $utilFichier = new UtilFichier();
      $serviceArbo = new ServiceArborescence();
      try {
        $utilFichier->isExiste($serviceArbo->getRepertoirePartageDocumentsEre($objDossierEre->getRepertoirePartage()));
      } catch (Exception $e){
        $this->getUser()->setFlash('warning', libelle("msg_erreur_creation_dossier_partage"));
      }
      $this->redirect("dossier_mris/listerDossier_eres");
    }
  }
  
}
?>
