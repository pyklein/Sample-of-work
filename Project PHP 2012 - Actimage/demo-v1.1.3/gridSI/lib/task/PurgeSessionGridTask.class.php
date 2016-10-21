<?php

/**
 * Classe représentant la tache symfony de nettoyage de tous les table de session.
 * Tâche à executer chaque minuit.
 * @author Gabor JAGER
 */
class PurgeSessionGridTask extends GridTask
{

  /**
   * Configuration de la tâche: lancer avec :  php symfony grid:purgesession --application=gridweb
   * @param Console application   spécifie l'application dont la configuration doit être chargée
   * @param Console env           spécifie l'environnement dont la configuration doit être chargée
   */
  protected function configure()
  {
    $this->app              = 'gridweb';
    $this->namespace        = 'grid';
    $this->name             = 'purgesession';
    $this->briefDescription = 'Nettoyage de tous les table de session';

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

    // on parse le fichier schema.yml pour recuperer les noms de table
    $objParser = new Doctrine_Parser_Yml();
    $arrDonnees = $objParser->loadData(sfConfig::get("sf_config_dir")."/doctrine/schema.yml");

    $intTables = 0;
    $intErreur = 0;
    
    // on boucle tous les tables
    foreach($arrDonnees as $strTable => $arrTableDescription)
    {
      // on vide UNIQEMENT les tables de session
      if (preg_match('/^Session_.+$/', $strTable))
      {
        $intTables++;
        $this->logSection($strTable, 'Vider la table');

        try
        {
          $intNbSupprime = Doctrine_Core::getTable($strTable)->createQuery()->delete()->execute();
          $this->logSection($strTable, $intNbSupprime.' élément(s) supprimé(s)');
        }
        catch (Exception $ex)
        {
          $this->logSection($strTable, 'Erreur: '.$ex->getTraceAsString());
          $intErreur++;
        }
      }
    }

    $this->logSection($this->name, 'FIN');
    
    // fin d'execution
    $this->fin(false, libelle("msg_tache_rapport_purgesession", array($intErreur, $intTables)));
  }
}
