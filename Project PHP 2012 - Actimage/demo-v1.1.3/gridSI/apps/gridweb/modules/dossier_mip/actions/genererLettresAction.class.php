<?php

/**
 * Générer les lettres
 * @author Gabor JAGER
 */
class genererLettresAction extends gridAction
{
  private $logger;

  public function preExecute()
  {
    $this->logger = sfContext::getInstance()->getLogger();
    
    parent::preExecute();
  }

  public function execute($objRequeteWeb)
  {
    $this->logger->debug(__CLASS__."->".__FUNCTION__."() - Start");

    if (!$objRequeteWeb->hasParameter('id'))
    {
      $this->logger->err(__CLASS__."->".__FUNCTION__."() - pas d'ID.");
      $this->redirect("@non_autorise");
    }

    // telechargement de lettre
    if ($objRequeteWeb->hasParameter('cle'))
    {
      $this->telechargerLettre($objRequeteWeb);
    }

    $this->strId = $objRequeteWeb->getParameter('id');

    $this->objDossierMip = Dossier_mipTable::getInstance()->findOneById($this->strId);
    if (!$this->objDossierMip)
    {
      $this->logger->err(__CLASS__."->".__FUNCTION__."() - pas de dossier avec l'ID : ".$this->strId);
      $this->redirect("@non_autorise");
    }

    $this->intNbInnovateurs = $this->objDossierMip->getInnovateurs()->count();
    $this->arrInnovateurs = $this->objDossierMip->getInnovateurs();
	
	$this->boolFinancements = FinancementTable::getInstance()->retreveFinancementsOrdreDescDate($this->strId)->count() > 0;
    
    $this->logger->debug(__CLASS__."->".__FUNCTION__."() - End");
  }

  private function telechargerLettre(sfWebRequest $objRequeteWeb)
  {
    $strId  = $objRequeteWeb->getParameter("id");
    $strCle = $objRequeteWeb->getParameter("cle");
    $intIdInnovateur = 0;
    
    if($objRequeteWeb->hasParameter("innov"))
    {
      $intIdInnovateur = $objRequeteWeb->getParameter("innov");
    }


    $objModeleLettre = Modele_lettreTable::getInstance()->getModeleLettreParCle($strCle);

    if (!$objModeleLettre->estDisponible())
    {
      $this->getUser()->setFlash("erreur", libelle("msg_libelle_modele_nexiste_pas"));
      return;
    }

    $objDocumentService = new ServiceDocumentMip();
	try {
		if($intIdInnovateur == 0)
		{
		  $strFichier = $objDocumentService->creerDocumentMip($strId, $strCle);
		}
		else
		{
		  $strFichier = $objDocumentService->creerDocumentMipAvecInnovateurId($strId, $strCle, $intIdInnovateur);
		}
	} catch(Exception $e) {
	  $this->getUser()->setFlash("erreur", libelle("msg_libelle_modele_erreurgeneration").". ".$e->getMessage());
      return;
	}

    $this->redirect("interface/telechargerDocumentTemporaire?fichier=".$strFichier);
  }
}
