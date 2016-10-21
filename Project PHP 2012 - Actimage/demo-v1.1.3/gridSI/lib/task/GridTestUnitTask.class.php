<?php
/**
 * Description of GridTestUnitTask
 *
 * @author William
 */
class GridTestUnitTask extends sfBaseTask {

  /**
   * Configuration de la tâche: lancer avec :  php symfony grid:test --application=gridweb
   * @param   Console   application   spécifie l'application dont la configuration doit être chargée
   * @param   Console   env           spécifie l'environnement dont la configuration doit être chargée
   */
  protected function configure() {
    $this->addArguments(array(
        new sfCommandArgument('name', sfCommandArgument::OPTIONAL, 'The test name'),
    ));
    $this->addOptions(array(
        new sfCommandOption('application', 'app', sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'gridweb'),
        new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'test'),
        new sfCommandOption('xml', null, sfCommandOption::PARAMETER_REQUIRED, 'Pour log en xml', 'test/result.log'),
    ));
    $this->namespace = 'grid';
    $this->name = 'tests';
    $this->briefDescription = 'Tests unitaires GRID';
  }

  protected function execute($arguments = array(), $options = array()) {
    //récupération de la configuration
    require_once(dirname(__FILE__) . '/../../config/ProjectConfiguration.class.php');
    $configuration =
            ProjectConfiguration::getApplicationConfiguration('gridweb', $options['env'], true);
    //connection d'un fileLogger
    $logger = new sfFileLogger($this->dispatcher, array('file' => $configuration->getRootDir() . '/log/unit.log'));
    $this->dispatcher->connect('command.log', array($logger, 'listenToLogEvent'));

    //Initialisation de la connection doctrine
    $databaseManager = new sfDatabaseManager($this->configuration);

    if (count($arguments['name']) > 0) {
      $this->runTask('test:unit', array($arguments['name']), array('xml' => $options['xml']));
    } else {
      $this->runTask('doctrine:drop', array(), array('no-confirmation' => true));
      $this->runTask('doctrine:build-db');
      $this->runTask('doctrine:insert-sql');
      Doctrine_Core::loadData(sfConfig::get('sf_test_dir') . '/fixtures');
      $this->runTask('test:unit', array(), array('xml' => $options['xml']));
    }
  }

}

?>
