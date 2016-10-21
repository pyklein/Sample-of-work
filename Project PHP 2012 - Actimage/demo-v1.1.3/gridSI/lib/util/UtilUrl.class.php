<?php
/**
 * Utilitaire d'URL
 * @author Gabor JAGER
 */
class UtilUrl
{
  /**
   * Permet de recuperer l'URL de base de l'application
   * @return string
   * @author Gabor JAGER
   */
  public function getUrlBase()
  {
    $strRetour = "http://";
    $strRetour .= $_SERVER["HTTP_HOST"].(strpos($_SERVER["HTTP_HOST"], ":") === false ? ($_SERVER["SERVER_PORT"] != "80" ? ":".$_SERVER["SERVER_PORT"] : "") : "");
    $strRetour .= dirname($_SERVER["SCRIPT_NAME"]);
    return $strRetour;
  }
}
