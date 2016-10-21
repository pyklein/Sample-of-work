<?php

/**
 * Telechargement
 * @author Gabor JAGER
 */
class telechargerPhotoAction extends sfAction
{
  public function execute($request)
  {
    $strFichier = sfConfig::get('app_photos_'.$request->getParameter('modele').'_repertoire').$request->getParameter('fichier');

    try
    {
      $utilTelecharger = new UtilTelecharger();
      $utilTelecharger->telechargerFichier($strFichier, null, false);
    }
    catch (Exception $e)
    {
      $this->redirect('interface/listerDossier_mip_publiques');
    }
  }
}

