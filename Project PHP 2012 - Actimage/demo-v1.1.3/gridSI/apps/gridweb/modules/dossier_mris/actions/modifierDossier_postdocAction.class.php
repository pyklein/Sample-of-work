<?php

/**
 * Modification d'un dossier postdoctoral
 *
 * @author Jihad
 */
class modifierDossier_postdocAction extends gridAction {

  public function execute($request)
  {
    $this->strId = $request->getParameter('id');

    if($request->hasParameter('id'))
    {
      $objDossierPostdoc = Dossier_postdocTable::getInstance()->findOneById($request->getParameter('id'));
      $this->objDossier = $objDossierPostdoc;
    }

    // si l'id du dossier de thèse n'existe pas, on redirige
    if($objDossierPostdoc == null){
      $this->redirect("@non_autorise");
    }


    $this->objForm = new Dossier_postdocForm($objDossierPostdoc);
    $this->arrFiles = $request->getFiles($this->objForm->getName());
    if ($request->isMethod('post'))
    {
      $this->arrFiles = $request->getFiles($this->objForm->getName());

      //fichier pdf
      $file_pdf = $this->arrFiles['fichier_pdf'];
      if($file_pdf['name']!= "") $objDossierPostdoc->setFichierPdfOrig($file_pdf['name']);

      
      //fichier editable
      $file_editable= $this->arrFiles['fichier_editable'];
      if($file_editable['name'] != "") $objDossierPostdoc->setFichierEditableOrig($file_editable['name']);

      $retourForm = $this->processForm('modifier',null,false);

      //on redirige uniquement si le formulaire est valide
      if($retourForm) $this->redirect(url_for('dossier_mris/modifierDossier_postdoc?id='.$this->strId));

    }
    
  }
    
}