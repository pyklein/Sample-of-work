<?php
/**
 * Utilitaire de processus
 * @author Gabor JAGER
 */
class UtilProcess
{
  /**
   * Commande Windows pour tuer un processus
   * @var string
   */
  private $windows_kill = "taskkill /F /PID %s";

  /**
   * Commande Windows pour executer une commande asyncrone
   * @var string
   */
  private $windows_exec = "start /B %s";

  /**
   * Commande Linux pour tuer un processus
   * @var string
   */
  private $linux_kill   = "kill -9 %s";

  /**
   * Commande Linux pour executer une commande asyncrone
   * @var string
   */
  private $linux_exec   = "%s &";

  /**
   * Permet de récuperer le PID de processus courant
   * @return integer
   * @author Gabor JAGER
   */
  public function getPid()
  {
    return getmypid();
  }

  /**
   * Permet de décider si sur le serveur c'est un windows ou pas
   * @return boolean true si Windows
   * @author Gabor JAGER
   */
  public function isWindows()
  {
    if (preg_match("/WIN/", PHP_OS))
    {
      return true;
    }

    return false;
  }

  /**
   * Permet de tuer un processus
   * @param integer $intPid
   * @author Gabor JAGER
   */
  public function kill($intPid)
  {
    if ($intPid != null)
    {
      $strCommande = sprintf($this->isWindows() ? $this->windows_kill : $this->linux_kill, $intPid);

      $strRetour = $this->exec($strCommande);

      return $strRetour;
    }

    return null;
  }

  /**
   * Permet d'executer une commande
   * @param string $strCommande
   * @param boolean $boolAsync execution asyncrone
   * @author Gabor JAGER
   */
  public function exec($strCommande, $boolAsync = true)
  {
    if (!$boolAsync)
    {
      $arrOutput = array();
      $intRetour = null;
      exec($strCommande, $arrOutput, $intRetour);
      return $intRetour;
    }
    else
    {
      $strCommande = sprintf($this->isWindows() ? $this->windows_exec : $this->linux_exec, $strCommande);
      if(pclose(popen($strCommande, 'r')))
      {
          return true;
      }

      return false;
    }
  }
}
