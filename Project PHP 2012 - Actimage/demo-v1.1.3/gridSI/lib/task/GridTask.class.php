<?php

/**
 * Classe de base pour les tâches GRID.
 * @author Gabor JAGER
 */
abstract class GridTask extends sfBaseTask
{
  /**
   * Nom de l'application (gridweb ou gridpublique)
   * @var string
   */
  protected $app;

  /**
   * Objet tâche
   * @var Tache
   */
  protected $tache;

  protected $logger;

  /**
   * Configuration de la tâche: lancer avec :  php symfony grid:taches --application=gridweb
   * @param Console application   spécifie l'application dont la configuration doit être chargée
   * @param Console env           spécifie l'environnement dont la configuration doit être chargée
   */
  protected function configure()
  {
    $this->addOptions(array(
        new sfCommandOption('application', 'app', sfCommandOption::PARAMETER_REQUIRED, 'The application name', $this->app),
        new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'prod'),
    ));
  }

  /**
   * Début d'execution
   * @param array $arguments
   * @param array $options
   */
  protected function debut($arguments = array(), $options = array())
  {
    // récupération de la configuration
    require_once(dirname(__FILE__) . '/../../config/ProjectConfiguration.class.php');
    $configuration = ProjectConfiguration::getApplicationConfiguration($this->app, $options['env'], true);
    sfContext::createInstance($configuration);

    $configuration->loadHelpers(array("Url", "Partial", "Libelle"));

    // connection d'un fileLogger
    $this->logger = new sfFileLogger($this->dispatcher, array('file' => $configuration->getRootDir().'/log/'.$this->name.'.log'));
    $this->dispatcher->connect('command.log', array($this->logger, 'listenToLogEvent'));

    $this->logSection($this->name, "Début ".$this->name.".");

    // Initialisation de la connection doctrine
    $databaseManager = new sfDatabaseManager($configuration);

    $this->tache = TacheTable::getInstance()->getTacheParCle($this->name);

    // on crée l'enregistrement de la tâche dans la base de données
    if ($this->tache == null)
    {
      $this->tache = new Tache();
      $this->tache->setCle($this->name);
      $this->tache->save();
    }

    // si la tâche est déjà en cours d'execution
    if ($this->tache->isRunning())
    {
      $this->logSection($this->name, "ERREUR: La tâche ".$this->name." est déjà en cours d'execution.");
      die();
    }

    // on peut lancer la tâche
    else
    {
      $utilProcess = new UtilProcess();
      $this->tache->setDebut(date("Y-m-d H:i:s"));
      $this->tache->setPid($utilProcess->getPid());
      $this->tache->setResultat("");
      $this->tache->save();
    }
  }

  /**
   * Fin d'execution
   * @param string $strResultat
   */
  protected function fin($boolErreur = false, $strResultat = "")
  {
    $this->tache->setFin(date("Y-m-d H:i:s"));
    $this->tache->setPid(null);
    $this->tache->setResultat($strResultat);
    $this->tache->setErreur($boolErreur);
    $this->tache->save();
    
    $this->logSection($this->name, "Fin ".$this->name.".");
  }
}
