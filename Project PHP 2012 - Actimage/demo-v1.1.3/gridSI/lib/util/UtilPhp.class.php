<?php

/**
 * Description of UtilPhp
 *
 * @author Simeon Petev
 */
class UtilPhp
{

  /**
   * Recupere la valeur maximal permies de upload de fichier
   *
   * @return integer Taille en bytes
   *
   * @author Simeon PETEV
   */
  public function getMaxUploadSizeEnBytes()
  {
    $intMaxUpload = $this->getSizeEnBytes(ini_get('upload_max_filesize'));
    $intMaxPost = $this->getSizeEnBytes(ini_get('post_max_size'));
    $intMaxApplication = $this->getSizeEnBytes(sfConfig::get("app_taille_max_upload_fichier"));

    return min(array($intMaxUpload, $intMaxPost, $intMaxApplication));
  }

  /**
   * Recupere la taille maximal de upload dans un format facile à lire par les
   * humains francofones
   *
   * @return string La taille en format B/Ko/Mo/Go/To
   *
   * @author Simeon PETEV
   */
  public function getMaxUploadSizeEnFormatHumain()
  {
    return $this->getHumanReadableSize($this->getMaxUploadSizeEnBytes());
  }

  /**
   * Recupere la valeur des bytes en format lisible par l'humain
   *
   * @param int $size
   * @return string
   *
   * @author Simeon PETEV
   */
  public function getHumanReadableSize($size)
  {
    $units = array('o', 'Ko', 'Mo', 'Go', 'To');
    for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024;
      return round($size, 2).$units[$i];
  }

  /**
   * Recupere le nombre de bytes à partir d'un format humain
   *
   * @param string $strSizeHumanFormat Format: b/B, k/K, m/M, g/G, t/T
   * @return integer
   *
   * @author Simeon PETEV
   */
  public function getSizeEnBytes($strSizeHumanFormat)
  {
    $intNumLenth = strspn($strSizeHumanFormat, '0123456789');

    $strNumber = substr($strSizeHumanFormat, 0,$intNumLenth).'';
    $strSufixeFormat = substr($strSizeHumanFormat, $intNumLenth,  strlen($strSizeHumanFormat)).'';
    $strSufixeFormat = strtolower($strSufixeFormat);

    if ($strSufixeFormat)
    {
      switch ($strSufixeFormat[0])
      {
        case 'b':
        {
          return $strNumber;
        }
        case 'k':
        {
          return $strNumber*1024;
        }
        case 'm':
        {
          return $strNumber*1024*1024;
        }
        case 'g':
        {
          return $strNumber*1024*1024*1024;
        }
        case 't':
        {
          return $strNumber*1024*1024*1024*1024;
        }
        default :
        {
          return $strNumber;
        }
      }
    } else
    {
      return $strNumber;
    }
    
  }
}
