<?php

/**
 * Arreter une tâche
 * @author Gabor JAGER
 */
class arreterTacheAction extends gridAction
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

    if ($objTache == null)
    {
      $this->logger->err(__CLASS__."->".__FUNCTION__."() - ".libelle("msg_tache_erreur_jamais_lance", array(libelle("msg_tache_".$request->getParameter("cle")))));
      $this->getUser()->setFlash("erreur", libelle("msg_tache_erreur_jamais_lance", array(libelle("msg_tache_".$request->getParameter("cle")))));
      $this->redirect("supervision/index");
    }
    else if (!$objTache->isRunning())
    {
      $this->logger->debug(__CLASS__."->".__FUNCTION__."() - ".libelle("msg_tache_warning_tache_arrete", array(libelle("msg_tache_".$request->getParameter("cle")))));
      $this->getUser()->setFlash("warning", libelle("msg_tache_warning_tache_arrete", array(libelle("msg_tache_".$request->getParameter("cle")))));
      $this->redirect("supervision/index");
    }

    if ($request->isMethod('post'))
    {
      $srvProcess = new ServiceProcess();
      $srvProcess->arreterTache($request->getParameter("cle"));

      $this->getUser()->setFlash("succes", libelle("msg_tache_arrete", array(libelle("msg_tache_".$request->getParameter("cle")))));
      $this->redirect("supervision/index");
    }
  }
}
