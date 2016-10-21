<?php

sfContext::getInstance()->getConfiguration()->loadHelpers(array("Libelle", "Format"));

/**
 * Classe permettant de générer un fichier document
 * @author Gabor JAGER
 */
class ServiceDocument
{
  /* Caracteres RTF */
  const CAR_NL         = '\line ';
  const CAR_PARAGRAPHE = '\par ';

  /* Caracteres ouverture/fermeture d'une variabe dans RTF */
  const CAR_OUVERTURE = "\\{";
  const CAR_FERMETURE = "\\}";

  /**
   * Instance de l'utilitaire fichier
   * @var UtilFichier
   */
  protected $utilFichier;
  protected $utilArbo;
  /**
   * Constructeur. Initialise l'instance Html2Rtf
   */
  public function __construct()
  {
    $this->utilFichier = new UtilFichier();
    $this->utilArbo = new ServiceArborescence();
  }

  /**
   * Permet de valider un modèle
   * @param string $strCle Clé de lettre
   * @return array tableau[plus]   = array(elements en plus)
   *               tableau[manque] = array(elements manquants)
   * @throws Exception Si le modele n'est pas disponible
   * @author Gabor JAGER
   */
  public function validerModele($strCle)
  {
    $strContenu = $this->loadModele($strCle);

    $arrVariables = array();

    $arrRemplacements = $this->getVariables($strContenu);
    foreach ($arrRemplacements as $arrVariablesTmp)
    {
      $arrVariables[] = strtolower($arrVariablesTmp["variable"]);
    }

    $strVariablesNeccessaires = constant("Modele_lettreTable::VARIABLES_".strtoupper($strCle));
    $strVariablesNeccessaires = str_replace(" ", "", $strVariablesNeccessaires);
    $arrVariablesNeccessaires = explode(",", $strVariablesNeccessaires);

    foreach ($arrVariablesNeccessaires as $intI => $strValeur)
    {
      $arrVariablesNeccessaires[$intI] = strtolower($strValeur);
    }

    // il manque
    $arrManquants = array_diff($arrVariablesNeccessaires, $arrVariables);

    // en plus
    $arrEnPlus = array_diff($arrVariables, $arrVariablesNeccessaires);

    return array("plus" => $arrEnPlus, "manque" => $arrManquants);
  }

  /**
   * Permet de valider un modèle
   * @param string $strNomFichier Nom du fichier (avec chemin complet)
   * @return array tableau[plus]   = array(elements en plus)
   *               tableau[manque] = array(elements manquants)
   * @throws Exception Si le modele n'est pas disponible
   * @author Gabor JAGER
   */
  public function validerModeleStatique($strNomFichier)
  {
    $strContenu = $this->loadModeleStatique($strNomFichier);

    $arrRemplacements = $this->getVariables($strContenu);
    foreach ($arrRemplacements as $arrVariablesTmp)
    {
      $arrVariables[] = strtolower($arrVariablesTmp["variable"]);
    }

    return array("variables" => $arrVariables);
  }

  /**
   * Permet d'initialiser le fichier temporaire
   * @param string $strFichierPrefixe Prefixe du fichier
   * @return string nom du fichier temporaire (avec chemin complete)
   * @author Gabor JAGER
   */
  private function initFichierTemporaire($strFichierPrefixe)
  {
    // on supprime les ancien fichiers généré
    $this->utilFichier->purgerFichiers($this->utilArbo->getRepertoireTemporaire(), $strFichierPrefixe."_.+\.rtf", 60);

    // créer le nom du fichier
    return $this->utilArbo->getRepertoireTemporaire().$strFichierPrefixe."_".date("YmdHis").".rtf";
  }

  /**
   * Permet de recuperer le contenu d'un modèle dans une variable
   * @param string $strCle Clé de lettre
   * @return string contenu de modèle
   * @throws Exception Si le modele n'est pas disponible
   * @author Gabor JAGER
   */
  private function loadModele($strCle)
  {
    // on récupere le modèle
    $objModeleLettre = Modele_lettreTable::getInstance()->getModeleLettreParCle($strCle);

    // on vérifie le modèle
    if (!$objModeleLettre->estDisponible())
    {
      throw new Exception("Le modèle n'est pas disponible.");
    }

    // on récupere le contenu de fichier modèle
    return $this->utilFichier->getFichierContenu($objModeleLettre->getCheminModele());
  }

  /**
   * Permet de recuperer le contenu d'un modèle statique dans une variable
   * @param string $strFichier fichier (avec chemin complet)
   * @return string contenu de modèle
   * @throws Exception Si le modele n'existe pas ou n'est pas lisible
   * @author Gabor JAGER
   */
  private function loadModeleStatique($strFichier)
  {
    // on récupere le contenu de fichier modèle
    return $this->utilFichier->getFichierContenu($strFichier);
  }

