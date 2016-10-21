<?php

/**
 * Description of ServiceArborescence
 *
 * @author William
 */
class ServiceArborescence {

  private $arrSettings;
  private $arrFichiers;
  private $strRacine;
  private $arrRepertoiresPartages;

  public function __construct() {
    $this->strRacine              = sfConfig::get("app_arborescence_repertoire_racine");
    $this->arrSettings            = sfConfig::get("sf_arborescence");
    $this->arrFichiers            = $this->arrSettings["fichiers_statiques"];
    $this->arrRepertoiresPartages = sfConfig::get("app_arborescence_repertoires_partages");
  }

  public function getRepertoireRacine() {
    return $this->strRacine;
  }

  public function getRepertoirePartageMip() {
    return $this->completeRepertoire($this->arrRepertoiresPartages["mip"]);
  }

  public function getRepertoirePartageBpi() {
    return $this->completeRepertoire($this->arrRepertoiresPartages["bpi"]);
  }

  public function getRepertoirePartageThese() {
    return $this->completeRepertoire($this->arrRepertoiresPartages["these"]);
  }

  public function getRepertoirePartageEre() {
    return $this->completeRepertoire($this->arrRepertoiresPartages["ere"]);
  }

  public function getRepertoirePartagePostdoc() {
    return $this->completeRepertoire($this->arrRepertoiresPartages["postdoc"]);
  }

  public function getRepertoirePartageDocumentsMip($strNumeroDossier) {
    return $this->getRepertoirePartageDocuments($strNumeroDossier, 'mip');
  }

  public function getRepertoirePartageDocumentsBpi($strNumeroDossier) {
    return $this->getRepertoirePartageDocuments($strNumeroDossier, 'bpi');
  }

  public function getRepertoirePartageDocumentsThese($strNumeroDossier) {
    return $this->getRepertoirePartageDocuments($strNumeroDossier, 'these');
  }

  public function getRepertoirePartageDocumentsEre($strNumeroDossier) {
    return $this->getRepertoirePartageDocuments($strNumeroDossier, 'ere');
  }

  public function getRepertoirePartageDocumentsPostdoc($strNumeroDossier) {
    return $this->getRepertoirePartageDocuments($strNumeroDossier, 'postdoc');
  }

  protected function getRepertoirePartageDocuments($strNumeroDossier, $strTypeDossier) {
    $str = $this->completeRepertoire(
                    $this->arrRepertoiresPartages[$strTypeDossier] .
                    $this->arrSettings['documents_dossier_repertoire']);
    return $this->completeRepertoire(
            $str .
            $this->formaterNumeroDossier($strNumeroDossier)
    );
  }

  public function getRepertoirePhotosUtilisateurs() {
    return $this->completeRepertoire($this->strRacine . $this->arrSettings["utilisateur_repertoire"]);
  }

  public function getRepertoirePhotosEtudiants() {
    return $this->completeRepertoire($this->strRacine . $this->arrSettings["etudiant_repertoire"]);
  }

  public function getRepertoireModelesDocuments() {
    return $this->completeRepertoire($this->strRacine . $this->arrSettings["modeles_documents_repertoire"]);
  }

  public function getRepertoireConventionsOrganismes() {
    return $this->completeRepertoire($this->strRacine . $this->arrSettings["convention_organisme_repertoire"]);
  }

  public function getRepertoireTemporaire() {
    return $this->completeRepertoire($this->strRacine . $this->arrSettings["fichiers_temporaires_repertoire"]);
  }

  public function getRepertoireFichiersStatiques() {
    return $this->completeRepertoire(sfConfig::get("sf_root_dir") . DIRECTORY_SEPARATOR . "modeles");
  }

  public function getRepertoireDossiersMip() {
    return $this->completeRepertoire($this->strRacine . $this->arrSettings["dossier_mip_repertoire"]);
  }

  public function getRepertoireDossiersBpi() {
    return $this->completeRepertoire($this->strRacine . $this->arrSettings["dossier_bpi_repertoire"]);
  }

  public function getRepertoireDossiersThese() {
    return $this->completeRepertoire($this->strRacine . $this->arrSettings["dossier_these_repertoire"]);
  }

  public function getRepertoireDossiersEre() {
    return $this->completeRepertoire($this->strRacine . $this->arrSettings["dossier_ere_repertoire"]);
  }

  public function getRepertoireDossiersPostdoc() {
    return $this->completeRepertoire($this->strRacine . $this->arrSettings["dossier_postdoc_repertoire"]);
  }

  public function getRepertoireDocumentsDossierMip($strNumeroDossier) {
    return $this->getRepertoireDocumentsDossier($strNumeroDossier, 'mip');
  }

  public function getRepertoireDocumentsDossierBpi($strNumeroDossier) {
    return $this->getRepertoireDocumentsDossier($strNumeroDossier, 'bpi');
  }

  public function getRepertoireDocumentsDossierThese($strNumeroDossier) {
    return $this->getRepertoireDocumentsDossier($strNumeroDossier, 'these');
  }

  public function getRepertoireDocumentsDossierEre($strNumeroDossier) {
    return $this->getRepertoireDocumentsDossier($strNumeroDossier, 'ere');
  }

  public function getRepertoireDocumentsDossierPostdoc($strNumeroDossier) {
    return $this->getRepertoireDocumentsDossier($strNumeroDossier, 'postdoc');
  }

  public function getRepertoireConventionDossierThese($strNumeroDossier) {
    return $this->getRepertoireConventionDossier($strNumeroDossier, 'these');
  }

