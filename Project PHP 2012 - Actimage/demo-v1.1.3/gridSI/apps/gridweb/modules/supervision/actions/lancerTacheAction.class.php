<?php

/**
 * Lancer une tâche
 * @author Gabor JAGER
 */
class lancerTacheAction extends gridAction
{
  /**
   * Logger
   * @var sfLogger
   */
  private $logger;
  
  public function preExecute()
  {
    $this->logger = $this->getLogger();

    if (!$this->hasRequestParameter("cle"))
    {
      $this->logger->err(__CLASS__."->".__FUNCTION__."() - Pas de clé");
      $this->redirect("supervision/index");
    }
  }
  
  public function execute($request)
  {    
    $objTache = TacheTable::getInstance()->getTacheParCle($request->getParameter("cle"));

    if ($objTache != null && $objTache->isRunning())
    {
      $this->logger->err(__CLASS__."->".__FUNCTION__."() - ".libelle("msg_tache_erreur_en_cours_execution", array(libelle("msg_tache_".$request->getParameter("cle")))));
      $this->getUser()->setFlash("erreur", libelle("msg_tache_erreur_en_cours_execution", array(libelle("msg_tache_".$request->getParameter("cle")))));
      $this->redirect("supervision/index");
    }

    $srvProcess = new ServiceProcess();
    $srvProcess->executerTache($request->getParameter("cle"));

    $this->getUser()->setFlash("succes", libelle("msg_tache_lance", array(libelle("msg_tache_".$request->getParameter("cle")))));
    $this->redirect("supervision/index");
  }
}
