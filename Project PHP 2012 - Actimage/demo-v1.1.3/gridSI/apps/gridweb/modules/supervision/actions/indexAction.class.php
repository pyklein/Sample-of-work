<?php

/**
 * index Supervision
 * @author Alexandre WETTA
 * @author Julien GAUTIER
 */

class indexAction extends sfAction
{
  public function execute($request)
  {
    $this->getContext()->getConfiguration()->loadHelpers('Libelle');

    //Demande de réinitialisation du compteur effectuée
    if ($request->isMethod('post')) {
      $this->redirect('supervision/confirmation');
    }
    $objUtilArbo = new ServiceArborescence();
    /*
     * Camenbert sur l'espace disque
     */
    // espace disque total en octet
    $dt = disk_total_space($objUtilArbo->getRepertoireTemporaire());
    $totalspace = $dt;
    //espace disque disponible en octet
    $df = disk_free_space($objUtilArbo->getRepertoireTemporaire());
    $freespace = $df;
    //taille en MO de l'espace disque utilisé
    $usedspace = $totalspace - $freespace;

    //Purge des anciennes images
    $utilFichier = new UtilFichier();
    $utilFichier->purgerFichiers($objUtilArbo->getRepertoireTemporaire(), "(chart).*(\.png)", 60);

    $srvChart = new ServiceChart(sfConfig::get('app_image_genere_largeur') / 2, sfConfig::get('app_image_genere_hauteur') / 2);
    $titre = libelle_graphiques("msg_supervision_espace_disque_titre");
    $donnees = array( $freespace, $usedspace) ;
    $utilPhp = new ServiceFichier();
    $libelleDisponible = libelle_graphiques("msg_supervision_espace_disque_disponible", array($utilPhp->getHumanReadableSize($freespace)) );
    $libelleUtilise = libelle_graphiques("msg_supervision_espace_disque_utilise", array($utilPhp->getHumanReadableSize($usedspace)) );
    $libelle = array($libelleDisponible, $libelleUtilise);

    //Création du graphique
    $srvChart->creerEntete($libelle, $donnees, true);
    $srvChart->getObjetGraphique()->drawPieGraph($srvChart->getObjetConfiguration()->GetData(), $srvChart->getObjetConfiguration()->GetDataDescription(), 180, 130, 110, PIE_PERCENTAGE, FALSE, 50, 20, 5);
    $srvChart->getObjetGraphique()->drawPieLegend(280, 15, $srvChart->getObjetConfiguration()->GetData(), $srvChart->getObjetConfiguration()->GetDataDescription(), 250, 250, 250);
    $srvChart->creerTitre($titre);
    $srvChart->genererGraphique();

    $this->nomChart = $srvChart->creerCamembert($libelle, $donnees, $libelle, "chart", "", "", PIE_PERCENTAGE) ;

    /**
     * Compteur de visites
     */
    $lastEntryObj = ConnexionTable::getInstance()->getLastEntry();
    if ($lastEntryObj) {
     $this->cptrValue = $lastEntryObj->getCompteur();
     $this->dateHistoCompteur = $lastEntryObj->getDateTimeObject('date_debut')->format('d/m/Y');
    } else {
     $lastEntryObj = ConnexionTable::getInstance()->reinitCompteur();
     $this->cptrValue = $lastEntryObj->getCompteur();
     $this->dateHistoCompteur = $lastEntryObj->getDateTimeObject('date_debut')->format('d/m/Y');
    }
  }
}