  public function getRepertoireConventionDossierEre($strNumeroDossier) {
    return $this->getRepertoireConventionDossier($strNumeroDossier, 'ere');
  }

  public function getRepertoireConventionDossierPostdoc($strNumeroDossier) {
    return $this->getRepertoireConventionDossier($strNumeroDossier, 'postdoc');
  }

  public function getRepertoireImportationIXarm() {
    return $this->completeRepertoire($this->strRacine . $this->arrSettings["import_ixarm_repertoire"]);
  }

  public function getRepertoireImportationIXarmCourant(){
    return $this->completeRepertoire($this->strRacine . $this->arrSettings["import_ixarm_repertoire_courant"]);
  }

  protected function getRepertoireDocumentsDossier($strNumeroDossier, $strTypeDossier) {
    $str = $this->completeRepertoire(
                    $this->strRacine .
                    $this->arrSettings["dossier_" . $strTypeDossier . "_repertoire"] .
                    $this->arrSettings['documents_dossier_repertoire']);
    return $this->completeRepertoire(
            $str .
            $this->formaterNumeroDossier($strNumeroDossier)
    );
  }

  protected function getRepertoireConventionDossier($strNumeroDossier, $strTypeDossier) {
    $str = $this->completeRepertoire(
                    $this->strRacine .
                    $this->arrSettings["dossier_" . $strTypeDossier . "_repertoire"] .
                    $this->arrSettings['convention_dossier_repertoire']);
    return $this->completeRepertoire(
            $str .
            $this->formaterNumeroDossier($strNumeroDossier)
    );
  }

  public function getRepertoiresInitiaux() {
    $arrRepertoires = array();
    $arrRepertoires[] = $this->getRepertoireDossiersBpi();
    $arrRepertoires[] = $this->getRepertoireDossiersEre();
    $arrRepertoires[] = $this->getRepertoireDossiersMip();
    $arrRepertoires[] = $this->getRepertoireDossiersPostdoc();
    $arrRepertoires[] = $this->getRepertoireDossiersThese();
    $arrRepertoires[] = $this->getRepertoireImportationIXarm();
    $arrRepertoires[] = $this->getRepertoireImportationIXarmCourant();
    $arrRepertoires[] = $this->getRepertoireTemporaire();
    $arrRepertoires[] = $this->getRepertoirePartageMip();
    $arrRepertoires[] = $this->getRepertoirePartageBpi();
    $arrRepertoires[] = $this->getRepertoirePartageEre();
    $arrRepertoires[] = $this->getRepertoirePartagePostdoc();
    $arrRepertoires[] = $this->getRepertoirePartageThese();
    $arrRepertoires[] = $this->getRepertoirePhotosEtudiants();
    $arrRepertoires[] = $this->getRepertoirePhotosUtilisateurs();
    $arrRepertoires[] = $this->getRepertoireConventionsOrganismes();
    $arrRepertoires[] = $this->getRepertoireModelesDocuments();
    return $arrRepertoires;
  }

  protected function completeRepertoire($strChemin) {
    if ($strChemin[strlen($strChemin) - 1] != DIRECTORY_SEPARATOR) {
      $strChemin .= DIRECTORY_SEPARATOR;
    }
    return $strChemin;
  }

  protected function formaterNumeroDossier($strNumeroDossier) {
    $strNumeroDossier = str_replace('/', '_', $strNumeroDossier);
    return str_replace(DIRECTORY_SEPARATOR, '_', $strNumeroDossier);
  }

  public function getFicheInscription() {
    return $this->arrFichiers["fiche_inscription"];
  }

  public function getGrillesEvaluation() {
    return $this->arrFichiers["grilles_evaluation"];
  }

  public function getFichesSuivi() {
    return $this->arrFichiers["fiches_suivi"];
  }

  public function getLettreInvitationPersonne() {
    return $this->arrFichiers["lettre_invitation_personne"];
  }

  public function getLettreInvitationLaboratoire() {
    return $this->arrFichiers["lettre_invitation_laboratoire"];
  }

  public function getLettreInvitationService() {
    return $this->arrFichiers["lettre_invitation_service"];
  }

  public function getLettreValidationRefus() {
    return $this->arrFichiers["lettre_validation_refus"];
  }

  public function getLettreValidationRefusApresAttente() {
    return $this->arrFichiers["lettre_validation_refus_apres_attente"];
  }

  public function getLettreValidationListeAttente() {
    return $this->arrFichiers["lettre_validation_liste_attente"];
  }

  public function getLettreValidationAttestation() {
    return $this->arrFichiers["lettre_validation_attestation"];
  }

  public function getLettreValidationAcceptationDirecte() {
    return $this->arrFichiers["lettre_validation_acceptation_directe"];
  }

  public function getLettreValidationAcceptationApresAttente() {
    return $this->arrFichiers["lettre_validation_acceptation_apres_attente"];
  }

  public function getLettreAccompagnementLicence() {
    return $this->arrFichiers["lettre_accompagnement_licence"];
  }

  public function getLettreAccompagnementCopropriete() {
    return $this->arrFichiers["lettre_accompagnement_copropriete"];
  }

  public function getLettreDepotBrevetHorsDga() {
    return $this->arrFichiers["lettre_depot_hors_dga"];
  }

  public function getLettreDepotBrevetDga() {
    return $this->arrFichiers["lettre_depot_dga"];
  }

}

?>
