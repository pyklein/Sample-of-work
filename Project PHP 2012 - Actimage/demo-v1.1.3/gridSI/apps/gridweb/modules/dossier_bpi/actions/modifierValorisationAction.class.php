<?php
/**
 * Classe modifierValorisationAction
 * @author Gabor JAGER
 */
class modifierValorisationAction extends gridAction
{
  private $strSessionTokenCle = "session_valorisation_token";

  /**
   *
   * @var sfLogger
   */
  private $logger;

  public function preExecute()
  {
    if (sfContext::hasInstance())
    {
      $this->logger = $this->getLogger();
    }

    $this->objDossierBpi = Dossier_bpiTable::getInstance()->findOneById($this->getRequestParameter('dossier_bpi'));
    if (!$this->objDossierBpi)
    {
      if (sfContext::hasInstance())
      {
        $this->logger->err(__CLASS__."->".__FUNCTION__."() Le dossier ". $this->getRequestParameter('dossier_bpi')." n'existe pas.");
      }

      $this->redirect("@non_autorise");
    }
  }

  public function execute($request)
  {
    if (sfContext::hasInstance())
    {
      $this->logger->debug(__CLASS__."->".__FUNCTION__."() Start");
    }

    $srvToken = new ServiceToken();
    
    $this->strId = $request->getParameter('dossier_bpi');

    // valorisation BPI
    $objValorisationBpi = Valorisation_bpiTable::getInstance()->getValorisationBpiByDossierId($this->strId);
    if ($objValorisationBpi == null)
    {
      if (sfContext::hasInstance())
      {
        $this->logger->debug(__CLASS__."->".__FUNCTION__."() Creation de l'objet valorisation BPI.");
      }
      $objValorisationBpi = new Valorisation_bpi();
      $objValorisationBpi->setDossierBpiId($this->strId);
    }

    // formulaire de valorisation externe
    $this->objFormulaireValorisationExterne = new Session_valorisation_externeForm($this->strId);
    // formulaire de valorisation interne
    $this->objFormulaireValorisationInterne = new Session_valorisation_interneForm($this->strId);

    // formulaire de valorisation BPI
    $this->objFormulaireValorisationBpi = new Valorisation_bpiForm($this->strId, $objValorisationBpi);

    // on vérifie s'il y a des brevets déposés associés avec ce dossier ou pas
    $this->boolABrevetDepose = BrevetTable::getInstance()->hasBrevetDepose($this->strId);
    
    // Récupération ou création token en session
    if ($srvToken->hasToken($this->strSessionTokenCle)
            && $this->getUser()->getFlash('erreur', '') == ''
            && $request->getParameter('start') != 'true')
    {
      $this->transactionToken = $srvToken->getToken($this->strSessionTokenCle);
      
      // cas POST 'Enregistrer les modifications'
      if ($request->isMethod('post')
              && !($request->hasParameter('externe') 
                || $request->hasParameter('interne')))
      {
        $arrValeursFormulaire = $this->getRequestParameter($this->objFormulaireValorisationBpi->getName());
        $this->objFormulaireValorisationBpi->bind($arrValeursFormulaire);

        if ($this->objFormulaireValorisationBpi->isValid())
        {
          try
          {
            if (sfContext::hasInstance())
            {
              $this->logger->debug(__CLASS__."->".__FUNCTION__."() Enregistrement global");
            }
            Valorisation_bpiTable::getInstance()->enregistrerModificationSession($this->transactionToken, $this->strId, $arrValeursFormulaire);

            $this->getUser()->setFlash('succes', libelle('msg_libelle_enregistrer_succes'));
          }

          catch (Exception $ex)
          {
            if (sfContext::hasInstance())
            {
              $this->logger->err(__CLASS__."->".__FUNCTION__."() Erreur: ".$ex->getMessage());
            }
            $this->getUser()->setFlash("erreur", libelle("msg_libelle_erreur_enregistrement"));
          }
        }

        // erreur de formulaire
        else
        {
          if (sfContext::hasInstance())
          {
            $this->logger->err(__CLASS__."->".__FUNCTION__."() Formulaire erreur");
          }
        }
      }

      // cas ajout d'une valorisation externe
      else if ($request->hasParameter('externe'))
      {
        $this->ajouterOrganisme($this->objFormulaireValorisationExterne);
      }

      // cas ajout d'une valorisation interne
      else if ($request->hasParameter('interne'))
      {
        $this->ajouterOrganismeMindef($this->objFormulaireValorisationInterne);
      }
    }
    
    // cas GET
    else
    {
      if (sfContext::hasInstance())
      {
        $this->logger->debug(__CLASS__."->".__FUNCTION__."() Nettoyer le token.");
      }

      // nettoyer base pour ancien token
      $strAncienToken = $srvToken->getToken($this->strSessionTokenCle);
      
      if ($strAncienToken != '')
      {
        Session_valorisation_externeTable::getInstance()->nettoyerAncienneSession($strAncienToken);
        Session_valorisation_interneTable::getInstance()->nettoyerAncienneSession($strAncienToken);
      }

      // création nouveau token
      $this->transactionToken = $srvToken->creerToken($this->strSessionTokenCle, "d".$this->strId);
      if ($request->getParameter('start') == 'true')
      {

        if (sfContext::hasInstance())
        {
          $this->logger->debug(__CLASS__."->".__FUNCTION__."() Initialisation des données.");
        }

        // on charge les données dans la table de session
        Session_valorisation_externeTable::getInstance()->initDonnees($this->transactionToken, $this->strId);
        Session_valorisation_interneTable::getInstance()->initDonnees($this->transactionToken, $this->strId);

        $this->reload();
      }
    }

    if (sfContext::hasInstance())
    {
      $this->logger->debug(__CLASS__."->".__FUNCTION__."() Recuperation des listes.");
    }

    // Liste des valorisations externes
    $this->arrValorisationExternes = Session_valorisation_externeTable::getInstance()->getValorisationsExternesSessionByToken($this->transactionToken);
    // Liste des valorisations internes
    $this->arrValorisationInternes = Session_valorisation_interneTable::getInstance()->getValorisationsInternesSessionByToken($this->transactionToken);


    if (sfContext::hasInstance())
    {
      $this->logger->debug(__CLASS__."->".__FUNCTION__."() End");
    }
  }
  

