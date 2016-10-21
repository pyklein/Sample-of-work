<?php
/**
 * Export de la liste de resultat de la recherche transversale
 * @author Gabor JAGER
 */
class exporterView_recherchesCSVAction extends gridAction
{
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
  }
  
  public function execute($objRequete)
  {
    if (sfContext::hasInstance())
    {
      $this->logger->debug(__CLASS__."->".__FUNCTION__."() Start");
    }
    
    $strNomFichier = "export_dossiers_".date("YmdHis").".csv";

    $this->objFormFiltre = new View_rechercheFormFilter();
    $this->credentials = $this->getUser()->getAttribute('credentials');

    if ($this->getUser()->hasAttributeAction('filtre_view_recherches', "recherche/listerView_recherches"))
    {
      $this->logger->debug("Avec le filtre");

      $this->getUser()->setAttributeAction('filtre_view_recherches', $this->getUser()->getAttributeAction('filtre_view_recherches', null, "recherche/listerView_recherches"));
    }
    else
    {
      $this->logger->debug("Sans filtre");
    }

    $objRequeteDoctrine = $this->processFiltre();
    $objRequeteDoctrine = View_rechercheTable::getInstance()->getRequeteListe($objRequeteDoctrine);

    $arrResultatsDossiers = $objRequeteDoctrine->execute();

    // creation du fichier + téléchargement
    $this->creerFichier($strNomFichier, $arrResultatsDossiers);

    if (sfContext::hasInstance())
    {
      $this->logger->debug(__CLASS__."->".__FUNCTION__."() End");
    }
  }

  /**
   * Créer le fichier CSV
   * @param string $strNomFichier
   * @param View_recherche[] $arrResultatsDossiers
   * @author Gabor JAGER
   */
  private function creerFichier($strNomFichier, $arrResultatsDossiers=array())
  {
    $this->logger->debug("{".__CLASS__."} ".__FUNCTION__." - strNomFichier: ".$strNomFichier);

    $objUtilCsv = new UtilCsv($strNomFichier);

    // en tete
    $objUtilCsv->ajouterValeur(libelle("msg_libelle_metier"));
    $objUtilCsv->ajouterValeur(libelle("msg_libelle_intitule"));
    $objUtilCsv->ajouterValeur(libelle("msg_libelle_personnes_concernees"));
    $objUtilCsv->ajouterValeur(libelle("msg_libelle_date_creation"));
    $objUtilCsv->ajouterValeur(libelle("msg_libelle_statut_partage"));
    $objUtilCsv->ajouterLigne();

    // contenu
    foreach ($arrResultatsDossiers as $objDossier)
    {
      $objUtilCsv->ajouterValeur($objDossier->getMetier()->getIntitule());
      $objUtilCsv->ajouterValeur($objDossier->getTitre());

      $strPersonnesConcernees = "";
      foreach($objDossier->getPersonnesConcernes() as $intCle => $strPersonneConcerne)
      {
        $strPersonnesConcernees .= ($intCle == 0 ? "" : ", ").$strPersonneConcerne;
      }
      $objUtilCsv->ajouterValeur($strPersonnesConcernees);
      
      $objUtilCsv->ajouterValeur(formatDate($objDossier->getCreatedAt()));

      if ($objDossier->getEtatPartageId() == Etat_partageTable::PARTAGABLE)
      {
        $objUtilCsv->ajouterValeur(libelle("msg_libelle_partageable"));
      }
      else if ($objDossier->getEtatPartageId() == Etat_partageTable::PARTAGE)
      {
        $objUtilCsv->ajouterValeur(libelle("msg_libelle_partage"));
      }
      else
      {
        $objUtilCsv->ajouterValeur(libelle("msg_libelle_non_partageable"));
      }

      $objUtilCsv->ajouterLigne();
    }

    $this->logger->debug("{".__CLASS__."} ".__FUNCTION__." - telecharger");

    // on télécharge le fichier
    $objUtilCsv->telechargerFichier();
  }
}
