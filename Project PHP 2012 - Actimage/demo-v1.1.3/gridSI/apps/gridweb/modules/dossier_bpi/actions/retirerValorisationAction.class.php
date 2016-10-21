<?php
/**
 * Description of retirerInnovateurAction
 *
 * @author Gabor JAGER
 */
class retirerValorisationAction extends gridAction
{
  private $strSessionTokenCle = "session_valorisation_token";

  /**
   *
   * @var sfLogger
   */
  private $logger;

  /**
   *
   * @var Dossier_bpi
   */
  private $objDossierBpi;

  public function preExecute()
  {
    $this->logger = $this->getLogger();
    
    if (sfContext::hasInstance())
    {
      $this->logger->debug(__CLASS__."->".__FUNCTION__."() Start");
    }

    if (!$this->hasRequestParameter('dossier_bpi')
            || !($this->hasRequestParameter('interne') || $this->hasRequestParameter('externe')))
    {
      if (sfContext::hasInstance())
      {
        $this->logger->err(__CLASS__."->".__FUNCTION__."() Il maque des paramètre: dossier_bpi=".$this->getRequestParameter('dossier_bpi').", interne=".$this->getRequestParameter('interne').", externe=".$this->getRequestParameter('externe'));
      }

      $this->redirect("@non_autorise");
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
    
    if (sfContext::hasInstance())
    {
      $this->logger->debug(__CLASS__."->".__FUNCTION__."() End");
    }
  }
  
  public function execute($request)
  {
    if (sfContext::hasInstance())
    {
      $this->logger->debug(__CLASS__."->".__FUNCTION__."() Start");
    }

    $srvToken = new ServiceToken();

    $strId = $request->getParameter('dossier_bpi');

    $strToken = $srvToken->getToken($this->strSessionTokenCle);

    if ($request->hasParameter("interne"))
    {
      $objSession = Session_valorisation_interneTable::getInstance()->findOneById($request->getParameter("interne"));
    }

    else if ($request->hasParameter("externe"))
    {
      $objSession = Session_valorisation_externeTable::getInstance()->findOneById($request->getParameter("externe"));
    }

    if (!$objSession)
    {
      if (sfContext::hasInstance())
      {
        $this->logger->err(__CLASS__."->".__FUNCTION__."() L'objet de session n'existe pas.");
      }

      $this->redirect("@non_autorise");
    }

    else if ($objSession->getTransactionToken() != $strToken)
    {
      if (sfContext::hasInstance())
      {
        $this->logger->err(__CLASS__."->".__FUNCTION__."() Le token de l'objet session ".$objSession->getTransactionToken()." n'est pas identique au token d'utilisateur ".$strToken.".");
      }

      $this->redirect("@non_autorise");
    }

    try
    {
      $objSession->delete();
    }

    catch (Exception $ex)
    {
      if (sfContext::hasInstance())
      {
        $this->logger->err(__CLASS__."->".__FUNCTION__."() Erreur : ".$ex->getTraceAsString().".");
      }
    }

    $this->redirect('dossier_bpi/modifierValorisation?dossier_bpi='.$this->getRequestParameter('dossier_bpi'));
  }
}
