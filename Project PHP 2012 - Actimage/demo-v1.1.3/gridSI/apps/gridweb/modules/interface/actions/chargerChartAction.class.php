<?php

/**
 * Chargement du chart
 *
 * @author Alexandre WETTA
 */
class chargerChartAction extends sfAction{

  public function  preExecute() {
    if(!$this->getRequest()->hasParameter('fichier')){
      $this->redirect('@non_autorise');
    }
    
  }

  public function execute($request)
  {
    $srvArbo = new ServiceArborescence();
    $strFichier = $srvArbo->getRepertoireTemporaire().$request->getParameter('fichier');

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
?>
