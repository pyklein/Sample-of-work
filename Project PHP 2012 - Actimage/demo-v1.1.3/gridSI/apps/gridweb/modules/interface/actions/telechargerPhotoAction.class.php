<?php

/**
 * Telechargement
 * @author Gabor JAGER
 */
class telechargerPhotoAction extends sfAction
{
  public function execute($request)
  {
    $strFichier = pack("H*" ,$request->getParameter('path')). $request->getParameter("fichier");

    try
    {
      $utilTelecharger = new UtilTelecharger();
      $utilTelecharger->telechargerFichier($strFichier, null, false);
    }
    catch (Exception $e)
    {
      $strFichier = sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR."interface".DIRECTORY_SEPARATOR."noimage.png";

      $utilTelecharger = new UtilTelecharger();
      $utilTelecharger->telechargerFichier($strFichier, null, false);
    }
  }
}

