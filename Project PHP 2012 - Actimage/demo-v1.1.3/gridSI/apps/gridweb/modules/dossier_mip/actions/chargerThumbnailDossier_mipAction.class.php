<?php

/**
 * Description of chargerThumbnailDossier_mipAction
 *
 * @author William
 */
class chargerThumbnailDossier_mipAction extends gridAction
{
  public function execute($request)
  {
    $this->chargerThumbnail($request->getParameter("path"),$request->getParameter("fichier"));
  }
}
?>
