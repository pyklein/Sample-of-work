<?php

/**
 * Telechargement des documents référencés
 * @author Gabor JAGER, Jihad Sahebdin
 */
class telechargerDocumentReferenceAction extends sfAction
{

  public function execute($request) {
    if ($request->hasParameter('fichier') && $request->hasParameter('fichier_orig') && $request->hasParameter('numDossier') && $request->hasParameter('type')) {

      $objUtilArbo = new ServiceArborescence();
      $strMethodeArbo = "getRepertoirePartageDocuments".ucfirst($request->getParameter('type'));
      
      $strCheminBase = $objUtilArbo->$strMethodeArbo($request->getParameter("numDossier"));
      $this->strFichier = "file:///".$strCheminBase.$request->getParameter('fichier');
    } else {
      $this->redirect('interface/fichierIntrouvable');
    }
  }
}

