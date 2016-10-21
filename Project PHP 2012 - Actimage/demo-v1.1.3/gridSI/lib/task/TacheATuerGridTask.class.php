<?php

/**
 * Tâche à tuer - UNIQUEMENT POUR DEMO
 * @author Gabor JAGER
 */
class TacheATuerGridTask extends GridTask
{

  /**
   * Configuration de la tâche: lancer avec :  php symfony grid:tacheatuer --application=gridweb
   * @param Console application   spécifie l'application dont la configuration doit être chargée
   * @param Console env           spécifie l'environnement dont la configuration doit être chargée
   */
  protected function configure()
  {
    $this->app              = 'gridweb';
    $this->namespace        = 'grid';
    $this->name             = 'tacheatuer';
    $this->briefDescription = 'Tâche à tuer - UNIQUEMENT POUR DEMO';

    parent::configure();
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

    sleep(60);

    $this->logSection($this->name, 'FIN');
    
    // fin d'execution
    $this->fin(false, libelle("msg_tache_sans_erreur"));
  }
}
