<?php

/**
 * Telechargement d'un document temporaire
 * @author Gabor JAGER
 */
class telechargerDocumentTemporaireAction extends sfAction
{
  public function execute($request)
  {
    if (!$request->hasParameter('fichier')) {
      $this->redirect('interface/fichierIntrouvable');
    }
    $objUtilArbo = new ServiceArborescence();

    $strFichier = $objUtilArbo->getRepertoireTemporaire().$request->getParameter('fichier');
    try
    {
      $utilTelecharger = new UtilTelecharger();
      $utilTelecharger->telechargerFichier($strFichier, null, true);
    }
    catch (Exception $e)
    {
      $this->redirect('interface/fichierIntrouvable');
    }
  }
}

