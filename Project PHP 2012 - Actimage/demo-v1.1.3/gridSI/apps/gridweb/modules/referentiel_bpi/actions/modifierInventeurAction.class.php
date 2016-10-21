<?php

/**
 * Action de modification d'un inventeur
 * @author Gabor JAGER
 */
class modifierInventeurAction extends gridAction
{
  /**
   * Logger
   * @var sfLogger
   */
  private $logger;

  /**
   * Objet inventeur
   * @var Inventeur
   */
  private $objInventeur;

  public function preExecute()
  {
    $this->logger = $this->getLogger();

    // vérifications
    if (!$this->getRequestParameter("id"))
    {
      $this->logger->err(__CLASS__."->".__FUNCTION__."() - Pas d'id");
      $this->redirect("referentiel_bpi/listerInventeurs");
    }

    $this->objInventeur = InventeurTable::getInstance()->findOneById($this->getRequestParameter("id"));
    if ($this->objInventeur == null)
    {
      $this->logger->err(__CLASS__."->".__FUNCTION__."() - Objet n'existe pas");
      $this->redirect("referentiel_bpi/listerInventeurs");
    }
  }

  public function execute($request)
  {
    $this->logger->debug(__CLASS__."->".__FUNCTION__."() - Start");


    $this->objForm = new InventeurForm(true, $this->objInventeur);
    
    // on recharge le formulaire avec les villes (version sans Javascript)
    if ($request->isMethod('post') && $request->hasParameter("chargerVilles"))
    {
      $this->objForm->bind($request->getParameter($this->objForm->getName()));
    }

    // submit de formulaire
    else if($request->isMethod('post'))
    {
      $this->logger->debug(__CLASS__."->".__FUNCTION__."() - Post");

      $this->processForm('modifier');
    }

    $this->logger->debug(__CLASS__."->".__FUNCTION__."() - End");
  }

  public function postExecute() {}
}
