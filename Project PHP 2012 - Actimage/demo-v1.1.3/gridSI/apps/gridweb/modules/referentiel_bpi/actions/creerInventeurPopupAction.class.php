<?php

/**
 * Action de création d'un inventeur dans un popup
 * @author Jihad Sahebdin
 */
class creerInventeurPopupAction extends gridAction
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
    if(!$request->hasParameter("dossier_bpi"))
    {
      $this->redirect("@non_autorise");
    }

    $this->intDossierId = $request->getParameter("dossier_bpi");

    $this->logger->debug(__CLASS__."->".__FUNCTION__."() - Start");

    $arrValeursPreformulaire = $this->getUser()->getAttribute("preFormulaireInventeur");
    
    // on crée l'objet à partir des données de pre-formulaire
    $objInventeur = new Inventeur();
    $objInventeur->setNom($arrValeursPreformulaire["nom"]);
    $objInventeur->setEstExterieur($arrValeursPreformulaire["est_exterieur"] ? true : false);


    //Creation d'un formulaire avec les popups désactivés
    $this->objForm = new InventeurForm(false, $objInventeur);
    
    // on recharge le formulaire avec les villes (version sans Javascript)
    if ($request->isMethod('post') && $request->hasParameter("chargerVilles"))
    {
      $this->objForm->bind($request->getParameter($this->objForm->getName()));
    }

    // submit de formulaire
    else if($request->isMethod('post'))
    {
      $this->logger->debug(__CLASS__."->".__FUNCTION__."() - Post");

      // on bind le formulaire
      $this->objForm->bind($request->getParameter($this->objForm->getName()));

      if ($this->objForm->isValid())
      {
        $this->objForm->save();
        $this->logger->debug(__CLASS__."->".__FUNCTION__."() - Formulaire valide -> redirection vers le formulaire de création");

        // on sauvegarde les informations dans le session
        $this->getUser()->setAttribute("FormulaireInventeur", $this->objForm->getObject());

        // redirection
        $this->redirect("dossier_bpi/modifierSituation_inventeurs?dossier_bpi=".$this->intDossierId);
      }
    }
    $this->logger->debug(__CLASS__."->".__FUNCTION__."() - End");
  }

  public function postExecute() {}
}
