<?php

/**
 * Classe représentant la tache symfony de l'ordonnanceur de GRID.
 * Tâche à executer chaque minute.
 * @author Gabor JAGER
 */
class TachesGridTask extends GridTask
{
  
  /**
   * Configuration de la tâche
   * Lancer avec :
   * php symfony grid:taches [--now=true]
   */
  protected function configure()
  {
    $this->app              = 'gridweb';
    $this->namespace        = 'grid';
    $this->name             = 'taches';
    $this->briefDescription = 'Ordonnanceur des tâches';

    parent::configure();

    $this->addOption('now', null, sfCommandOption::PARAMETER_REQUIRED, 'Pour forcer si on veut lancer maintenant tous les taches', "false");
  }
  
  /**
   * Execution
   * @param array $arguments
   * @param array $options
   */
  protected function execute($arguments = array(), $options = array())
  {
    // init d'execution
    $this->debut($arguments, $options);

    $this->logSection($this->name, 'DEBUT');

    $srvProcess = new ServiceProcess();

    $utilOrdonnanceur = new UtilOrdonnanceur();

    $arrTaches = TacheTable::getInstance()->getTaches();
    foreach($arrTaches as $strCle => $objTache)
    {
      if (sfConfig::get("app_tache_".$strCle) && $utilOrdonnanceur->estExecutable(sfConfig::get("app_tache_".$strCle))
              || $options["now"] == "true")
      {
        $this->logSection($this->name, 'Lancer '.$strCle);
        $srvProcess->executerTache($strCle);
      }

      else
      {
        $this->logSection($this->name, 'La tâche '.$strCle.' ne se lance pas maintenant');
      }
    }
    

    $this->logSection($this->name, 'FIN');

    // fin d'execution
    $this->fin();
  }
}
