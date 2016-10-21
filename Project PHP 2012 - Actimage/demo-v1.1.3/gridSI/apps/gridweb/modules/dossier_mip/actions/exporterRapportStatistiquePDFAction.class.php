<?php

/**
 * Description of exporterRapportStatistiquePDFAction
 *
 * @author William
 */
class exporterRapportStatistiquePDFAction extends gridAction {

  public function execute($request) {
    $this->pdf = 1;


    $this->objFormFiltre = new Dossier_mipStatistiquesFormFilter();
    $strFilterName = $this->objFormFiltre->getName();
    if ($this->getUser()->hasAttributeAction('filtre_dossier_mips', "dossier_mip/voirRapportStatistique")) {
      $this->getUser()->setAttributeAction('filtre_dossier_mips', $this->getUser()->getAttributeAction('filtre_dossier_mips', null, "dossier_mip/voirRapportStatistique"));
    }


    $objRequeteDoctrine = Dossier_mipTable::getInstance()->getRequeteListeParUtilisateur($this->processFiltre(), $this->getUser());

    $this->resultatsStatuts = array();
    $this->resultatsAnnees = array();
    $this->resultatsOrganismesMindef = array();
    $this->resultatsNiveaux = array();
    $this->resultatsBrevets = array();
    $this->resultatsEtatControle = array();

     $this->headerFiltreAnnee = '';

//On determine les groupements présents
    $this->boolStatuts = true;
    $this->boolAnnees = true;
    $this->boolOrganismesMindef = true;
    $this->boolNiveaux = true;
    $this->boolFiltres = false;

    if ($this->objFormFiltre->getValue('organisme_mindef_id') != '') {
      $this->boolFiltres = true;
      $this->boolOrganismesMindef = false;
      $this->headerFiltreOrg = libelle('msg_libelle_organisme_armee') . ' : ' . Organisme_mindefTable::getInstance()->findOneById($this->objFormFiltre->getValue('organisme_mindef_id'));
    }
    if ($this->objFormFiltre->getValue('statut_dossier_mip_id') != '') {
      $this->boolFiltres = true;
      $this->boolStatuts = false;
      $this->headerFiltreStatut = libelle('msg_libelle_statut_dossier') . ' : ' . Statut_dossier_mipTable::getInstance()->findOneById($this->objFormFiltre->getValue('statut_dossier_mip_id'));
    }
    if ($this->objFormFiltre->getValue('niveau_protection_id') != '') {
      $this->boolFiltres = true;
      $this->boolNiveaux = false;
      $this->headerFiltreNiv = libelle('msg_libelle_niveau_protection') . ' : ' . Statut_dossier_mipTable::getInstance()->findOneById($this->objFormFiltre->getValue('niveau_protection_id'));
    }
    $arrCreatedAt = $this->objFormFiltre->getValue('date_bascule');
    if ($arrCreatedAt != array('from' => null, 'to' => null) && $arrCreatedAt != null) {
      $this->boolFiltres = true;
      $this->headerFiltreAnnee = libelle('msg_statistiques_periode_du') . ' : ' . formatDate($arrCreatedAt['from']) . ' ' . libelle('msg_statistiques_periode_au') . ' : ' . formatDate($arrCreatedAt['to']);
      if (substr($arrCreatedAt['from'], 0, 4) == substr($arrCreatedAt['to'], 0, 4)) {
        $this->boolAnnees = false;
      }
    }

//Récupération des résultats pour chaque tableau
    if ($this->boolStatuts) {
      $intIndex = 0;
      foreach (Dossier_mipTable::getInstance()->getCountsByStatuts($objRequeteDoctrine) as $statut => $compte) {
        array_push($this->resultatsStatuts, array($statut => $compte));
        $intIndex++;
      }
    }
    if ($this->boolAnnees) {
      $intIndex = 0;
      foreach (Dossier_mipTable::getInstance()->getCountsByAnnees($objRequeteDoctrine) as $annee => $compte) {
        array_push($this->resultatsAnnees, array($annee => $compte));
        $intIndex++;
      }
    }
    if ($this->boolOrganismesMindef) {
      $intIndex = 0;
      foreach (Dossier_mipTable::getInstance()->getCountsByOrganismesMindef($objRequeteDoctrine) as $org => $compte) {
        array_push($this->resultatsOrganismesMindef, array($org => $compte));
        $intIndex++;
      }
    }
    if ($this->boolNiveaux) {
      $intIndex = 0;
      foreach (Dossier_mipTable::getInstance()->getCountsByNiveaux($objRequeteDoctrine) as $niveau => $compte) {
        array_push($this->resultatsNiveaux, array($niveau => $compte));
        $intIndex++;
      }
    }
    $intIndex = 0;
    foreach (Dossier_mipTable::getInstance()->getCountsByBrevets($objRequeteDoctrine) as $niveau => $compte) {
      array_push($this->resultatsBrevets, array($niveau => $compte));
      $intIndex++;
    }
    $intIndex = 0;
    foreach (Dossier_mipTable::getInstance()->getCountsByEtatsControle($objRequeteDoctrine) as $niveau => $compte) {
      array_push($this->resultatsEtatControle, array($niveau => $compte));
      $intIndex++;
    }

    $this->setTemplate('voirRapportStatistique');
  }

}

?>
