<?php

/**
 * Ajout d'un nouveau dossier de stage postdoctoral
 *
 * @author Jihad
 */
class creerDossier_postdocAction extends gridAction {

  public function execute($request) {

    $objDossierPostdoc = new Dossier_postdoc();
    

    //on recherche le statut "proposition" dans la table "statut_dossier_postdoc"
    $objStatutDossierPostdoc = Statut_dossier_postdocTable::getInstance()->findOneByIntitule("Proposition");
    // on ajoute l'id du statut dans le dossier de stage postdoc
    $objDossierPostdoc->setStatutDossierPostdocId($objStatutDossierPostdoc->getId());

    //set du numéro
    $objDossierPostdoc->setNumeroDefinitif('Num_dossier');

    $this->objForm = new Dossier_postdocForm($objDossierPostdoc);
    $this->arrFiles = $request->getFiles($this->objForm->getName());
    
    if ($request->isMethod('post'))
    {
      //on récupère les fichiers joints
      $this->arrFiles = $request->getFiles($this->objForm->getName());

      //fichier PDF
      $file_pdf = $this->arrFiles['fichier_pdf'];
      $objDossierPostdoc->setFichierPdfOrig($file_pdf['name']);
      
      
      //fichier editable
      $file_editable= $this->arrFiles['fichier_editable'];
      $objDossierPostdoc->setFichierEditableOrig($file_editable['name']);

      //on lance le form
      $this->processForm('creer','',false);
      $utilFichier = new UtilFichier();
      $serviceArbo = new ServiceArborescence();
      try {
        $utilFichier->isExiste($serviceArbo->getRepertoirePartageDocumentsPostdoc($objDossierPostdoc->getRepertoirePartage()));
      } catch (Exception $e){
        $this->getUser()->setFlash('warning', libelle("msg_erreur_creation_dossier_partage"));
      }
      $this->redirect("dossier_mris/listerDossier_postdocs");
    }
  }
  
}
?>
