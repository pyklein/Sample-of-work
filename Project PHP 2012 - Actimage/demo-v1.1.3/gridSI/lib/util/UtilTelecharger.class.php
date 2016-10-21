<?php

/**
 * Classe permettant de télécharger des fichiers
 * @author Gabor JAGER
 */
class UtilTelecharger
{
  /**
   * Utilitaire fichier
   * @var UtilFichier
   */
  var $utilFichier;

  /**
   * Constructeur
   * Initialise l'utilitaire fichier
   */
  function __construct()
  {
    $this->utilFichier = new UtilFichier();
  }

  /**
   * Téléchargement d'un fichier
   * @param string $strNomCompletFichier nom de fichier avec le chemin
   * @param string $strNomFichier nom du ficher à telecharger
   * @param boolean $boolEstTelecharger permet de forcer le telechargement
   * @author Gabor JAGER
   */
  public function telechargerFichier($strNomCompletFichier, $strNomFichier=null, $boolEstTelecharger = true)
  {
    // vérification si le fichier existe et lisible
    $this->utilFichier->isExiste($strNomCompletFichier);
    $this->utilFichier->isLisible($strNomCompletFichier);

    // on essaie de reconnaitre l'extension pour que le téléchargement
    // corresponde au type de fichier afin d'éviter les erreurs de corruptions
    $strType = $this->getContentType($this->utilFichier->getExtension($strNomCompletFichier));

    // envoie du fichier, modification des headers HTTP et readfile
    if ($boolEstTelecharger)
    {
      header("Content-Disposition: attachment; filename=\"".basename($strNomFichier)."\"");
      header("Content-Type: application/force-download");
      header("Cache-Control: must-revalidate, post-check=0, pre-check=0, public");
      header("Pragma: public");
      header("Expires: 0");
    }
    //header("Content-Transfer-Encoding: $strType\n"); // Surtout ne pas enlever le \n
    header("Content-Type: $strType\n");
    header("Content-Length: ".filesize($strNomCompletFichier));
    readfile($strNomCompletFichier);
    exit;
  }

  /**
   * Téléchargement d'un fichier avec le contenu passé en paramètre
   * @param string $strContenu contenu du fichier
   * @param string $strNomFichier nom du ficher à telecharger
   * @param boolean $boolEstTelecharger permet de forcer le telechargement
   * @author Gabor JAGER
   */
  public function telechargerFichierContenu($strContenu, $strNomFichier, $boolEstTelecharger = true)
  {
    // on essaie de reconnaitre l'extension pour que le téléchargement
    // corresponde au type de fichier afin d'éviter les erreurs de corruptions
    $strType = $this->getContentType($this->utilFichier->getExtension($strNomFichier));

    // envoie du fichier, modification des headers HTTP et readfile
    if ($boolEstTelecharger)
    {
      header("Content-Disposition: attachment; filename=\"".basename($strNomFichier)."\"");
      header("Content-Type: application/force-download");
      header("Cache-Control: must-revalidate, post-check=0, pre-check=0, public");
      header("Pragma: public");
      header("Expires: 0");
    }
    //header("Content-Transfer-Encoding: $strType\n"); // Surtout ne pas enlever le \n
    header("Content-Type: $strType\n");
    header("Content-Length: ".strlen($strContenu));

    print($strContenu);
    exit;
  }

  /**
   * Permet de reconnaitre le type de fichier
   * @param <type> $strExtension
   * @return string
   */
  private function getContentType($strExtension)
  {
    // on essaie de reconnaitre l'extension pour que le téléchargement
    // corresponde au type de fichier afin d'éviter les erreurs de corruptions
    switch(strtolower($strExtension))
    {
      // archives
      case "gz" :    $strType = "application/x-gzip"; break;
      case "tgz":    $strType = "application/x-gzip"; break;
      case "zip":    $strType = "application/zip";    break;

      // fichier proprio
      case "pdf":    $strType = "application/pdf";    break;
      case "csv":
      case "xls":    $strType = "application/vnd.ms-excel"; break;
      case "doc":    $strType = "application/msword";  break;
      case "ods":    $strType = "vnd.oasis.opendocument.spreadsheet"; break;
      case "odt":    $strType = "vnd.oasis.opendocument.text"; break;

      // images
      case "png":    $strType = "image/png";          break;
      case "gif":    $strType = "image/gif";          break;
      case "jpeg":
      case "jpg":    $strType = "image/jpeg";         break;

      // texte
      case "txt":    $strType = "text/plain";         break;
      case "htm":    $strType = "text/html";          break;
      case "html":   $strType = "text/html";          break;

      // defaut stream
      default:        $strType = "application/octet-stream";  break;
    }

    return $strType;
  }
}