  /**
   * Ajout un organisme externe à la liste (temporaire)
   */
  protected function ajouterOrganisme(Session_valorisation_externeForm &$objFormulaire)
  {
    if (sfContext::hasInstance())
    {
      $this->logger->debug(__CLASS__."->".__FUNCTION__."() Start");
    }

    $arrValeurs = $this->getRequestParameter($objFormulaire->getName());
    $arrValeurs["transaction_token"] = $this->transactionToken;
    $objFormulaire->bind($arrValeurs);

    if ($objFormulaire->isValid())
    {
      try
      {
        if (sfContext::hasInstance())
        {
          $this->logger->debug(__CLASS__."->".__FUNCTION__."() Enregistrement");
        }
        $objFormulaire->save();
        $objFormulaire = new Session_valorisation_externeForm($this->strId);
      }

      catch (Exception $ex)
      {
        if (sfContext::hasInstance())
        {
          $this->logger->err(__CLASS__."->".__FUNCTION__."() Erreur: ".$ex->getMessage());
        }
        $this->getUser()->setFlash("erreur", libelle("msg_erreur"));
      }
    }

    // erreur de formulaire
    else
    {
      if (sfContext::hasInstance())
      {
        $this->logger->err(__CLASS__."->".__FUNCTION__."() Formulaire erreur");
      }
    }

    if (sfContext::hasInstance())
    {
      $this->logger->debug(__CLASS__."->".__FUNCTION__."() End");
    }
  }

  /**
   * Ajout un organisme interne à la liste (temporaire)
   * @param Integer $intInventeurId Identifiant de l'inventeur à ajouter
   */
  protected function ajouterOrganismeMindef(Session_valorisation_interneForm &$objFormulaire)
  {
    if (sfContext::hasInstance())
    {
      $this->logger->debug(__CLASS__."->".__FUNCTION__."() Start");
    }

    $arrValeurs = $this->getRequestParameter($objFormulaire->getName());
    $arrValeurs["transaction_token"] = $this->transactionToken;
    $objFormulaire->bind($arrValeurs);

    if ($objFormulaire->isValid())
    {
      try
      {
        if (sfContext::hasInstance())
        {
          $this->logger->debug(__CLASS__."->".__FUNCTION__."() Enregistrement");
        }
        $objFormulaire->save();
        $objFormulaire = new Session_valorisation_interneForm($this->strId);
      }

      catch (Exception $ex)
      {
        if (sfContext::hasInstance())
        {
          $this->logger->err(__CLASS__."->".__FUNCTION__."() Erreur: ".$ex->getMessage());
        }
        $this->getUser()->setFlash("erreur", libelle("msg_erreur"));
      }
    }

    // erreur de formulaire
    else
    {
      if (sfContext::hasInstance())
      {
        $this->logger->err(__CLASS__."->".__FUNCTION__."() Formulaire erreur");
      }
    }

    if (sfContext::hasInstance())
    {
      $this->logger->debug(__CLASS__."->".__FUNCTION__."() End");
    }
  }

  /**
   * recharge la page
   */
  protected function reload()
  {
    $this->redirect($this->getModuleName().'/modifierValorisation?dossier_bpi='.$this->getRequest()->getParameter('dossier_bpi'));
  }
}
