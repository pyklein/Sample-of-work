<?php

/**
 * Action de création d'un inventeur
 * @author Gabor JAGER
 */
class creerInventeurAction extends gridAction
{
  /**
   * Logger
   * @var sfLogger
   */
  private $logger;

  public function preExecute()
  {
    $this->logger = $this->getLogger();

    // la procedure de création n'a pas passé encore sur le "pre-formulaire"
    if (!$this->getUser()->hasAttribute("preFormulaireInventeur"))
    {
      $this->logger->debug(__CLASS__."->".__FUNCTION__."() - Redirect vers le pre-formulaire");
      $this->redirect("referentiel_bpi/preCreerInventeur");
    }
  }

  public function execute($request)
  {
    $this->logger->debug(__CLASS__."->".__FUNCTION__."() - Start");

    $arrValeursPreformulaire = $this->getUser()->getAttribute("preFormulaireInventeur");
    
    // on crée l'objet à partir des données de pre-formulaire
    $objInventeur = new Inventeur();
    $objInventeur->setNom($arrValeursPreformulaire["nom"]);
    $objInventeur->setEstExterieur($arrValeursPreformulaire["est_exterieur"] ? true : false);


    $this->objForm = new InventeurForm(true,$objInventeur);
    
    // on recharge le formulaire avec les villes (version sans Javascript)
    if ($request->isMethod('post') && $request->hasParameter("chargerVilles"))
    {
      $this->objForm->bind($request->getParameter($this->objForm->getName()));
    }

    // submit de formulaire
    else if($request->isMethod('post'))
    {
      $this->logger->debug(__CLASS__."->".__FUNCTION__."() - Post");

      $this->processForm('creer');
    }

    $this->logger->debug(__CLASS__."->".__FUNCTION__."() - End");
  }

  public function postExecute() {}
}
