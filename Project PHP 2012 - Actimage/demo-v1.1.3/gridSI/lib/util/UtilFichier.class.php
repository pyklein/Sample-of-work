<?php

/**
 * Classe permettant d'effectuer les opérations sur le système de fichier
 * @author Gabor JAGER
 */
class UtilFichier
{
  /**
   * Permet de supprimer les fichiers dans un répertoire
   * @param string $strRepertoire repertoire (avec chemin absolu)
   * @param string $strRegEx expression réguliere pour sélectionner les fichiers
   * @param integer $intLimitSeconde limit de suppression, on supprime les plus anciens fichiers (en seconde)
   * @author Gabor JAGER
   */
  public function purgerFichiers($strRepertoire, $strRegEx = ".*", $intLimitSeconde = 0)
  {
    // on récupere les fichiers
    $arrFichiers = $this->listerFichiers($strRepertoire);

    foreach($arrFichiers as $strFichier)
    {
      if (preg_match("/^".$strRegEx."$/", $strFichier))
      {
        // on supprime le fichier
        if ((filemtime($strRepertoire.$strFichier) + $intLimitSeconde) < time())
        {
          $this->supprimerFichier($strRepertoire.$strFichier);
        }
      }
    }
  }

  /**
   * Cree une liste des fichier d'un repertoire
   * @param string $strRepertoire nom du répertoire
   * @return array liste des fichier
   * @author Gabor JAGER
   */
  public function listerFichiers($strRepertoire)
  {
    $this->isExiste($strRepertoire);
    $this->isRepertoire($strRepertoire);
    $this->isLisible($strRepertoire);

    $arrRetour = array();

    $refRepertoire = opendir($strRepertoire);

    // creer la reference
    if (!$refRepertoire)
    {
      throw new Exception("Erreur lors d'ouverture de répertoire '$strRepertoire'");
    }

    while (($strFichier = readdir($refRepertoire)) !== false)
    {
      $strRepertoireTmp = $strRepertoire;
      $this->ajouterDirectorySeparator($strRepertoireTmp);

      // seulement les repertoires importables (qui ne sont pas en cours de telechargement)
      try
      {
        $this->isFichier($strRepertoireTmp.$strFichier);
        $arrRetour[] = $strFichier;
      }

      catch(Exception $ex) {}
    }

    closedir($refRepertoire);

    // ordre alphabetique
    sort($arrRetour);

    return $arrRetour;
  }

  /**
   * Cree une liste de contenu d'un repertoire
   * @param string $strRepertoire nom du répertoire
   * @return array liste de contenu
   * @author Gabor JAGER
   */
  public function listerContenu($strRepertoire)
  {
    $this->isExiste($strRepertoire);
    $this->isRepertoire($strRepertoire);
    $this->isLisible($strRepertoire);

    $arrRetour = array();

    $refRepertoire = opendir($strRepertoire);

    // creer la reference
    if (!$refRepertoire)
    {
      throw new Exception("Erreur lors d'ouverture de répertoire '$strRepertoire'");
    }

    while (($strFichier = readdir($refRepertoire)) !== false)
    {
      if ($strFichier != "." && $strFichier != "..")
      {
        $arrRetour[] = $strFichier;
      }
    }

    closedir($refRepertoire);

    // ordre alphabetique
    sort($arrRetour);

    return $arrRetour;
  }

  /**
   * Supprime un fichier
   * @param string $strChemin chemin complet du fichier
   * @param boolean $boolValidateurExistant true - si le fichier n'existe pas la fonctionne jete une Exception
   *                                        false - la fonction ne vérifie pas l'existance du fichier
   * @throws Exception si le fichier n'existe pas
   *                   ou pas droit d'écriture
   * @author Gabor JAGER
   */
  public function supprimerFichier($strChemin, $boolValidateurExistant = false)
  {
    // vérification d'existance
    if ($boolValidateurExistant) 
    {
      $this->isExiste($strChemin);
    }

    // vérification de droit
    $this->isEcrivable($this->getParent($strChemin));

    // suppression
    unlink($strChemin);
  }

  /**
   * Permet de renvoyer le chemin complet de parent du fichier/repertoire
   * @param string $strChemin chemin complet du fichier/repertoire
   * @return string chemin complet de parent
   * @author Gabor JAGER
   */
  public function getParent($strChemin)
  {
    return dirname($strChemin);
  }
  
  /**
   * Permet de vérifier si le fichier/répertoire existe ou pas
   * @param string $strChemin
   * @throws Exception si le fichier/répertoire n'existe pas
   * @author Gabor JAGER
   */
  public function isExiste($strChemin)
  {
    if (!file_exists($strChemin))
    {
      throw new Exception("Le fichier/répertoire '".$strChemin."' n'existe pas.");
    }
  }

