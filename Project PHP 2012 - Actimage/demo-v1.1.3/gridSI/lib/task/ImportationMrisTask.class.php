<?php

/**
 * Description of TestSerialisationTask
 *
 * @author William
 */
class ImportationsMrisTask extends GridTask {

  protected function configure() {

    $this->app              = 'gridweb';
    $this->namespace        = 'grid';
    $this->name             = 'importation_mris';
    $this->briefDescription = 'Importation des dossiers iXarms récupérés par FTP';

    parent::configure();
  }

  protected function execute($arguments = array(), $options = array()) {

    // init d'execution
    $this->debut($arguments, $options);

    $utilFichier = new UtilFichier();
    $utilArbo = new ServiceArborescence();
    $repertoireImport = $utilArbo->getRepertoireImportationIXarmCourant();
    $arrRepertoiresATraiter = $utilFichier->listerContenu($repertoireImport);
    $fichierImport = sfConfig::get("app_importation_ixarm_fichier");
    try {
      $parser = new Dossier_mrisParser($this->logger);
      $resultatImportation = array();
      foreach ($arrRepertoiresATraiter as $strRepertoire){
        if (is_dir($repertoireImport.$strRepertoire)){
          array_merge($resultatImportation, $parser->importerDossiers($repertoireImport.$strRepertoire . DIRECTORY_SEPARATOR . $fichierImport));
        }
      }
      $dossierImportes = array();
      $arrErreursCritiques = array();
      foreach ($resultatImportation as $dossier) {
        if ($dossier[0]) {
          $dossierImportes[] = $dossier;
        } else {
          $arrErreursCritiques[] = $dossier[1];
        }
      }
      $arrSupMris = UtilisateurTable::getInstance()->getSuperUtilisateursMris();

      if (!empty($dossierImportes)){
      $gestionnaireMail = new GestionnaireMail();
      $strContenuMail = get_partial('email/contenuMailSuiviImportationsIXarm', array('arrErreurs' => $arrErreursCritiques, 'arrDossiers' => $dossierImportes, 'intCompteDossiers' => count($resultatImportation)));
      $gestionnaireMail->envoyerMailImportationIXarm($arrSupMris, $strContenuMail);
      $strRepertoireArchive = $utilArbo->getRepertoireImportationIXarm(). "Archive_" . date('Y_m_d');
      $utilFichier->moveContenuRepertoire($repertoireImport, $strRepertoireArchive);
      }

      // fin d'execution
      $this->fin(false, libelle("msg_tache_sans_erreur"));

    } catch (Exception $ex) {

      $this->logSection($this->name, "Erreur: ".$ex->getMessage());
      
      // fin d'execution
      $this->fin(true, $ex->getMessage());
    }
  }

}
