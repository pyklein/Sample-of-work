<?php


/**
 * Classe utilitaire des fichiers CSV
 * @author Gabor JAGER
 */
class UtilCsv
{
  /**
   * Separateur des valeurs
   */
  const SEPARATEUR = ";";

  /**
   * Si on effectue le décodage utf8 sur les valeurs
   * @var boolean
   */
  private $boolUtf8Decode;

  /**
   * Contenu d'une ligne
   * @var string
   */
  private $strContenuLigne;
  
  /**
   * Contenu du fichier
   * @var string 
   */
  private $strContenu;

  /**
   * Nom du fichier
   * @var string
   */
  private $strNomFichier;

  /**
   * Utilitaire du fichier
   * @var UtilFichier
   */
  private $utilFichier;

  /**
   * Utilitaire de téléchargement
   * @var UtilTelecharger
   */
  private $utilTelecharger;

  /**
   * Constructeur
   * @param string $strNomFichier nom du fichier
   * @param boolean $boolUtf8Decode si on effectue le décodage utf8 sur les valeurs
   * @author Gabor JAGER
   */
  public function __construct($strNomFichier = null, $boolUtf8Decode = true)
  {
    $this->strNomFichier = $strNomFichier;
    $this->boolUtf8Decode = $boolUtf8Decode;
    $this->utilFichier = new UtilFichier();
    $this->utilTelecharger = new UtilTelecharger();
  }



  /**
   * Ajoute une valeur à une ligne dans le fichier csv
   * @param string $strValeur valeur
   * @author Gabor JAGER
   */
  public function ajouterValeur($strValeur)
  {
    if (!$this->strContenuLigne)
    {
      $this->strContenuLigne = "";
    }
    if ($this->strContenuLigne != "")
    {
      $this->strContenuLigne .= self::SEPARATEUR;
    }

    $this->strContenuLigne .= $this->filtrerContenu($strValeur);
  }



  /**
   * Ajoute la ligne au fichier csv
   * @author Gabor JAGER
   */
  public function ajouterLigne()
  {
    $this->strContenu .= $this->strContenuLigne."\n";
    $this->strContenuLigne = "";
  }


  /**
   * Permet d'effectuer une filtre sur une valeur
   * @param string $strValeur
   * @return string
   * @author Gabor JAGER
   */
  private function filtrerContenu($strValeur)
  {
    $strRetour = str_replace(array("\n\r", "\r\n", "\n", "\r"), " ", $strValeur);
    $strRetour = str_replace("€", chr(128), $strValeur);

    if ($this->boolUtf8Decode)
    {
      $strRetour = utf8_decode($strRetour);
    }
    return $strRetour;
  }



  /**
   * Permet de télécharger le fichier csv
   * @author Gabor JAGER
   */
  public function telechargerFichier()
  {
    $this->utilTelecharger->telechargerFichierContenu($this->strContenu, $this->strNomFichier != null ? $this->strNomFichier : date("YmdHis"));
  }


  /**
   * Permet de sauvegarder le fichier sur le serveur
   * @param string $strNomFichier
   * @author Gabor JAGER
   */
  public function sauvegarderFichier($strNomFichier)
  {
    $this->utilFichier->setFichierContenu($strNomFichier, $this->strContenu);
  }
}
