<?php

/**
 * Modification d'un dossier ERE
 *
 * @author Jihad
 */
class modifierDossier_ereAction extends gridAction {

  public function execute($request)
  {
    $this->strId = $request->getParameter('id');

    if (!$request->hasParameter('id')){
     $this->redirect('@non_autorise');
    }
   
    $objDossierEre = Dossier_ereTable::getInstance()->findOneById($request->getParameter('id'));
    $this->objDossier = $objDossierEre;

    // si l'id du dossier de thèse n'existe pas, on redirige
    if($objDossierEre == null){
      $this->redirect("@non_autorise");
    }


    $this->objForm = new Dossier_ereForm($objDossierEre);
    $this->arrFiles = $request->getFiles($this->objForm->getName());
    if ($request->isMethod('post'))
    {
      $this->arrFiles = $request->getFiles($this->objForm->getName());

      //fichier pdf
      $file_pdf = $this->arrFiles['fichier_pdf'];
      if($file_pdf['name']!= "") $objDossierEre->setFichierPdfOrig($file_pdf['name']);

      
      //fichier editable
      $file_editable= $this->arrFiles['fichier_editable'];
      if($file_editable['name'] != "") $objDossierEre->setFichierEditableOrig($file_editable['name']);

      $retourForm = $this->processForm('modifier',null,false);

      //On redirige uniquement si le formulaire est valide
      if($retourForm) $this->redirect(url_for('dossier_mris/modifierDossier_ere?id='.$this->strId));

    }
    
  }
    
}