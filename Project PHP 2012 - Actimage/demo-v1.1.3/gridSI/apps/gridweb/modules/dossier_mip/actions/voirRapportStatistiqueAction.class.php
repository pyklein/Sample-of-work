<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of voirRapportStatistiqueAction
 *
 * @author William
 */
class voirRapportStatistiqueAction extends gridAction {

  public function execute($request) {
    $this->objFormFiltre = new Dossier_mipStatistiquesFormFilter();
    $strFilterName = $this->objFormFiltre->getName();

    $objRequeteDoctrine = Dossier_mipTable::getInstance()->getRequeteListeParUtilisateur($this->processFiltre(), $this->getUser());
    

    $this->resultatsStatuts = array();
    $this->resultatsAnnees = array();
    $this->resultatsOrganismesMindef = array();
    $this->resultatsNiveaux = array();
    $this->resultatsBrevets = array();
    $this->resultatsEtatControle = array();

//On determine les groupements présents
    $this->boolStatuts = true;
    $this->boolAnnees = true;
    $this->boolOrganismesMindef = true;
    $this->boolNiveaux = true;
    if ($request->hasParameter($strFilterName)) {
      $arrParams = $request->getParameter($strFilterName);
      if ($arrParams['organisme_mindef_id'] != '') {
        $this->boolOrganismesMindef = false;
      }
      if ($arrParams['statut_dossier_mip_id'] != '') {
        $this->boolStatuts = false;
      }
      if ($arrParams['niveau_protection_id'] != '') {
        $this->boolNiveaux = false;
      }
      if ($arrParams['date_bascule']['to'] != '' && $arrParams['date_bascule']['from'] != '') {
        if (substr($arrParams['date_bascule']['to'], 7) == substr($arrParams['date_bascule']['from'], 7)) {
          $this->boolAnnees = false;
        }
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
  }

}

?>
