<?php

/**
 * Service d'application des fichiers
 * @author Gabor JAGER
 */
class ServiceFichier extends UtilPhp
{
  /**
   * Permet de determiner la taille maximum d'un upload
   * @return integer
   * @author Gabor JAGER
   */
  public function getMaxUploadSizeEnBytes()
  {
    $intPhp            = parent::getMaxUploadSizeEnBytes();
    $intMaxApplication = $this->getSizeEnBytes(sfConfig::get("app_taille_max_upload_fichier"));

    return min(array($intPhp, $intMaxApplication));
  }
}