  /**
   * Permet de vérifier si le fichier est bien un fichier
   * @param string $strChemin
   * @throws Exception si le fichier n'est pas un fichier (répertoire par example)
   * @author Gabor JAGER
   */
  public function isFichier($strChemin)
  {
    $this->isExiste($strChemin);

    if (!is_file($strChemin))
    {
      throw new Exception("'$strChemin' n'est pas un fichier.");
    }
  }

  /**
   * Permet de vérifier si le fichier est bien un fichier
   * @param string $strChemin
   * @throws Exception si le fichier n'est pas un fichier (répertoire par example)
   * @author Gabor JAGER
   */
  public function isRepertoire($strChemin)
  {
    $this->isExiste($strChemin);

    if (!is_dir($strChemin))
    {
      throw new Exception("'$strChemin' n'est pas un repertoire.");
    }
  }

  /**
   * Permet de vérifier si le fichier/répertoire est lisible ou pas
   * @param string $strChemin
   * @throws Exception si le fichier/répertoire n'est pas lisible
   * @author Gabor JAGER
   */
  public function isLisible($strChemin)
  {
    $this->isExiste($strChemin);

    if (!is_readable($strChemin))
    {
      throw new Exception("'$strChemin' n'est pas lisible.");
    }
  }

  /**
   * Permet de vérifier si le fichier/répertoire est écrivable ou pas
   * @param string $strChemin
   * @throws Exception si le fichier/répertoire n'est pas écrivable
   * @author Gabor JAGER
   */
  public function isEcrivable($strChemin)
  {
    $this->isExiste($strChemin);

    if (!is_writable($strChemin))
    {
      throw new Exception("'$strChemin' n'est pas écrivable.");
    }
  }

  /**
   * Permet de récuperer l'extension d'un fichier à partir de son chemin
   * @param string $strChemin
   * @return string extension du fichier
   * @author Gabor JAGER
   */
  public function getExtension($strChemin)
  {
    return substr(strrchr(basename($strChemin), "."), 1);
  }

  /**
   * Permet de récuperer le nom du fichier avec extension
   * @param string $strCheminFichier
   * @return string nom du fichier
   * @author Gabor JAGER
   */
  public function getBasename($strCheminFichier)
  {
    return basename($strCheminFichier);
  }

  /**
   * Permet de récuperer le nom du fichier sans extension
   * @param string $strCheminFichier
   * @return string nom du fichier
   * @author Gabor JAGER
   */
  public function getFilename($strCheminFichier)
  {
    $arrInfos = pathinfo($strCheminFichier);
    return $arrInfos['filename'];
  }

  /**
   * Créer un repertoire
   * @param string $strChemin chemin de repertoire
   * @param octet $octMode mode de droit d'accès (en octet)
   * @param boolean $boolRecursif
   * @throws Exception si la création de dossier a échoué
   * @author Gabor JAGER
   */
  public function creerRepertoire($strChemin, $octMode = 0777, $boolRecursif = true)
  {
    $strChemin = str_replace('\\', '/', $strChemin);

    // on vérifie s'il existe déjà
    try
    {
      $this->isExiste($strChemin);
    }

    // sinon on va essayer de créer ce repertoire
    catch(Exception $ex)
    {
      // si la création est recursif
      if ($boolRecursif)
      {
        $arrParts = explode('/', $strChemin);
        $strPath = "";

        foreach($arrParts as $strPart)
        {
          $strPath .= $strPart;
          
          if ($strPath !== '')
          {
            $this->creerRepertoire($strPath, $octMode, false);
          }
          $strPath .= '/';
        }
      }

      // création non récursif
      else
      {
        $oldumask = umask(0);
        $boolResultat = @mkdir($strChemin, $octMode);
        umask($oldumask);
        chmod($strChemin, $octMode);

        if (!$boolResultat)
        {
          throw new Exception("La création du repertoire '$strChemin' a échoué.");
        }
      }
    }
  }

  /**
   * Permet de recuperer le contenu d'un fichier
   * @param string $strChemin chemin du fichier
   * @return string contenu du fichier
   * @throws Exception si le fichier n'existe pas, ou n'est pas lisible
   * @author Gabor JAGER
   */
  public function getFichierContenu($strChemin)
  {
    $this->isExiste($strChemin);
    $this->isFichier($strChemin);
    $this->isLisible($strChemin);

    return file_get_contents($strChemin);
  }

