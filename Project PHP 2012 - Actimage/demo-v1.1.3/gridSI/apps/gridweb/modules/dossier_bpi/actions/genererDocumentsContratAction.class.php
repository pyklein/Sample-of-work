<?php

/**
 * Description of genererDocumentsContratAction
 *
 * @author Simeon Petev
 */
class genererDocumentsContratAction extends gridAction
{
  public function  preExecute()
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    $idContrat = $this->getRequest()->getParameter('id');

    $this->objContrat = ContratTable::getInstance()->findOneById(($idContrat) ? $idContrat : 0);

    if (($this->objContrat == null) || ($this->objContrat->getId()==0))
    {
      if ($idContrat != null)
      {
        $this->getUser()->setFlash("erreur", libelle('msg_contrat_droit'));
      }

      $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN AVANT REDIRECTION; ");

      $this->redirect(url_for('dossier_bpi/listerDossier_bpis'));
    }

    $arrTypesContrat = $this->objContrat->getType_contrats();
    $this->boolEstTypeLicence = false;
    $this->boolEstTypeCoprop = false;

    foreach ($arrTypesContrat as $objType)
    {
      if ($objType->getId() == Type_contratTable::Licence)
      {
        $this->boolEstTypeLicence = true;
      }

      if ($objType->getId() == Type_contratTable::Reglement)
      {
        $this->boolEstTypeCoprop = true;
      }
    }

    $boolHasBrevet = (count($this->objContrat->getBrevet()) > 0);

    //On redirige si le contrat n'a pas le type demandé ou s'il n'existe pas de brevet assigné
    if ((!$this->boolEstTypeLicence && !$this->boolEstTypeCoprop) || !$boolHasBrevet)
    {
      $this->getUser()->setFlash("warning", libelle('msg_contrat_aucun_document'));
      
      $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN AVANT REDIRECTION; ");

      $this->redirect(url_for('dossier_bpi/listerContrats?dossier_bpi_id='.$this->objContrat->getDossierBpiId()));
    }

    parent::preExecute();

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }

  public function  execute($request)
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    $objRequeteWeb = $this->getRequest();

    try
    {
      $objDocumentService = new ServiceDocumentBpi();

      // télécharger la lettre d'accompagnement de licence
      if ($objRequeteWeb->hasParameter("licence"))
      {
        $strFichier = $objDocumentService->creerDocumentLettreAccompagnementLicence($this->objContrat->getId(), $objRequeteWeb->hasParameter("organisme_id"));
        $this->redirect("interface/telechargerDocumentTemporaire?fichier=".$strFichier);
      }

      // télécharger la lettre d'accompagnement de copropriété
      else if ($objRequeteWeb->hasParameter("copropriete"))
      {
        $strFichier = $objDocumentService->creerDocumentLettreAccompagnementCopropriete($this->objContrat->getId(), $objRequeteWeb->hasParameter("organisme_id"));
        $this->redirect("interface/telechargerDocumentTemporaire?fichier=".$strFichier);
      }
    }
    catch(Exception $ex)
    {
      $this->getUser()->setFlash('erreur', $ex->getMessage());
    }

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }

  public function  postExecute()
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    parent::postExecute();

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }
}
?>
