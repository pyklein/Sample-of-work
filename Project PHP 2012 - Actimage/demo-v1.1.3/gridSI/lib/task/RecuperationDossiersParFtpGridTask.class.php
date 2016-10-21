<?php

include(sfConfig::get("sf_lib_dir") . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "ftp" . DIRECTORY_SEPARATOR . "ftp.class.php");

/**
 * Tâche de récupération des dossiers sur le serveur FTP
 *
 * @author Alexandre WETTA
 */
class RecuperationDossiersParFtpGridTask extends GridTask {

  /**
   * Configuration de la tâche: lancer avec :  php symfony grid:recuperation_dossier_ftp --application=gridweb
   * @param   Console   application   spécifie l'application dont la configuration doit être chargée
   * @param   Console   env           spécifie l'environnement dont la configuration doit être chargée
   */
  protected function configure() {

    $this->app              = 'gridweb';
    $this->namespace        = 'grid';
    $this->name             = 'recuperation_dossier_ftp';
    $this->briefDescription = 'Récupération des dossiers par FTP';

    parent::configure();
  }

  protected function execute($arguments = array(), $options = array()) {

    // init d'execution
    $this->debut($arguments, $options);

    $this->logSection(__FUNCTION__."()", "-> DEBUT");

    $utilArbo = new ServiceArborescence();
    try {

      //connexion au serveur FTP
      $ftp = new Ftp();
      $ftp->connect(sfConfig::get('app_ftp_adresse'), sfConfig::get('app_ftp_port'));
      $ftp->login(sfConfig::get('app_ftp_utilisateur'), sfConfig::get('app_ftp_motdepasse'));

      //on va dans le repertoire grid
      $ftp->chdir(sfConfig::get('app_ftp_dir_grid'));


      //On prend la liste des répertoires contenant la liste des dossiers
      $arrListeRepContenant = $ftp->nlist(".");

      foreach ($arrListeRepContenant as $repContenant){

        //on enlève le "./" devant le nom
        $repContenant = substr($repContenant, 2);
        
        //on essaye de rentrer dans le dossier
        if ($ftp->trychdir($repContenant)) {
          
        
        //on cherche dans la base de données si ce dossier a déjà été téléchargé
        $objDossierACopierExiste  = Ftp_dossier_recupereTable::getInstance()->findOneByNomDossierRecupere($repContenant);

        //date et heure du dossier contenant
        $dateHeureDossierContenant = date_create_from_format("Ymd_Hi", $repContenant);

        //conversion en date anglaise
        $dateFormatAnglaisDossierContenant = date_format($dateHeureDossierContenant, 'Y-m-d H:i:s');
        $boolCheckDateDossierContenant = false;
        
        //on vérifie si la date du dossier est inférieure à la date du jour (+ ajout d'un délai paramètrable)
        if(strtotime($dateFormatAnglaisDossierContenant . " + ".sfConfig::get('app_ftp_delai') . " minutes") < strtotime("now") ){
           $boolCheckDateDossierContenant = true;
        }

          //On vérifie que la date est correcte
          if($boolCheckDateDossierContenant == true){
            //on vérifie qu'il n'existe pas dans la base pour le copier
            if(!$objDossierACopierExiste) {

              //on essaye de créer le repertoire du dossier
              $repContenantACopier = $utilArbo->getRepertoireImportationIXarmCourant() . DIRECTORY_SEPARATOR . $repContenant;

              $utilFichier = new UtilFichier();
              $boolReussi = false;
              try {
                $utilFichier->creerRepertoire($repContenantACopier);
                $boolReussi = true;
              } catch (Exception $ex) {}

              if ($boolReussi) {
                $this->logSection(__FUNCTION__ . "()", "-> Creation dossier:" . $repContenant);

                //mise à jour de la base de données
                $this->logSection(__FUNCTION__ . "()", "-> MAJ Base de données pour: ".$repContenant);
                $objFtpDossierRecupere = new Ftp_dossier_recupere();
                $objFtpDossierRecupere->setNomDossierRecupere($repContenant);
                $objFtpDossierRecupere->setDateDebut(date('Y-m-d H:i:s'));
                $objFtpDossierRecupere->save();

                //on prend la liste des fichiers et répertoires
                $arrListeRepertoire = $ftp->nlist(".");

                //on boucle sur la liste des fichiers/dossiers trouvés
                foreach ($arrListeRepertoire as $fichier) {
                  //on enlève le "./" devant le nom
                  $fichier = substr($fichier, 2);
                  //on essaye de rentrer dans le dossier (si c'est un dossier)
                  if ($ftp->trychdir($fichier)) {

                    //on cherche dans la base de données si ce dossier a déjà été téléchargé
                    $objDossierRecherche = Ftp_recuperationTable::getInstance()->findOneByNomDossier($fichier);

                    // s'il n'existe pas dans la base on le copie dans grid
                    if (!$objDossierRecherche) {
                      //on essaye de créer le repertoire du dossier
                      $strDossierACopier = $repContenantACopier . DIRECTORY_SEPARATOR . $fichier;

                      $utilFichier = new UtilFichier();
                      $boolReussi = false;
                      try {
                        $utilFichier->creerRepertoire($strDossierACopier);
                        $boolReussi = true;
                      } catch (Exception $ex) {}

                      if ($boolReussi) {

                        $this->logSection(__FUNCTION__ . "()", "-> Creation dossier:" . $fichier);

                        //mise à jour de la base de données
                        $this->logSection(__FUNCTION__ . "()", "-> MAJ Base de donnees pour: ".$fichier);
                        $objFtpRecuperation = new Ftp_recuperation();
                        $objFtpRecuperation->setNomDossier($fichier);
                        $objFtpRecuperation->setDateDebut(date('Y-m-d H:i:s'));
                        $objFtpRecuperation->save();

                        $arrListeFichierEnCours = $ftp->nlist(".");
                        //on parcourt la liste des fichiers pour les copier
                        foreach ($arrListeFichierEnCours as $fichierDansDossier) {

                          $fichierDansDossier = substr($fichierDansDossier, 2);
                          $strFichierLocal = $strDossierACopier . DIRECTORY_SEPARATOR . $fichierDansDossier;
                          if ($ftp->get($strFichierLocal, $fichierDansDossier, FTP_BINARY)) {
                            $this->logSection(__FUNCTION__ . "()", "->Telechargement du fichier: " . $fichierDansDossier);
                          } else {
                            $this->logSection(__FUNCTION__ . "()", "->Telechargement du fichier ". $fichierDansDossier . ' impossible');
                          }
                        }
                        $this->logSection(__FUNCTION__ . "()", "-> MAJ Base de donnees pour: ".$fichier);
                        $objFtpRecuperation->setDateFin(date('Y-m-d H:i:s'));
                        $objFtpRecuperation->save();

                      } else {
                        $this->logSection(__FUNCTION__ . "()", "->Creation dossier " . $fichier . ' impossible');
                      }
                    }

                    //on revient au dossier parent
                    $ftp->chdir("..");

                  } else {
                    //on récupère le fichier XML
                    $strFichierLocal = $repContenantACopier . DIRECTORY_SEPARATOR . $fichier;
                    if ($ftp->get($strFichierLocal, $fichier, FTP_BINARY)) {
                      $this->logSection(__FUNCTION__."()", "->Telechargement du fichier: " . $fichier);
                    } else {
                      $logger->err('Telechargement du fichier ' . $fichierDansDossier . ' impossible');
                    }
                  }
                }

                //MAJ BDD
                $this->logSection(__FUNCTION__ . "()", "-> MAJ Base de donnees pour: ".$repContenant);
                $objFtpDossierRecupere->setDateFin(date('Y-m-d H:i:s'));
                $objFtpDossierRecupere->save();
              }else {
                $this->logSection(__FUNCTION__ . "()", "->Creation dossier " . $repContenant . ' impossible');
              }
              
            }

          }else{
            $this->logSection(__FUNCTION__ . "()", "->Creation dossier " . $repContenant . ' impossible -> Erreur sur le format de la date ou dossier trop jeune');
          }
          //on revient au dossier parent
          $ftp->chdir("..");
        }

      }
      
      $this->logSection(__FUNCTION__."()","-> FIN");

      // fin d'execution
      $this->fin(false, libelle("msg_tache_sans_erreur"));

    } catch (Exception $e) {
       $this->logSection(__FUNCTION__."()"," -> ERROR: ".$e->getMessage());

       // fin d'execution
       $this->fin(true, $e->getMessage());
    }

  }
}
