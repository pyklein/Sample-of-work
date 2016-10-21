<?php

/**
 * Action de pre-création d'un inventeur
 * @author Gabor JAGER
 */
class preCreerInventeurAction extends gridAction
{
  /**
   * Logger
   * @var sfLogger 
   */
  private $logger;

  public function preExecute()
  {
    $this->logger = $this->getLogger();
  }

  public function execute($request)
  {
    $this->logger->debug(__CLASS__."->".__FUNCTION__."() - Start");

    $objForm = new InventeurPreCreerForm();

    if($request->isMethod('post'))
    {
      $this->logger->debug(__CLASS__."->".__FUNCTION__."() - Post de formulaire");

      // on bind le formulaire
      $objForm->bind($request->getParameter($objForm->getName()));

      if ($objForm->isValid())
      {
        $this->logger->debug(__CLASS__."->".__FUNCTION__."() - Formulaire valide -> redirection vers le formulaire de création");

        // on sauvegarde les informations dans le session
        $this->getUser()->setAttribute("preFormulaireInventeur", $request->getParameter($objForm->getName()));
        
        // redirection
        $this->redirect("referentiel_bpi/creerInventeur");
      }
    }

    // on vide la session
    else
    {
      $this->getUser()->setAttribute("preFormulaireInventeur", null);
    }

    $this->objForm = $objForm;
    
    $this->logger->debug(__CLASS__."->".__FUNCTION__."() - End");
  }

  public function postExecute() {}
}
