<?php
/**
 * Service de processus
 * @author Gabor JAGER
 */
class ServiceProcess
{
  /**
   * Utilitaire de processus
   * @var UtilProcess
   */
  private $utilProcess;

  /**
   * String d'execution d'une tâche sous Windows
   * @var string
   */
  private $tache_exec_windows = "%s \"%ssymfony\" grid:%s";

  /**
   * String d'execution d'une tâche sous Linux
   * @var string
   */
  private $tache_exec_linux   = "%s %ssymfony grid:%s";

  /**
   * Constructeur
   * @author Gabor JAGER
   */
  public function  __construct()
  {
    $this->utilProcess = new UtilProcess();
  }

  /**
   * Permet d'executer une tâche GRID
   * @param string $strCle clé de la tâche
   * @author Gabor JAGER
   */
  public function executerTache($strCle)
  {
    // Permet d'éviter les erreurs de type "max execution time"
    set_time_limit(0);
    
    // Permet de continuer le script en cas déconnexion de l'utilisateur
    ignore_user_abort(false);

    $this->utilProcess->exec(sprintf(($this->utilProcess->isWindows() ? $this->tache_exec_windows : $this->tache_exec_linux), sfConfig::get("app_php_chemin"), sfConfig::get("sf_root_dir").DIRECTORY_SEPARATOR, $strCle));
  }

  /**
   * Permet d'arreter une tâche GRID
   * @param string $strCle clé de la tâche
   * @author Gabor JAGER
   */
  public function arreterTache($strCle)
  {
    $objTache = TacheTable::getInstance()->getTacheParCle($strCle);

    if ($objTache == null)
    {
      return;
    }
    else if ($objTache->getPid() == null)
    {
      return;
    }
    
    $resultat = $this->utilProcess->kill($objTache->getPid());
    $objTache->setPid(null);
    $objTache->setResultat(libelle("msg_tache_arrete_manuellement"));
    $objTache->setErreur(true);
    $objTache->save();
  }

}
