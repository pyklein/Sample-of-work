<?php
/**
 * Utilitaire de l'ordonnanceur
 * @author Gabor JAGER
 */
class UtilOrdonnanceur
{
  /**
   * Minute : 0-59
   * @var integer
   */
  private $intMinute;

  /**
   * Heure : 0-23
   * @var integer
   */
  private $intHeure;

  /**
   * Jour du mois : 1-31
   * @var integer
   */
  private $intJour;

  /**
   * Numéro du mois : 1-12
   * @var integer
   */
  private $intMois;

  /**
   * Numéro de jour de la semaine : 0-6
   * @var integer
   */
  private $intJourSemaine; // 0-6

  /**
   * Constructeur
   * Permet d'initialiser la date et l'heure de l'execution.
   * @author Gabor JAGER
   */
  public function  __construct()
  {
    $this->intMinute      = intval(date("i")); // 00-59
    $this->intHeure       = intval(date("G")); // 0-23
    $this->intJour        = intval(date("j")); // 1-31
    $this->intMois        = intval(date("n")); // 1-12
    $this->intJourSemaine = intval(date("w")); // 0-6

  }

  /**
   * Permet de décider si l'ordonnanceur doit executer la tâche ou pas
   * @param string $strCrontab
   * @return boolean true s'il faut l'executer
   * @author Gabor JAGER
   */
  public function estExecutable($strCrontab)
  {
    $arrTmp = explode(" ", trim($strCrontab));

    $arrValeurs = array();
    foreach($arrTmp as $strValeurTmp)
    {
      if ($strValeurTmp != "")
      {
        $arrValeurs[] = $strValeurTmp;
      }
    }

    // minutes
    if (!$this->verifierUnite($arrValeurs[0], $this->intMinute))
    {
      return false;
    }

    // heure
    if (!$this->verifierUnite($arrValeurs[1], $this->intHeure))
    {
      return false;
    }

    // jour
    if (!$this->verifierUnite($arrValeurs[2], $this->intJour))
    {
      return false;
    }

    // mois
    if (!$this->verifierUnite($arrValeurs[3], $this->intMois))
    {
      return false;
    }

    // jour de la semaine
    if (!$this->verifierUnite($arrValeurs[4], $this->intJourSemaine))
    {
      return false;
    }

    return true;
  }

  /**
   * Permet de décider si la tâche est executable ou pas d'après cette critère
   * @param string $strValeur valeur ordonnanceur
   * @param integer $intUnite unité actuel
   * @return boolean true si executable
   *                 false sinon
   * @author Gabor JAGER
   */
  private function verifierUnite($strValeur, $intUnite)
  {
    if ($strValeur != "*")
    {
      // si en format */X (X est une chiffre)
      if (preg_match('/^\*\/[0-9]+$/', $strValeur))
      {
        $intDiviseur = intval(substr($strValeur, 2));
        if ($intUnite % $intDiviseur != 0)
        {
          return false;
        }
      }

      // si en format X (X est une chiffre)
      elseif (preg_match('/^[0-9]+$/', $strValeur))
      {
        if ($intUnite != intval($strValeur))
        {
          return false;
        }
      }

      else
      {
        return false;
      }
    }

    return true;
  }
}
