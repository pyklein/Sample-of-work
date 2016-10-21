<?php
/**
 * Components pour visualiser un dossier BPI
 * @author Jihad Sahebdin
 */
class dossier_bpiComponents extends sfComponents
{
  public function executeVoirDescriptionDossier_bpi(sfWebRequest $request)
  {
    $this->dossierId = $request->getParameter('id');
    $this->credentials = $this->getUser()->getAttribute('credentials');
    $this->strId = $this->dossierId;
    $this->objDossierBpi = Dossier_bpiTable::getInstance()->findOneById($this->dossierId);
    $this->objDocumentsJoints = Documents_bpiTable::getInstance()->retrieveDocumentsByDossierNotInvisible($this->dossierId,true);
	$this->objDocumentsReferences = Documents_bpiTable::getInstance()->retrieveDocumentsByDossierNotInvisible($this->dossierId,false);
    //On vérifie s'il existe des dossiers Mip liés au dossier courant
    $this->intNbLiaisons = Dossier_mip_dossier_bpiTable::getInstance()->retrieveDossiersMIPByDossiersBPI($this->dossierId)->count();
    $this->arrDossiersLies = Dossier_mipTable::getInstance()->retrieveDossiersMipByDossierBpi($this->dossierId)->execute();

    $this->intNbInventeurs = 0;
    foreach($this->objDossierBpi->getInventeurs() as $objInventeur)
    {
      $this->intNbInventeurs++;
    }

    $this->intNbActions = ActionTable::getInstance()->getActionsMeneesByDossierBpi($this->dossierId)->count();
    $this->arrActions = ActionTable::getInstance()->getActionsMeneesByDossierBpi($this->dossierId)->execute();

    $this->intNbRemarques = Remarque_bpiTable::getInstance()->retrieveRemarqueParDossierBpi($this->dossierId)->count();
    $this->arrRemarques = Remarque_bpiTable::getInstance()->retrieveRemarqueParDossierBpi($this->dossierId)->execute();

    //fieldset contentieux
    $this->boolContentieuxExiste = false;
    $this->boolCnisExiste = false;
    //on retrouve les parts inventives du dossier BPI
    $arrPartInventive = Part_inventiveTable::getInstance()->findByDossierBpiId($this->dossierId);

    foreach ($arrPartInventive as $objPartInventive) {
      $arrContentieux = ContentieuxTable::getInstance()->findByPartInventiveId($objPartInventive->getId());
      foreach ($arrContentieux as $objContentieux) {
        if ($objContentieux->getEstDesaccord()) {
          $this->boolContentieuxExiste = true;
          if ($objContentieux->getDateDemandeCnis() != null) {
            $this->boolCnisExiste = true;
          }
        }
      }
    }

  }

  public function executeVoirBrevetsEtContratsDossier_bpi(sfWebRequest $request)
  {
    $this->dossierId = $request->getParameter('id');
    $this->credentials = $this->getUser()->getAttribute('credentials');
    $this->strId = $this->dossierId;
    $this->objDossierBpi = Dossier_bpiTable::getInstance()->findOneById($this->dossierId);
    
    $this->arrBrevets = BrevetTable::getInstance()->retrieveBrevets($this->dossierId)->execute();
    $this->arrBrevetsHeader =  BrevetTable::getInstance()->retrieveBrevetsParOrdreDateDepot($this->dossierId)->execute();

    $this->intNbContrats = ContratTable::getInstance()->buildQueryContratOrdreAscPourSelectbox($this->dossierId)->count();
    $this->arrContrats = ContratTable::getInstance()->buildQueryContratOrdreAscPourSelectbox($this->dossierId)->execute();

  }

  public function executeVoirValorisationEtRecompensesDossier_bpi(sfWebRequest $request)
  {
    $this->dossierId = $request->getParameter('id');
    $this->strId = $this->dossierId;
    $this->objDossierBpi = Dossier_bpiTable::getInstance()->findOneById($this->dossierId);

    $this->objValorisation = Valorisation_bpiTable::getInstance()->getValorisationBpiByDossierId($this->dossierId);
    $this->arrValorisationExternes = Valorisation_externeTable::getInstance()->getValorisationsExternesByDossierId($this->dossierId);
    $this->arrValorisationInternes = Valorisation_interneTable::getInstance()->getValorisationsInternesByDossierId($this->dossierId);
  
    $this->arrExploitation = Exploitation_bpiTable::getInstance()->getExploitationParDossierBpi($this->dossierId);
  
    $this->arrRedevances = RedevanceTable::getInstance()->retrieveRedevances($this->dossierId)->execute();

    $this->arrInventeurs = $this->objDossierBpi->getInventeurs();

//      $this->arrExploitationExterne = Exploitation_externeTable::getInstance()->getExploitationExterneParDossierParInventeur($this->dossierId,$this->objInventeur->getId());
    
//      foreach ($this->arrExploitationExterne as $objExploitation)
//      {
//        echo $objExploitation." _ ";
//      }

    $this->intNbExploitationExterne = Exploitation_externeTable::getInstance()->getExploitationExterneParDossier($this->dossierId);
    $this->intNbExploitationInterne = Exploitation_interneTable::getInstance()->getExploitationInterneParDossier($this->dossierId);
    
  }
}

