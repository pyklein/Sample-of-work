<?php


/**
 * Description of SetupGridTask
 * Tache d'installation de l'application GRID, effectue les traitements suivants:
 * -Creation de l'arborescence des répertoires de l'application (hors webserveur)
 * -Génération des classes de bases modèle,form et filtre
 * -Drop + build de la base de données
 * -Insertion des fixtures
 * -Insertion du script SQL pour la vue de recherche
 * -Calcul de l'état de contrôle des dossiers MIP
 * -Initialisation du repertoire et des fichiers de modèles de documents
 *
 * @author William
 */
class SetupGridTask extends sfBaseTask {

  /**
   * Configuration de la tâche: lancer avec :  php symfony grid:setup --application=gridweb
   * @param   Console   application   spécifie l'application dont la configuration doit être chargée
   * @param   Console   env           spécifie l'environnement dont la configuration doit être chargée
   */
  protected function configure() {
    $this->addOptions(array(
        new sfCommandOption('application', 'app', sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'gridweb'),
        new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'prod'),
        new sfCommandOption('confirm','co',  sfCommandOption::PARAMETER_OPTIONAL,"Confirmation demandée?",true)
        ));
    $this->namespace = 'grid';
    $this->name = 'setup';
    $this->briefDescription = 'Initialisation GRID';
  }

  protected function execute($arguments = array(), $options = array()) {

    // on augmente la limite de memoire si elle est trop petit
    $utilPhp = new UtilPhp();
    if ($utilPhp->getSizeEnBytes(ini_get("memory_limit")) < $utilPhp->getSizeEnBytes("128M"))
    {
      ini_set("memory_limit", "128M");
    }

    //récupération de la configuration
    require_once(dirname(__FILE__) . '/../../config/ProjectConfiguration.class.php');
    $configuration =
            ProjectConfiguration::getApplicationConfiguration('gridweb', $options['env'], true);
    //connection d'un fileLogger
    $logger = new sfFileLogger($this->dispatcher, array('file' => $configuration->getRootDir() . '/log/setup.log'));
    $this->dispatcher->connect('command.log', array($logger, 'listenToLogEvent'));

    //Initialisation de la connection doctrine
    $databaseManager = new sfDatabaseManager($this->configuration);

    $this->log("Création de l'arborescence");

    $objUtilArbo = new ServiceArborescence();
    $arrRepertoires = array_unique($objUtilArbo->getRepertoiresInitiaux());

    $utilFichier = new UtilFichier();
    foreach($arrRepertoires as $repertoire) {
      try
      {
        $utilFichier->creerRepertoire($repertoire);
        $this->log("Création du repertoire '".$repertoire."'.");
      }
      catch (Exception $ex)
      {
        $this->log("ERREUR: ".$ex->getMessage());
      }
    }

    //lancement doctrine:build complet
    try {
      $confirmation = $options['confirm'] ? '' : '--no-confirmation';
      
      $buildTask = new sfDoctrineBuildTask($this->dispatcher, $this->formatter);
      $buildTask->run(array(),array('--all','--and-load',$confirmation));


    } catch (Exception $ex) {
      $this->log("ERREUR: ".$ex->getMessage());
      $this->log("ERREUR: ".$ex->getTraceAsString());
    }

    $this->logSection('Initialisation Recherches', 'Génération de la vue : view_recherche');

    $sqlTask = new sfSqlExecuteTask($this->dispatcher,$this->formatter);
    $sqlTask->run(array(),array('--file' => 'data' . DIRECTORY_SEPARATOR . 'sql' . DIRECTORY_SEPARATOR . 'view_recherche.sql'));



    $this->logSection('Initialisation MIP', 'Calcul du champ : necessite_controle');
    //Affectation du champ necessite_controle dans les dossiers MIP présents dans les fixtures
    $arrDossiersMip = Doctrine_Core::getTable('Dossier_mip')->findAll();
    foreach ($arrDossiersMip as $objDossierMip) {
      $objDossierMip->save();
    }

    $this->logSection('Initialisation Entite', 'Calcul des champ : parents, parents_arbo');
    //Affectation des champ parents et parents_arbo dans les Entités présents dans les fixtures
    $arrEntite = Doctrine_Core::getTable('Entite')->findAll();
    foreach ($arrEntite as $objEntite) {
      $objEntite->save();
    }

    // initialiser les modèles
    $arrModeles = $utilFichier->listerFichiers(sfConfig::get("sf_data_dir").DIRECTORY_SEPARATOR."modeles");
    foreach($arrModeles as $strFichier)
    {
      try
      {
        $utilFichier->copierFichier(sfConfig::get("sf_data_dir").DIRECTORY_SEPARATOR."modeles".DIRECTORY_SEPARATOR.$strFichier, $objUtilArbo->getRepertoireModelesDocuments());
        $this->log("Copie du fichier '".$strFichier."'.");
      }

      catch(Exception $ex)
      {
        $this->log("ERREUR : ".$ex->getMessage());
      }
    }
  }

}
