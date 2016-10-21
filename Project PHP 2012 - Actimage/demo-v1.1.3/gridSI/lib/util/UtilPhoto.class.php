<?php

/**
 * Classe permettant d'effectuer les opérations sur les photos
 * @author Gabor JAGER
 */
class UtilPhoto
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
   * Permet de créer un thubnail d'une photo
   * @param string $strNomFichier chemin complet de la photo (original)
   * @return string nom du fichier thubnail
   * @throws Exception si la photo n'existe pas
   *                   si la photo n'est pas lisible
   *                   si le répertoire "parent" n'est pas écrivable
   * @author Gabor JAGER
   */
  public function creerThumbnail($strNomFichier, $intLargeur = 100, $intHauteur = null, $strThubPostfix = "thub")
  {
    // vérification du fichier source
    $this->utilFichier->isLisible($strNomFichier);
    $this->utilFichier->isFichier($strNomFichier);

    // vérification de répertoire
    $this->utilFichier->isEcrivable($this->utilFichier->getParent($strNomFichier));

    $strExtension = $this->utilFichier->getExtension($strNomFichier);
    $strThumbPath = $this->utilFichier->getParent($strNomFichier).DIRECTORY_SEPARATOR.$this->utilFichier->getFilename($strNomFichier).".".$strThubPostfix.".".$strExtension;

    $strMime = "image/";
    switch (strtolower($strExtension)) {

      case "jpg":
        $strMime .= "jpeg";
        break;

      default:
        $strMime .= strtolower($strExtension);
        break;
    }

    // calculer la taille de l'image cible sans modifier l'aspect de l'image original
    $arrTailleCible = $this->calculerImageTaille($this->getImageLargeur($strNomFichier), $this->getImageHauteur($strNomFichier), $intLargeur, $intHauteur);

    $objImage = new sfImage($strNomFichier, $strMime);

    // on resize l'image
    $objImage->resize($arrTailleCible[0], $arrTailleCible[1]);

    // on enregistre l'image
    $objImage->saveAs($strThumbPath, $strMime);

    return $this->utilFichier->getFilename($strThumbPath);
  }

  /**
   * Permet de calculer le largeur et l'hauteur de de l'image "cible" en gardant l'aspect de l'image original
   * @param integer $intImageLargeur largeur de l'image original
   * @param integer $intImageHauteur hauteur de l'image original
   * @param integer $intLargeur largeur de l'image cible
   * @param integer $intHauteur hauteur de l'image cible
   * @return array[0] = largeur calculé pour le cible
   *         array[1] = hauteur calculé pour le cible
   * @author Gabor JAGER
   */
  public function calculerImageTaille($intImageLargeur, $intImageHauteur, $intLargeur, $intHauteur)
  {
    $dblAspectImage = $intImageLargeur / $intImageHauteur;
    $dblAspect      = $intLargeur / $intHauteur;

    // image de type "plus portrait"
    if ($dblAspectImage > $dblAspect)
    {
      $dblRatio = $intHauteur / $intImageHauteur;
    }

    // image de type "plus paysage"
    else
    {
      $dblRatio = $intLargeur / $intImageLargeur;
    }

    // calculer la taille de sortie
    $intLargeur = (int)($intImageLargeur * $dblRatio);
    $intHauteur = (int)($intImageHauteur * $dblRatio);

    return array($intLargeur, $intHauteur);
  }

  /**
   * Permet de récuperer le largeur de l'image
   * @param string $strNomFichier chemin complet de l'image
   * @return integer
   * @throws Exception si le fichier n'existe pas
   *                   si le fichier n'est pas lisible
   * @author Gabor JAGER
   */
  public function getImageLargeur($strNomFichier)
  {
    $arrInfo = $this->getImageTaille($strNomFichier);

    return $arrInfo[0];
  }

  /**
   * Permet de récuperer le hauteur de l'image
   * @param string $strNomFichier chemin complet de l'image
   * @return integer
   * @throws Exception si le fichier n'existe pas
   *                   si le fichier n'est pas lisible
   * @author Gabor JAGER
   */
  public function getImageHauteur($strNomFichier)
  {
    $arrInfo = $this->getImageTaille($strNomFichier);

    return $arrInfo[1];
  }

  /**
   * Permet de récuperer le tableux de l'information d'une image
   * @param string $strNomFichier chemin complet de l'image
   * @return array[0]=> largeur
   *         array[1]=> hauteur
   *         array["mime"]=> type MIME
   * @throws Exception si le fichier n'existe pas
   *                   si le fichier n'est pas lisible
   * @author Gabor JAGER
   */
  private function getImageTaille($strNomFichier)
  {
    $this->utilFichier->isLisible($strNomFichier);
    $this->utilFichier->isFichier($strNomFichier);

    $arrInfo = getimagesize($strNomFichier);

    return $arrInfo;
  }
}