  /**
   * Render un document
   * @param string $strContenu contenu de fichier
   * @param string[] $arrVariables variables à remplacer
   * @author Gabor JAGER
   */
  private function renderDocumentRtf(&$strContenu, $arrVariables)
  {
    foreach($arrVariables as $strCle => $strVariable)
    {
      $this->remplacerVariable($strContenu, $strCle, $strVariable);
    }
  }

  /**
   * Permet de ramplacer une variable avec une valeur
   * @param string $strContenu contenu RTF
   * @param string $strVariable nom/clé de varable
   * @param string $strValeur valeur
   * @author Gabor JAGER
   */
  private function remplacerVariable(&$strContenu, $strVariable, $strValeur)
  {
    $arrRemplacements = $this->getVariables($strContenu);

    foreach($arrRemplacements as $arrVariable)
    {
      if ($arrVariable["variable"] == strtoupper($strVariable))
      {
        $strContenu = str_replace($arrVariable["stringARemplacer"], utf8_decode(str_replace("\n", self::CAR_NL, $strValeur)), $strContenu);
      }
    }
  }

  /**
   * Pemret de récuperer tous les variables de fichier
   * @param string $strContenu
   * @return array
   * @author Gabor JAGER
   */
  private function getVariables($strContenu)
  {
    $arrRetour = array();
    
    $intDebut = 0;
    $intFin = 0;

    while($intFin !== false)
    {
      $intDebut = strpos($strContenu, self::CAR_OUVERTURE, $intDebut);

      if ($intDebut !== false)
      {
        $intFin = strpos($strContenu, self::CAR_FERMETURE, $intDebut);

        if ($intFin !== false)
        {
          $strVar = substr($strContenu, $intDebut + strlen(self::CAR_OUVERTURE), $intFin - $intDebut - strlen(self::CAR_FERMETURE));

          $strVariableOriginal = $strVar;
          $strVar = str_replace(array(self::CAR_OUVERTURE, self::CAR_FERMETURE), "", $strVar);
          $strVar = str_replace("}{", " ", $strVar);

          $arrParts = explode(" ", $strVar);
          
          $strVariableCorrige = "";
          foreach($arrParts as $strPart)
          {
            $strPart = trim($strPart);
            if (preg_match("/^[A-Z0-9_]+$/", $strPart))
            {
              $strVariableCorrige .= $strPart;
            }
          }

          $arrRetour[] = array("variable" => strtoupper($strVariableCorrige), "stringARemplacer" => self::CAR_OUVERTURE.$strVariableOriginal.self::CAR_FERMETURE);
        }
      }
      else
      {
        $intFin = false;
      }
      $intDebut = $intFin;
    }

    return $arrRetour;
  }

  /**
   * Permet de créer un document à partir d'un modèle statique
   * @param string $strFichierModele Chemin du modèle
   * @param string $strFichierPrefixe Prefixe du fichier
   * @param array $arrVariables Variables à remplacer
   * @return string Nom de fichier généré (sans chemin)
   * @throws Exception Si le modele n'est pas disponible ou si le dossier n'existe pas
   * @author Gabor JAGER
   */
  protected function creerDocumentModeleStatique($strFichierModele, $strFichierPrefixe, $arrVariables)
  {
    // on récupere le contenu de fichier modèle
    $strContenu = $this->loadModeleStatique($strFichierModele);

    // on supprime l'ancien fichier + on génére le nom du fichier
    $strFichier = $this->initFichierTemporaire($strFichierPrefixe);

    // render de document avec des variables
    $this->renderDocumentRtf($strContenu, $arrVariables);

    // on copie le contenu généré dans le fichier
    $this->utilFichier->setFichierContenu($strFichier, $strContenu);

    return $this->utilFichier->getBasename($strFichier);
  }

  /**
   * Permet de créer un document à partir d'un modèle statique
   * @param string $strCle Clé du modèle
   * @param string $strFichierPrefixe Prefixe du fichier
   * @param array $arrVariables Variables à remplacer
   * @return string Nom de fichier généré (sans chemin)
   * @throws Exception Si le modele n'est pas disponible ou si le dossier n'existe pas
   * @author Gabor JAGER
   */
  protected function creerDocumentModeleDynamique($strCle, $strFichierPrefixe, $arrVariables)
  {
    // on récupere le contenu de modèle
    $strContenu = $this->loadModele($strCle);

    // on supprime l'ancien fichier + on génére le nom du fichier
    $strFichier = $this->initFichierTemporaire($strFichierPrefixe);

    // render de document avec des variables
    $this->renderDocumentRtf($strContenu, $arrVariables);

    // on copie le contenu généré dans le fichier
    $this->utilFichier->setFichierContenu($strFichier, $strContenu);

    return $this->utilFichier->getBasename($strFichier);
  }
}
