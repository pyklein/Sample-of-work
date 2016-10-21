<?php

/**
 * Telechargement
 * @author Gabor JAGER
 */
class telechargerDocumentAction extends sfAction {

  public function execute($request) {
    if ($request->hasParameter('path') && $request->hasParameter('fichier')) {
      $strFichier = pack("H*" ,$request->getParameter('path')) . $request->getParameter('fichier');
    } else if (!($request->hasParameter('type') && $request->hasParameter('fichier') && $request->hasParameter('fichier_orig') )) {
      $this->redirect('interface/fichierIntrouvable');
    } else {  
      $utilFichier = new UtilFichier();
      $srvArbo = new ServiceArborescence();
      
      $strFichier = $utilFichier->findRepertoireFichier($request->getParameter('fichier'), $srvArbo->getRepertoireRacine()).$request->getParameter('fichier');
    }

    try {
      $utilTelecharger = new UtilTelecharger();
      $utilTelecharger->telechargerFichier($strFichier, $request->getParameter('fichier_orig'), true);
    } catch (Exception $e) {
      $this->redirect('interface/fichierIntrouvable');
    }
  }

}