  /**
   * Permet d'écrire le contenu d'un fichier
   * @param string $strChemin chemin du fichier
   * @return string contenu du fichier
   * @throws Exception si le repertoire père n'existe pas, ou n'est pas écrivable
   * @author Gabor JAGER
   */
  public function setFichierContenu($strChemin, $strContenu)
  {
    $strParent = $this->getParent($strChemin);
    
    $this->isExiste($strParent);
    $this->isEcrivable($strParent);
    
    $resultat = file_put_contents($strChemin, $strContenu);

    if ($resultat == false)
    {
      throw new Exception("Ecriture de fichier '".$strChemin."' a échoué.");
    }
  }

  /**
   * Déplace un repertoire en le renommant
   * @param string $strSource
   * @param string $strDestination
   * @author William
   */
  public function moveRepertoire($strSource,$strDestination){
    
    $this->creerRepertoire($strDestination);

    $contenuRepertoire = scandir($strSource);
    foreach ($contenuRepertoire as $fichierOuDossier) {
      if (is_file($strSource.DIRECTORY_SEPARATOR.$fichierOuDossier)) {
        if (copy($strSource.DIRECTORY_SEPARATOR.$fichierOuDossier, $strDestination.DIRECTORY_SEPARATOR.$fichierOuDossier)) {
          unlink($strSource.DIRECTORY_SEPARATOR.$fichierOuDossier);
        }
      } elseif ($fichierOuDossier != "." && $fichierOuDossier != "..") {
        $this->moveRepertoire($strSource.DIRECTORY_SEPARATOR.$fichierOuDossier, $strDestination.DIRECTORY_SEPARATOR.$fichierOuDossier);
        rmdir($strSource.DIRECTORY_SEPARATOR.$fichierOuDossier);
      }
    }
  }

  /**
   * Deplace le contenu d'un repertoire dans un autre
   * @param string $strSource
   * @param string $strDestination
   * @author William
   */
  public function moveContenuRepertoire($strSource, $strDestination)
  {
    $this->moveRepertoire($strSource, $strDestination);
    $this->creerRepertoire($strSource);
  }


  /**
   * Permet de trouvé le repertoire de stockage d'un fichier
   * @param string $strFichier nom du fichier à chercher
   * @param string $strRepertoireBase repertoire de base d'où la recherche commence
   * @return string le repertoire où se trouve le fichier cherché
   *                null si le fichier n'existe pas dans sous-arborescence
   * @author Gabor JAGER
   */
  public function findRepertoireFichier($strFichier, $strRepertoireBase)
  {
    $this->ajouterDirectorySeparator($strRepertoireBase);
    
    $this->isExiste($strRepertoireBase);
    $this->isRepertoire($strRepertoireBase);
    $this->isLisible($strRepertoireBase);

    $arrContenu = $this->listerContenu($strRepertoireBase);

    foreach ($arrContenu as $strContenu)
    {
      $strContenuPath = $strRepertoireBase.$strContenu;
      try
      {
        $this->isRepertoire($strContenuPath);
        $strResultat = $this->findRepertoireFichier($strFichier, $strContenuPath.DIRECTORY_SEPARATOR);

        if ($strResultat != null)
        {
          return $strResultat;
        }
      }

      catch(Exception $ex)
      {
        if ($strFichier == $strContenu)
        {
          return $strRepertoireBase;
        }
      }
    }

    return null;
  }

  /**
   * Permet de rajouter le "directory separator" si c'est nécessaire
   * @param string $strRepertoire
   * @author Gabor JAGER
   */
  public function ajouterDirectorySeparator(&$strRepertoire)
  {
    if (substr($strRepertoire, -1) != '/' && substr($strRepertoire, -1) != '\\')
    {
      $strRepertoire .= DIRECTORY_SEPARATOR;
    }
  }

  /**
   * Permet de copier un fichier dans un repertoire
   * @param string $strSource fichier source
   * @param string $strDestination repertoire destination
   * @author Gabor JAGER
   */
  public function copierFichier($strSource, $strDestination, $boolForce = false)
  {
    $this->isExiste($strSource);
    $this->isFichier($strSource);
    $this->isLisible($this->getParent($strSource));

    $this->ajouterDirectorySeparator($strDestination);
    $strDestination .= $this->getBasename($strSource);

    try
    {
      $this->isExiste($this->getParent($strDestination));
    }
    catch(Exception $ex)
    {
      if ($boolForce)
      {
        $this->creerRepertoire($strDestination, null, true);
      }

      else
      {
        throw $ex;
      }
    }

    $this->isRepertoire($this->getParent($strDestination));
    $this->isEcrivable($this->getParent($strDestination));

    $boolResultat = copy($strSource, $strDestination);

    if (!$boolResultat)
    {
      throw new Exception("La copie de fichier ".$this->getBasename($strSource)." a échoué.");
    }
  }
}
