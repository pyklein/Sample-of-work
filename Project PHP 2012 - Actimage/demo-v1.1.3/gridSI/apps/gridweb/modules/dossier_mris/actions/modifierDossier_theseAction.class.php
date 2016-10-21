<?php

/**
 * Modification d'un dossier de thèse
 *
 * @author Alexandre WETTA
 */
class modifierDossier_theseAction extends gridAction {

   public function execute($request)
   {

     //on verifie qu'il y a bien un ID dans l'URL
    if (!$request->hasParameter('id')) {
      $this->redirect("@non_autorise");
    }

      $this->strId = $request->getParameter('id');
      
      if($this->strId != NULL) {
      $objDossierThese = Dossier_theseTable::getInstance()->findOneById($request->getParameter('id')); 
      $this->objDossier = $objDossierThese;
      }

      // si l'id du dossier de thèse n'existe pas, on redirige
      if($objDossierThese == null){
        $this->redirect("@non_autorise");
      }


      $this->objForm = new Dossier_theseForm($objDossierThese);

      $this->arrFiles = $request->getFiles("dossier_these");

      if ($request->isMethod('post')) {


            //on récupère les fichiers joints
      $this->arrFiles = $request->getFiles('dossier_these');

//      //fichier PDF
      $file_pdf = $this->arrFiles['fichier_pdf'];
      if($file_pdf['name']!= "") $objDossierThese->setFichierPdfOrig($file_pdf['name']);
//
//      //fichier editable
      $file_editable= $this->arrFiles['fichier_editable'];
      if($file_editable['name'] != "") $objDossierThese->setFichierEditableOrig($file_editable['name']);

      $retourForm = $this->processForm('modifier',null,false);

      //on redirige sur la même page le form lorsqu'il est bon pour mettre à jour les données (ex:les fichiers joints)
      if($retourForm) $this->redirect(url_for('dossier_mris/modifierDossier_these?id='.$this->strId));
        }
    }
    
}
?>
