<?php

/**
 * Classe permettant de générer un fichier document
 * @author Gabor JAGER
 */
class ServiceDocumentMip extends ServiceDocument
{
  /**
   * Permet de générer un document MIP dans le répertoire temporaire
   * @param integer $intDossierId ID de dossier
   * @param string $strCle Clé de lettre
   * @return string Nom de fichier généré (sans chemin)
   * @throws Exception Si le modele n'est pas disponible ou si le dossier n'existe pas
   * @author Gabor JAGER
   */
  public function creerDocumentMip($intDossierId, $strCle)
  {
    // on remplie le tableau de remplacement
    switch ($strCle)
    {
      case Modele_lettreTable::MIP_LETTRE_PROJET_UN_INNOVATEUR:
        $strFichierPrefixe = "projet_lettre";
        $arrVariables = $this->creerDocumentMipProjetLettreUnInnovateur($intDossierId);
        break;
      case Modele_lettreTable::MIP_LETTRE_PROJET_PLUSIEURS_INNOVATEURS:
        $strFichierPrefixe = "projet_lettre";
        $arrVariables = $this->creerDocumentMipProjetLettrePlusieursInnovateurs($intDossierId);
        break;
      case Modele_lettreTable::MIP_LETTRE_CLOTURE_UN_INNOVATEUR_MINDEF:
        $strFichierPrefixe = "cloture_lettre_mindef";
        $arrVariables = $this->creerDocumentMipClotureUnInnovateurMindef($intDossierId);
        break;
      case Modele_lettreTable::MIP_LETTRE_CLOTURE_PLUSIEURS_INNOVATEURS_MINDEF:
        $strFichierPrefixe = "cloture_lettre_p_mindef";
        $arrVariables = $this->creerDocumentMipCloturePlusieursInnovateursMindef($intDossierId);
        break;
      case Modele_lettreTable::MIP_LETTRE_SOUTIEN_UN_INNOVATEUR:
        $strFichierPrefixe = "lettre_soutien";
        $arrVariables = $this->creerDocumentMipLettreSoutienUnInnovateur($intDossierId);
        break;
      case Modele_lettreTable::MIP_LETTRE_SOUTIEN_PLUSIEURS_INNOVATEURS:
        $strFichierPrefixe = "lettre_soutien";
        $arrVariables = $this->creerDocumentMipLettreSoutienPlusieursInnovateurs($intDossierId);
        break;

      default:
        return null;
        break;
    }

    // on genère le document
    return $this->creerDocumentModeleDynamique($strCle, $strFichierPrefixe, $arrVariables);
  }

  /**
   * Permet de générer un document MIP dans le répertoire temporaire en tenant compte de l'id de l'innovateur
   * @param integer $intDossierId ID de dossier
   * @param string $strCle Clé de lettre
   * @param integer $intIdInnovateur
   * @return string Nom de fichier généré (sans chemin)
   * @throws Exception Si le modele n'est pas disponible ou si le dossier n'existe pas
   * @author Jihad Sahebdin
   */
  public function creerDocumentMipAvecInnovateurId($intDossierId, $strCle, $intIdInnovateur)
  {
    // on remplie le tableau de remplacement
    switch ($strCle)
    {
      case Modele_lettreTable::MIP_LETTRE_CLOTURE_UN_INNOVATEUR_EM:
        $strFichierPrefixe = "cloture_lettre";
        $arrVariables = $this->creerDocumentMipClotureLettreUnInnovateur($intDossierId,$intIdInnovateur);
        break;
      case Modele_lettreTable::MIP_LETTRE_ACCUSE_RECEPTION_VISITE;
        $strFichierPrefixe = "lettre_accuse_reception";
        $arrVariables = $this->creerDocumentMipAccuseReception($intDossierId,$intIdInnovateur);
        break;

      default:
        return null;
        break;
    }

    // on genère le document
    return $this->creerDocumentModeleDynamique($strCle, $strFichierPrefixe, $arrVariables);
  }

  /**
   * Permet de générer le tableau de remplacement pour un projet lettre de type "un innovateur"
   * @param integer $intDossierId ID de dossier MIP
   * @return array Variables à remplacer
   * @throws Exception Si le dossier n'existe pas
   * @author Gabor JAGER
   */
  private function creerDocumentMipProjetLettreUnInnovateur($intDossierId)
  {
    // on récupere le dossier
    $objDossierMip = Dossier_mipTable::getInstance()->findOneById($intDossierId);
    if (!$objDossierMip)
    {
      throw new Exception("Le dossier MIP n'existe pas.");
    }

    // variables à remplacer
    $arrVariables["date"]           = date("d/m/Y");
    $arrVariables["dossier_numero"] = $objDossierMip->getNumero();
    $arrVariables["dossier_titre"]  = $objDossierMip->getTitre();
    $arrVariables["dossier_incr"]   = $objDossierMip->getNumeroIncrement();
    $arrVariables["dossier_description"] = str_replace(array("\n", "\r"), " ", $objDossierMip->getDescriptif());

    // reference de dossier
    $objRendezVous = Rendez_vousTable::getInstance()->findOneByDossier_mip($intDossierId);
    $arrVariables["dossier_reference"] = $objRendezVous != null && $objRendezVous->getDateRdv() != null
                                            ? libelle_rtf("msg_rtf_entretien_du", array(formatDate($objRendezVous->getDateRdv())))
                                            : libelle_rtf("msg_rtf_cree_le", array(formatDate($objDossierMip->getCreatedAt())));

    // dates
    $objEcheance = EcheanceTable::getInstance()->findOneByDossier_mip($intDossierId);
    $arrVariables["date_etat_avancement"] = $objEcheance != null ? formatDate($objEcheance->getDateEcheanceEa()) : "";
    $arrVariables["date_compte_rendu"]    = $objEcheance != null ? formatDate($objEcheance->getDateEcheanceCr()) : "";

    // pilote
    $objPilote = $objDossierMip->getPilote();
    $objPiloteGrade = $objPilote->getGrade();
    $arrVariables["pilote"]        = libelle_rtf("msg_rtf_grade_prenom_nom", array($objPiloteGrade != null ? $objPiloteGrade->getIntitule() : "", $objPilote->getPrenom(), $objPilote->getNom()));
    $arrVariables["pilote_tel"]    = $objPilote->getTelephoneFixe() != "" ? $objPilote->getTelephoneFixe() : $objPilote->getTelephoneMobile();
    $arrVariables["pilote_fax"]    = $objPilote->getFax();
    $arrVariables["pilote_mail"]   = $objPilote->getEmail();

    // innovateur
    $arrInnovateurs = $objDossierMip->getInnovateurs();
    $objInnovateur = $arrInnovateurs[0];
    $objEntiteInnovateur = $objInnovateur->getEntite();
    $objInnovateurGrade = $objInnovateur->getGrade();
    $objInnovateurCivilite = $objInnovateur->getCivilite();
    $arrVariables["innovateur"] = libelle_rtf("msg_rtf".($objInnovateurCivilite->getId() == CiviliteTable::M ? "_le" : "_la")."_grade_prenom_nom_entite",
                                                array($objInnovateurGrade != null ? $objInnovateurGrade->getIntitule() : "",
                                                      $objInnovateur->getPrenom(),
                                                      $objInnovateur->getNom(),
                                                      $objEntiteInnovateur->getIntitule()));
    
	// Libellés destinataires et correspondant de l'armée / organisme MINDEF du dossier
	$objOrganismeTable = Libelle_organismeTable::getInstance();
	$objLibelleOrganisme = $objOrganismeTable->getLibelleByMetier($objDossierMip->getOrganismeMindefId(), MetierTable::MIP_ID);
	$arrVariables["libelle_destinataire"]    = ($objLibelleOrganisme != null) ? strip_tags($objLibelleOrganisme->getLibelleSimple()) : "";
	$arrVariables["libelle_correspondant"]   = ($objLibelleOrganisme != null) ? strip_tags($objLibelleOrganisme->getLibelleListe()) : "";
	
    // unité de l'innovateur
    $arrVariables["copie_unite_innov"] = str_replace("\n", self::CAR_NL,
                                            libelle_rtf("msg_rtf_unite_innovateur",
                                                        array($objEntiteInnovateur->getIntitule(),
                                                              $objEntiteInnovateur->getLieu(),
                                                              $objEntiteInnovateur->getVille()->getCodePostal(),
                                                              $objEntiteInnovateur->getVille()->getNom(),
                                                              $arrVariables["innovateur"])));

    return $arrVariables;
  }
  
  /**
   * Permet de générer le tableau de remplacement pour un projet lettre de type "plusieurs innovateurs"
   * @param integer $intDossierId ID de dossier MIP
   * @return array Variables à remplacer
   * @throws Exception Si le dossier n'existe pas
   * @author Gabor JAGER
   */
  private function creerDocumentMipProjetLettrePlusieursInnovateurs($intDossierId)
  {
    // on récupere le dossier
    $objDossierMip = Dossier_mipTable::getInstance()->findOneById($intDossierId);
    if (!$objDossierMip)
    {
      throw new Exception("Le dossier MIP n'existe pas.");
    }

    // variables à remplacer
    $arrVariables["date"]           = date("d/m/Y");
    $arrVariables["dossier_numero"] = $objDossierMip->getNumero();
    $arrVariables["dossier_titre"]  = $objDossierMip->getTitre();
    $arrVariables["dossier_incr"]   = $objDossierMip->getNumeroIncrement();
    $arrVariables["dossier_description"] = str_replace(array("\n", "\r"), " ", $objDossierMip->getDescriptif());

    // reference de dossier
    $objRendezVous = Rendez_vousTable::getInstance()->findOneByDossier_mip($intDossierId);
    $arrVariables["dossier_reference"] = $objRendezVous != null && $objRendezVous->getDateRdv() != null
                                            ? libelle_rtf("msg_rtf_entretien_du", array(formatDate($objRendezVous->getDateRdv())))
                                            : libelle_rtf("msg_rtf_cree_le", array(formatDate($objDossierMip->getCreatedAt())));

    // dates
    $objEcheance = EcheanceTable::getInstance()->findOneByDossier_mip($intDossierId);
    $arrVariables["date_etat_avancement"] = formatDate($objEcheance->getDateEcheanceEa());
    $arrVariables["date_compte_rendu"]    = formatDate($objEcheance->getDateEcheanceCr());

    // pilote
    $objPilote = $objDossierMip->getPilote();
    $objPiloteGrade = $objPilote->getGrade();
    $arrVariables["pilote"]        = libelle_rtf("msg_rtf_grade_prenom_nom", array($objPiloteGrade != null ? $objPiloteGrade->getIntitule() : "", $objPilote->getPrenom(), $objPilote->getNom()));
    $arrVariables["pilote_tel"]    = $objPilote->getTelephoneFixe() != "" ? $objPilote->getTelephoneFixe() : $objPilote->getTelephoneMobile();
    $arrVariables["pilote_fax"]    = $objPilote->getFax();
    $arrVariables["pilote_mail"]   = $objPilote->getEmail();

    // innovateur
    $arrInnovateurs = $objDossierMip->getInnovateurs();
    
    $strInnovateurs = "";
    $arrEntites = array();
    $arrEntiteInnovateurs = array();
    foreach($arrInnovateurs as $intI => $objInnovateur)
    {
      // on stocke les entités
      if (!isset($arrEntites[$objInnovateur->getEntiteId()]))
      {
        $arrEntites[$objInnovateur->getEntiteId()] = $objInnovateur->getEntite();
      }

      // on stocke les innovateurs de l'entité
      if (!isset($arrEntiteInnovateurs[$objInnovateur->getEntiteId()]))
      {
        $arrEntiteInnovateurs[$objInnovateur->getEntiteId()] = array();
      }
      $arrEntiteInnovateurs[$objInnovateur->getEntiteId()][] = $intI;
      
      $objInnovateurGrade = $objInnovateur->getGrade();
      $strInnovateurs .= ($strInnovateurs != "" ? (count($arrInnovateurs) - 1 == $intI ? " et " : ", ") : "");
      
      $objInnovateurCivilite = $objInnovateur->getCivilite();
      $strInnovateurs .= libelle_rtf("msg_rtf".($objInnovateurCivilite->getId() == CiviliteTable::M ? "_le" : "_la")."_grade_prenom_nom_entite",
                                        array($objInnovateurGrade != null ? $objInnovateurGrade->getIntitule() : "", 
                                              $objInnovateur->getPrenom(),
                                              $objInnovateur->getNom(),
                                              $arrEntites[$objInnovateur->getEntiteId()]->getIntitule()));
    }
    $arrVariables["innovateurs"] = $strInnovateurs;

	// Libellés destinataires et correspondant de l'armée / organisme MINDEF du dossier
	$objOrganismeTable = Libelle_organismeTable::getInstance();
	$objLibelleOrganisme = $objOrganismeTable->getLibelleByMetier($objDossierMip->getOrganismeMindefId(), MetierTable::MIP_ID);
	$arrVariables["libelle_destinataire"]   = ($objLibelleOrganisme != null) ? strip_tags($objLibelleOrganisme->getLibelleSimple()) : "";
	$arrVariables["libelle_correspondant"]  = ($objLibelleOrganisme != null) ? strip_tags($objLibelleOrganisme->getLibelleListe()) : "";
	
    // unité de l'innovateur
    $strCopieEntites = "";
    foreach($arrEntites as $objEntite)
    {
      $strCopieEntites .= ($strCopieEntites != "" ? self::CAR_NL.self::CAR_NL : "");

      $strCopieEntitesInnovateurs = "";
      foreach($arrEntiteInnovateurs[$objEntite->getId()] as $intI => $intInnovateurId)
      {
        $objInnovateurGrade = $arrInnovateurs[$intInnovateurId]->getGrade();
        $strCopieEntitesInnovateurs .= ($strCopieEntitesInnovateurs != "" ? (count($arrEntiteInnovateurs[$objEntite->getId()]) - 1 == $intI ? " et " : ", ") : "");
        $strCopieEntitesInnovateurs .= libelle_rtf("msg_rtf_grade_prenom_nom",
                                        array($objInnovateurGrade != null ? $objInnovateurGrade->getIntitule() : "",
                                              $arrInnovateurs[$intInnovateurId]->getPrenom(),
                                              $arrInnovateurs[$intInnovateurId]->getNom(),
                                              $objEntite->getIntitule()));
      }

      $strCopieEntites .= libelle_rtf("msg_rtf_unite_innovateur",
                                                  array($objEntite->getIntitule(),
                                                        $objEntite->getLieu(),
                                                        $objEntite->getVille()->getCodePostal(),
                                                        $objEntite->getVille()->getNom(),
                                                        $strCopieEntitesInnovateurs));
    }

    $arrVariables["copie_unite_innov"] = $strCopieEntites;

    return $arrVariables;
  }

  /**
   * Permet de générer le tableau de remplacement pour une lettre de soutien de type "Un innovateur"
   * @param integer $intDossierId ID de dossier MIP
   * @return array Variables à remplacer
   * @author Alexandre WETTA
   */
  private function creerDocumentMipLettreSoutienUnInnovateur($intDossierId) {
    // on récupere le dossier
    $objDossierMip = Dossier_mipTable::getInstance()->findOneById($intDossierId);
    if (!$objDossierMip) {
      throw new Exception("Le dossier MIP n'existe pas.");
    }

    // variables à remplacer
    $arrVariables["date"] = date("d/m/Y");
    $arrVariables["dossier_numero"] = $objDossierMip->getNumero();
    $arrVariables["dossier_titre"]  = $objDossierMip->getTitre();
    $arrVariables["lui_leur"] = "lui";
    $arrVariables["innovateur_innovateurs"] = "à l'innovateur";
    $arrVariables["son_leur"] = "son";
    $arrVariables["description_dossier"] = str_replace(array("\n", "\r"), " ", $objDossierMip->getDescriptif());

    //financement du dossier
    $arrFinancementsParAnnees = $objDossierMip->getFinancementsGlobauxParAnneesSansCumule();
    $arrVariables["repartition_financement"] = "";
    $intCount = 0;
    foreach ($arrFinancementsParAnnees as $annee => $montant){

      if($intCount == 0){
        $arrVariables["repartition_financement"] .= libelle_rtf('msg_rtf_reparti_en_pour', array(formatNombreFr($montant), $annee));
      }else{
        $arrVariables["repartition_financement"] .= ", en ". formatNombreFr($montant) ." euros pour " .$annee ;
      }
      $intCount++;
    }
    
    //financement total
    $dernierMontant = 0;
    foreach ($arrFinancementsParAnnees as $annee => $montant)
    {
      $arrFinancementsParAnnees[$annee] += $dernierMontant;

      $dernierMontant = $arrFinancementsParAnnees[$annee];
    }
    $arrVariables["financement_total"] = end($arrFinancementsParAnnees);

    //entités de financement
    $arrFinancements = FinancementTable::getInstance()->retreveFinancementsOrdreDescDate($intDossierId);
    if(count($arrFinancements) == 0){
       throw new Exception("Il n'y a pas de financement pour ce dossier.");
    }
    $arrEntiteId = array();
    $strEntFin = "";
    foreach($arrFinancements as $objFinancement ){
      if(!in_array($objFinancement->getEntiteId(), $arrEntiteId)){
        $arrEntiteId[$objFinancement->getEntiteId()] = $objFinancement->getEntiteId();
        $strEntFin .= $objFinancement->getEntite()->getIntitule() ." (". $objFinancement->getEntite()->getAbreviation() .") (". $objFinancement->getEntite()->getCodeExecutant() ."), " ;
      }
    }
    $strEntFin = substr($strEntFin, 0, -2) ;
    $arrVariables["entite_financement"] = $strEntFin;

    //echéance
    $utilDate = new UtilDate();
    $objEcheance = EcheanceTable::getInstance()->findOneByDossierMipId($intDossierId);
    if($objEcheance){
      if($objEcheance->getDateEcheanceEa() != null){
        $arrVariables["ea_date"] = $utilDate->afficheDateFrComplete($objEcheance->getDateTimeObject('date_echeance_ea')->format('d/n/Y'));
      }else {$arrVariables["ea_date"] = "JJ/MM/AAAA" ;}
      if($objEcheance->getDateEcheanceCr() != null){
        $arrVariables["cr_date"] = $utilDate->afficheDateFrComplete($objEcheance->getDateTimeObject('date_echeance_cr')->format('d/n/Y')) ;
      }else {$arrVariables["cr_date"] = "JJ/MM/AAAA" ;}
    } else {
      $arrVariables["ea_date"] = "JJ/MM/AAAA" ;
      $arrVariables["cr_date"] = "JJ/MM/AAAA" ;
    }

     // innovateur
    $arrInnovateurs = $objDossierMip->getInnovateurs();
    $objInnovateur = $arrInnovateurs[0];
    $objEntiteInnovateur = $objInnovateur->getEntite();
    $objInnovateurGrade = $objInnovateur->getGrade();
    $objInnovateurCivilite = $objInnovateur->getCivilite();
    $arrVariables["innovateur"] = libelle_rtf("msg_rtf_le_grade_prenom_nom",
                    array($objInnovateurGrade != null ? $objInnovateurGrade->getIntitule() : "",
                        $objInnovateur->getPrenom(),
                        $objInnovateur->getNom()));

    $innovateur_grade_nom_prenom = libelle_rtf('msg_rtf_grade_prenom_nom',
                    array($objInnovateurGrade != null ? $objInnovateurGrade->getIntitule() : "",
                        $objInnovateur->getPrenom(),
                        $objInnovateur->getNom()));

	// Libellés destinataires et correspondant de l'armée / organisme MINDEF du dossier
	$objOrganismeTable = Libelle_organismeTable::getInstance();
	$objLibelleOrganisme = $objOrganismeTable->getLibelleByMetier($objDossierMip->getOrganismeMindefId(), MetierTable::MIP_ID);
	$arrVariables["libelle_destinataire"]   = ($objLibelleOrganisme != null) ? strip_tags($objLibelleOrganisme->getLibelleSimple()) : "";
						
    // unité de l'innovateur
    $arrVariables["copie_unite_innov"] = str_replace("\n", self::CAR_NL,
                    libelle_rtf("msg_rtf_unite_innovateur",
                            array($objEntiteInnovateur->getIntitule(),
                                $objEntiteInnovateur->getLieu(),
                                $objEntiteInnovateur->getVille()->getCodePostal(),
                                $objEntiteInnovateur->getVille()->getNom(),
                                $innovateur_grade_nom_prenom)));


    return $arrVariables;
  }

  /**
   * Permet de générer le tableau de remplacement pour une lettre de soutien de type "Plusieurs innovateurs"
   * @param integer $intDossierId ID de dossier MIP
   * @return array Variables à remplacer
   * @author Alexandre WETTA
   */
  private function creerDocumentMipLettreSoutienPlusieursInnovateurs($intDossierId) {
    // on récupere le dossier
    $objDossierMip = Dossier_mipTable::getInstance()->findOneById($intDossierId);
    if (!$objDossierMip) {
      throw new Exception("Le dossier MIP n'existe pas.");
    }

    // variables à remplacer
    $arrVariables["date"] = date("d/m/Y");
    $arrVariables["dossier_numero"] = $objDossierMip->getNumero();
    $arrVariables["dossier_titre"]  = $objDossierMip->getTitre();
    $arrVariables["lui_leur"] = "leur";
    $arrVariables["innovateur_innovateurs"] = "aux innovateurs";
    $arrVariables["son_leur"] = "leur";
    $arrVariables["description_dossier"] = str_replace(array("\n", "\r"), " ", $objDossierMip->getDescriptif());

    //financement du dossier
    $arrFinancementsParAnnees = $objDossierMip->getFinancementsGlobauxParAnneesSansCumule();
    $arrVariables["repartition_financement"] = "";
    $intCount = 0;
    foreach ($arrFinancementsParAnnees as $annee => $montant){

      if($intCount == 0){
        $arrVariables["repartition_financement"] .= libelle_rtf('msg_rtf_reparti_en_pour', array(formatNombreFr($montant), $annee));
      }else{
        $arrVariables["repartition_financement"] .= ", en ". formatNombreFr($montant) ." euros pour " .$annee ;
      }
      $intCount++;
    }

    //financement total
    $dernierMontant = 0;
    foreach ($arrFinancementsParAnnees as $annee => $montant)
    {
      $arrFinancementsParAnnees[$annee] += $dernierMontant;

      $dernierMontant = $arrFinancementsParAnnees[$annee];
    }
    $arrVariables["financement_total"] = end($arrFinancementsParAnnees);

    //entités de financement
    $arrFinancements = FinancementTable::getInstance()->retreveFinancementsOrdreDescDate($intDossierId);
    if(count($arrFinancements) == 0){
       throw new Exception("Il n'y a pas de financement pour ce dossier.");
    }
    $arrEntiteId = array();
    $strEntFin = "";
    foreach($arrFinancements as $objFinancement ){
      if(!in_array($objFinancement->getEntiteId(), $arrEntiteId)){
        $arrEntiteId[$objFinancement->getEntiteId()] = $objFinancement->getEntiteId();
        $strEntFin .= $objFinancement->getEntite()->getIntitule() ." (". $objFinancement->getEntite()->getAbreviation() .") (". $objFinancement->getEntite()->getCodeExecutant() ."), " ;
      }
    }
    $strEntFin = substr($strEntFin, 0, -2) ;
    $arrVariables["entite_financement"] = $strEntFin;

    //echéance
    $utilDate = new UtilDate();
    $objEcheance = EcheanceTable::getInstance()->findOneByDossierMipId($intDossierId);
    if($objEcheance){
      if($objEcheance->getDateEcheanceEa() != null){
        $arrVariables["ea_date"] = $utilDate->afficheDateFrComplete($objEcheance->getDateTimeObject('date_echeance_ea')->format('d/n/Y'));
      }else {$arrVariables["ea_date"] = "JJ/MM/AAAA" ;}
      if($objEcheance->getDateEcheanceCr() != null){
        $arrVariables["cr_date"] = $utilDate->afficheDateFrComplete($objEcheance->getDateTimeObject('date_echeance_cr')->format('d/n/Y')) ;
      }else {$arrVariables["cr_date"] = "JJ/MM/AAAA" ;}
    } else {
      $arrVariables["ea_date"] = "JJ/MM/AAAA" ;
      $arrVariables["cr_date"] = "JJ/MM/AAAA" ;
    }

     // innovateurs
    $arrInnovateurs = $objDossierMip->getInnovateurs();

    $strInnovateurs = "";
    $arrEntites = array();
    $arrEntiteInnovateurs = array();
    foreach($arrInnovateurs as $intI => $objInnovateur)
    {
      // on stocke les entités
      if (!isset($arrEntites[$objInnovateur->getEntiteId()]))
      {
        $arrEntites[$objInnovateur->getEntiteId()] = $objInnovateur->getEntite();
      }

      // on stocke les innovateurs de l'entité
      if (!isset($arrEntiteInnovateurs[$objInnovateur->getEntiteId()]))
      {
        $arrEntiteInnovateurs[$objInnovateur->getEntiteId()] = array();
      }
      $arrEntiteInnovateurs[$objInnovateur->getEntiteId()][] = $intI;

      $objInnovateurGrade = $objInnovateur->getGrade();
      $strInnovateurs .= ($strInnovateurs != "" ? (count($arrInnovateurs) - 1 == $intI ? " et " : ", ") : "");

      $objInnovateurCivilite = $objInnovateur->getCivilite();
      $strInnovateurs .= libelle_rtf("msg_rtf_le_grade_prenom_nom",
                      array($objInnovateurGrade != null ? $objInnovateurGrade->getIntitule() : "",
                          $objInnovateur->getPrenom(),
                          $objInnovateur->getNom()));
      
    }
    $arrVariables["innovateurs"] = $strInnovateurs;

	// Libellés destinataires et correspondant de l'armée / organisme MINDEF du dossier
	$objOrganismeTable = Libelle_organismeTable::getInstance();
	$objLibelleOrganisme = $objOrganismeTable->getLibelleByMetier($objDossierMip->getOrganismeMindefId(), MetierTable::MIP_ID);
	$arrVariables["libelle_destinataire"]   = ($objLibelleOrganisme != null) ? strip_tags($objLibelleOrganisme->getLibelleSimple()) : "";
	
    // unité de l'innovateur
    $strCopieEntites = "";
    foreach($arrEntites as $objEntite)
    {
      $strCopieEntites .= ($strCopieEntites != "" ? self::CAR_NL.self::CAR_NL : "");

      $strCopieEntitesInnovateurs = "";
      foreach($arrEntiteInnovateurs[$objEntite->getId()] as $intI => $intInnovateurId)
      {
        $objInnovateurGrade = $arrInnovateurs[$intInnovateurId]->getGrade();
        $strCopieEntitesInnovateurs .= ($strCopieEntitesInnovateurs != "" ? (count($arrEntiteInnovateurs[$objEntite->getId()]) - 1 == $intI ? " et " : ", ") : "");
        $strCopieEntitesInnovateurs .= libelle_rtf("msg_rtf_grade_prenom_nom",
                                        array($objInnovateurGrade != null ? $objInnovateurGrade->getIntitule() : "",
                                              $arrInnovateurs[$intInnovateurId]->getPrenom(),
                                              $arrInnovateurs[$intInnovateurId]->getNom(),
                                              $objEntite->getIntitule()));
      }

      $strCopieEntites .= libelle_rtf("msg_rtf_unite_innovateur",
                                                  array($objEntite->getIntitule(),
                                                        $objEntite->getLieu(),
                                                        $objEntite->getVille()->getCodePostal(),
                                                        $objEntite->getVille()->getNom(),
                                                        $strCopieEntitesInnovateurs));
    }

    $arrVariables["copie_unite_innov"] = $strCopieEntites;


    return $arrVariables;
  }

  /**
   * Permet de générer la lettre de cloture pour un innovateur"
   * @param integer $intDossierId ID de dossier MIP
   * @return array Variables à remplacer
   * @throws Exception Si le dossier n'existe pas
   * @author Jihad Sahebdin
   */
  private function creerDocumentMipClotureLettreUnInnovateur($intDossierId,$intIdInnovateur)
  {
    // on récupere le dossier
    $objDossierMip = Dossier_mipTable::getInstance()->findOneById($intDossierId);
    if (!$objDossierMip)
    {
      throw new Exception("Le dossier MIP n'existe pas.");
    }

    // variables à remplacer
    $arrVariables["date"]           = date("d/m/Y");
    $arrVariables["dossier_incr"]   = $objDossierMip->getNumeroIncrement();
    $arrVariables["dossier_numero"] = $objDossierMip->getNumero();
    $arrVariables["dossier_titre"]  = $objDossierMip->getTitre();

    //Réception lettre de décision de soutien
    $objSoutien = SoutienTable::getInstance()->findOneByDossierMipId($intDossierId);
    if($objSoutien)
    {
      $arrVariables["reference_lettre_soutien"] = $objSoutien->getReference() != NULL ? "1) ".$objSoutien->getReference(): "";
    }
    else
    {
      $arrVariables["reference_lettre_soutien"]="";
    }

    //Réception CR
    $objReceptionCR = Remise_documentsTable::getInstance()->findOneByDossierMipId($intDossierId);
    if($objReceptionCR)
    {
      if($objReceptionCR->getReference_cr() != NULL)
      {
        $arrVariables["reference_reception_cr"] = "2) ".$objReceptionCR->getReference_cr();
        $arrVariables["reference_video"]=libelle_rtf("msg_rtf_libelle_reference_2");
      }
      else
      {
        $arrVariables["reference_reception_cr"]="";
        $arrVariables["reference_video"]="";
      }
      $arrVariables["video"] = $objReceptionCR->getDate_reception_video() != NULL ? libelle_rtf("msg_rtf_avec_video"):"";
    }
    else
    {
      $arrVariables["reference_reception_cr"] = "";
      $arrVariables["video"]="";
      $arrVariables["reference_video"]="";
    }
    
    // pilote
    $objPilote = $objDossierMip->getPilote();
    $objPiloteGrade = $objPilote->getGrade();
    $arrVariables["pilote"]        = libelle_rtf("msg_rtf_grade_prenom_nom", array($objPiloteGrade != null ? $objPiloteGrade->getIntitule() : "", $objPilote->getPrenom(), $objPilote->getNom()));
    $arrVariables["pilote_tel"]    = $objPilote->getTelephoneFixe() != "" ? $objPilote->getTelephoneFixe() : $objPilote->getTelephoneMobile();
    $arrVariables["pilote_fax"]    = $objPilote->getFax();
    $arrVariables["pilote_mail"]   = $objPilote->getEmail();

    // innovateur
    $objInnovateur = UtilisateurTable::getInstance()->findOneById($intIdInnovateur);
    $objInnovateurGrade = $objInnovateur->getGrade();
    $objInnovateurCivilite = $objInnovateur->getCivilite();
    $objEntiteInnovateur = $objInnovateur->getEntite();
    $arrVariables["innovateur"] = libelle_rtf("msg_rtf_grade_prenom_nom",
                                                array($objInnovateurGrade != null ? $objInnovateurGrade->getIntitule() : "",
                                                      $objInnovateur->getPrenom(),
                                                      $objInnovateur->getNom(),
                                                      ));

    // unité de l'innovateur
    $arrEntites = array();
    $arrInnovateurs = $objDossierMip->getInnovateurs();

    foreach($arrInnovateurs as $intI => $objInnovateur)
    {
      // on stocke les entités
      if (!isset($arrEntites[$objInnovateur->getEntiteId()]))
      {
        $arrEntites[$objInnovateur->getEntiteId()] = $objInnovateur->getEntite();
      }

      // on stocke les innovateurs de l'entité
      if (!isset($arrEntiteInnovateurs[$objInnovateur->getEntiteId()]))
      {
        $arrEntiteInnovateurs[$objInnovateur->getEntiteId()] = array();
      }
      $arrEntiteInnovateurs[$objInnovateur->getEntiteId()][] = $intI;

      $objInnovateurGrade = $objInnovateur->getGrade();
      $strInnovateurs .= ($strInnovateurs != "" ? (count($arrInnovateurs) - 1 == $intI ? " et " : ", ") : "");

      $objInnovateurCivilite = $objInnovateur->getCivilite();
      $strInnovateurs .= libelle_rtf("msg_rtf".($objInnovateurCivilite->getId() == CiviliteTable::M ? "_le" : "_la")."_grade_prenom_nom_entite",
                                        array($objInnovateurGrade != null ? $objInnovateurGrade->getIntitule() : "",
                                              $objInnovateur->getPrenom(),
                                              $objInnovateur->getNom(),
                                              $arrEntites[$objInnovateur->getEntiteId()]->getIntitule()));
    }
    


    $strCopieEntites = "";
    foreach($arrEntites as $objEntite)
    {
      $strCopieEntites .= ($strCopieEntites != "" ? self::CAR_NL.self::CAR_NL : "");

      $strCopieEntitesInnovateurs = "";
      foreach($arrEntiteInnovateurs[$objEntite->getId()] as $intI => $intInnovateurId)
      {
        $objInnovateurGrade = $arrInnovateurs[$intInnovateurId]->getGrade();
        $strCopieEntitesInnovateurs .= ($strCopieEntitesInnovateurs != "" ? (count($arrEntiteInnovateurs[$objEntite->getId()]) - 1 == $intI ? " et " : ", ") : "");
        $strCopieEntitesInnovateurs .= libelle_rtf("msg_rtf_grade_prenom_nom",
                                        array($objInnovateurGrade != null ? $objInnovateurGrade->getIntitule() : "",
                                              $arrInnovateurs[$intInnovateurId]->getPrenom(),
                                              $arrInnovateurs[$intInnovateurId]->getNom(),
                                              $objEntite->getIntitule()));
      }

      $strCopieEntites .= libelle_rtf("msg_rtf_unite_innovateur",
                                                  array($objEntite->getIntitule(),
                                                        $objEntite->getLieu(),
                                                        $objEntite->getVille()->getCodePostal(),
                                                        $objEntite->getVille()->getNom(),
                                                        $strCopieEntitesInnovateurs));
    }

    $arrVariables["copie_unite_innov"] = $strCopieEntites;
    
    return $arrVariables;
  }

  /**
   * Permet de générer la lettre de cloture pour un innovateur à un organisme Mindef
   * @param integer $intDossierId ID de dossier MIP
   * @return array Variables à remplacer
   * @throws Exception Si le dossier n'existe pas
   * @author Jihad 
   */
  private function creerDocumentMipClotureUnInnovateurMindef($intDossierId)
  {
    // on récupere le dossier
    $objDossierMip = Dossier_mipTable::getInstance()->findOneById($intDossierId);
    if (!$objDossierMip)
    {
      throw new Exception("Le dossier MIP n'existe pas.");
    }

    // variables à remplacer
    $arrVariables["date"]           = date("d/m/Y");
    $arrVariables["dossier_numero"] = $objDossierMip->getNumero();
    $arrVariables["dossier_titre"]  = $objDossierMip->getTitre();
    $arrVariables["dossier_incr"]   = $objDossierMip->getNumeroIncrement();
    
    //Réception lettre de décision de soutien
    $objSoutien = SoutienTable::getInstance()->findOneByDossierMipId($intDossierId);
    if($objSoutien)
    {
      $arrVariables["reference_lettre_soutien"] = $objSoutien->getReference() != NULL ? "1) ".$objSoutien->getReference(): "";
    }
    else
    {
      $arrVariables["reference_lettre_soutien"]="";
    }

    //Réception CR
    $objReceptionCR = Remise_documentsTable::getInstance()->findOneByDossierMipId($intDossierId);
    if($objReceptionCR)
    {
      if($objReceptionCR->getReference_cr() != NULL)
      {
        $arrVariables["reference_reception_cr"] = "2) ".$objReceptionCR->getReference_cr();
        $arrVariables["reference_video"]=libelle_rtf("msg_rtf_libelle_reference_2");
      }
      else
      {
        $arrVariables["reference_reception_cr"]="";
        $arrVariables["reference_video"]="";
      }

      $arrVariables["video"] = $objReceptionCR->getDate_reception_video() != NULL ? libelle_rtf("msg_rtf_avec_video"):"";
      $arrVariables["piece_jointe_cr"] = $objReceptionCR->getReference_video() != NULL ? $objReceptionCR->getReference_video():"";

    }
    else
    {
      $arrVariables["reference_reception_cr"] = "";
      $arrVariables["video"]="";
      $arrVariables["piece_jointe_cr"]="";
    }

    //référence video
    if($arrVariables["video"]!="")
    {
      $arrVariables["reference_video"]=libelle_rtf("msg_rtf_libelle_reference_2");
    }
    else
    {
      $arrVariables["reference_video"]="";
    }

    //cloture
    $objCloture = Transfert_clotureTable::getInstance()->findOneByDossierMipId($intDossierId);
    if($objCloture)
    {
      if($objCloture->getDate_cloture() != NULL)
      {
        $arrVariables["cloture"] = libelle_rtf("msg_rtf_mene_a_son_terme");
        $arrVariables["dossier_cloture"] = libelle_rtf("msg_rtf_dossier_cloture");
      }
      else
      {
        $arrVariables["cloture"] = libelle_rtf("msg_rtf_abandonne");
        $arrVariables["dossier_cloture"] = "";
      }
    }
    else
    {
      $arrVariables["cloture"]="";
      $arrVariables["dossier_cloture"]="";
    }
   

    // pilote
    $objPilote = $objDossierMip->getPilote();
    $objPiloteGrade = $objPilote->getGrade();
    $arrVariables["pilote"]        = libelle_rtf("msg_rtf_grade_prenom_nom", array($objPiloteGrade != null ? $objPiloteGrade->getIntitule() : "", $objPilote->getPrenom(), $objPilote->getNom()));
    $arrVariables["pilote_tel"]    = $objPilote->getTelephoneFixe() != "" ? $objPilote->getTelephoneFixe() : $objPilote->getTelephoneMobile();
    $arrVariables["pilote_fax"]    = $objPilote->getFax();
    $arrVariables["pilote_mail"]   = $objPilote->getEmail();

    // innovateur
    $arrInnovateurs = $objDossierMip->getInnovateurs();
    $objInnovateur = $arrInnovateurs[0];
    $objEntiteInnovateur = $objInnovateur->getEntite();
    $objInnovateurGrade = $objInnovateur->getGrade();
    $objInnovateurCivilite = $objInnovateur->getCivilite();
    $arrVariables["innovateur"] = libelle_rtf("msg_rtf".($objInnovateurCivilite->getId() == CiviliteTable::M ? "_le" : "_la")."_grade_prenom_nom_entite",
                                                array($objInnovateurGrade != null ? $objInnovateurGrade->getIntitule() : "",
                                                      $objInnovateur->getPrenom(),
                                                      $objInnovateur->getNom(),
                                                      $objEntiteInnovateur->getIntitule()));


	// Libellés destinataires et correspondant de l'armée / organisme MINDEF du dossier
	$objOrganismeTable = Libelle_organismeTable::getInstance();
	$objLibelleOrganisme = $objOrganismeTable->getLibelleByMetier($objDossierMip->getOrganismeMindefId(), MetierTable::MIP_ID);
	$arrVariables["libelle_destinataire"]   = ($objLibelleOrganisme != null) ? strip_tags($objLibelleOrganisme->getLibelleSimple()) : "";
													  
    // unité de l'innovateur
    $arrVariables["copie_unite_innov"] = str_replace("\n", self::CAR_NL,
                                            libelle_rtf("msg_rtf_unite_innovateur",
                                                        array($objEntiteInnovateur->getIntitule(),
                                                              $objEntiteInnovateur->getLieu(),
                                                              $objEntiteInnovateur->getVille()->getCodePostal(),
                                                              $objEntiteInnovateur->getVille()->getNom(),
                                                              $arrVariables["innovateur"])));

    //contact SE
    $arrContacts = array();
    $objEntite = $objInnovateur->getEntite();
    
    $objContactSe = Contact_seTable::getInstance()->getContactSEParEntite($objEntite->getId());

    $strCopieEntites2.= libelle_rtf("msg_rtf_unite_contact_se",
                                              array($objEntite->getIntitule(),
                                                    $objEntite->getLieu(),
                                                    $objEntite->getVille()->getCodePostal(),
                                                    $objEntite->getVille()->getNom(),
                                                    $objContactSe->getPrenom()." ".$objContactSe->getNom()));

    

    $arrVariables["contact_se"] = $strCopieEntites2;
    
    return $arrVariables;
  }

    /**
   * Permet de générer la lettre de cloture pour plusieurs innovateurs à un organisme Mindef
   * @param integer $intDossierId ID de dossier MIP
   * @return array Variables à remplacer
   * @throws Exception Si le dossier n'existe pas
   * @author Jihad
   */
  private function creerDocumentMipCloturePlusieursInnovateursMindef($intDossierId)
  {
    // on récupere le dossier
    $objDossierMip = Dossier_mipTable::getInstance()->findOneById($intDossierId);
    if (!$objDossierMip)
    {
      throw new Exception("Le dossier MIP n'existe pas.");
    }

    // variables à remplacer
    $arrVariables["date"]           = date("d/m/Y");
    $arrVariables["dossier_numero"] = $objDossierMip->getNumero();
    $arrVariables["dossier_titre"]  = $objDossierMip->getTitre();
    $arrVariables["dossier_incr"]   = $objDossierMip->getNumeroIncrement();

    //Réception lettre de décision de soutien
    $objSoutien = SoutienTable::getInstance()->findOneByDossierMipId($intDossierId);
    if($objSoutien)
    {
      $arrVariables["reference_lettre_soutien"] = $objSoutien->getReference() != NULL ? "1) ".$objSoutien->getReference(): "";
    }
    else
    {
      $arrVariables["reference_lettre_soutien"]="";
    }

    //Réception CR
    $objReceptionCR = Remise_documentsTable::getInstance()->findOneByDossierMipId($intDossierId);
    if($objReceptionCR)
    {
      if($objReceptionCR->getReference_cr() != NULL)
      {
        $arrVariables["reference_reception_cr"] = "2) ".$objReceptionCR->getReference_cr();
        $arrVariables["reference_video"]=libelle_rtf("msg_rtf_libelle_reference_2");
      }
      else
      {
        $arrVariables["reference_reception_cr"]="";
        $arrVariables["reference_video"]="";
      }

      $arrVariables["video"] = $objReceptionCR->getDate_reception_video() != NULL ? libelle_rtf("msg_rtf_avec_video"):"";
      $arrVariables["piece_jointe_cr"] = $objReceptionCR->getReference_video() != NULL ? $objReceptionCR->getReference_video():"";

    }
    else
    {
      $arrVariables["reference_reception_cr"] = "";
      $arrVariables["video"]="";
      $arrVariables["piece_jointe_cr"]="";
    }

    //référence video
    if($arrVariables["video"]!="")
    {
      $arrVariables["reference_video"]=libelle_rtf("msg_rtf_libelle_reference_2");
    }
    else
    {
      $arrVariables["reference_video"]="";
    }

    //cloture
    $objCloture = Transfert_clotureTable::getInstance()->findOneByDossierMipId($intDossierId);
    if($objCloture)
    {
      if($objCloture->getDate_cloture() != NULL)
      {
        $arrVariables["cloture"] = libelle_rtf("msg_rtf_mene_a_son_terme");
        $arrVariables["dossier_cloture"] = libelle_rtf("msg_rtf_dossier_cloture");
      }
      else
      {
        $arrVariables["cloture"] = libelle_rtf("msg_rtf_abandonne");
        $arrVariables["dossier_cloture"] = "";
      }
    }
    else
    {
      $arrVariables["cloture"]="";
      $arrVariables["dossier_cloture"]="";
    }


    // pilote
    $objPilote = $objDossierMip->getPilote();
    $objPiloteGrade = $objPilote->getGrade();
    $arrVariables["pilote"]        = libelle_rtf("msg_rtf_grade_prenom_nom", array($objPiloteGrade != null ? $objPiloteGrade->getIntitule() : "", $objPilote->getPrenom(), $objPilote->getNom()));
    $arrVariables["pilote_tel"]    = $objPilote->getTelephoneFixe() != "" ? $objPilote->getTelephoneFixe() : $objPilote->getTelephoneMobile();
    $arrVariables["pilote_fax"]    = $objPilote->getFax();
    $arrVariables["pilote_mail"]   = $objPilote->getEmail();

    // innovateur
    $arrInnovateurs = $objDossierMip->getInnovateurs();

    $strInnovateurs = "";
    $arrEntites = array();
    $arrEntiteInnovateurs = array();
    foreach($arrInnovateurs as $intI => $objInnovateur)
    {
      // on stocke les entités
      if (!isset($arrEntites[$objInnovateur->getEntiteId()]))
      {
        $arrEntites[$objInnovateur->getEntiteId()] = $objInnovateur->getEntite();
      }

      // on stocke les innovateurs de l'entité
      if (!isset($arrEntiteInnovateurs[$objInnovateur->getEntiteId()]))
      {
        $arrEntiteInnovateurs[$objInnovateur->getEntiteId()] = array();
      }
      $arrEntiteInnovateurs[$objInnovateur->getEntiteId()][] = $intI;

      $objInnovateurGrade = $objInnovateur->getGrade();
      $strInnovateurs .= ($strInnovateurs != "" ? (count($arrInnovateurs) - 1 == $intI ? " et " : ", ") : "");

      $objInnovateurCivilite = $objInnovateur->getCivilite();
      $strInnovateurs .= libelle_rtf("msg_rtf".($objInnovateurCivilite->getId() == CiviliteTable::M ? "_le" : "_la")."_grade_prenom_nom_entite",
                                        array($objInnovateurGrade != null ? $objInnovateurGrade->getIntitule() : "",
                                              $objInnovateur->getPrenom(),
                                              $objInnovateur->getNom(),
                                              $arrEntites[$objInnovateur->getEntiteId()]->getIntitule()));
    }
    $arrVariables["innovateurs"] = $strInnovateurs;

	// Libellés destinataires et correspondant de l'armée / organisme MINDEF du dossier
	$objOrganismeTable = Libelle_organismeTable::getInstance();
	$objLibelleOrganisme = $objOrganismeTable->getLibelleByMetier($objDossierMip->getOrganismeMindefId(), MetierTable::MIP_ID);
	$arrVariables["libelle_destinataire"]   = ($objLibelleOrganisme != null) ? strip_tags($objLibelleOrganisme->getLibelleSimple()) : "";
	
    // unité de l'innovateur
    $strCopieEntites = "";
    foreach($arrEntites as $objEntite)
    {
      $strCopieEntites .= ($strCopieEntites != "" ? self::CAR_NL.self::CAR_NL : "");

      $strCopieEntitesInnovateurs = "";
      foreach($arrEntiteInnovateurs[$objEntite->getId()] as $intI => $intInnovateurId)
      {
        $objInnovateurGrade = $arrInnovateurs[$intInnovateurId]->getGrade();
        $strCopieEntitesInnovateurs .= ($strCopieEntitesInnovateurs != "" ? (count($arrEntiteInnovateurs[$objEntite->getId()]) - 1 == $intI ? " et " : ", ") : "");
        $strCopieEntitesInnovateurs .= libelle_rtf("msg_rtf_grade_prenom_nom",
                                        array($objInnovateurGrade != null ? $objInnovateurGrade->getIntitule() : "",
                                              $arrInnovateurs[$intInnovateurId]->getPrenom(),
                                              $arrInnovateurs[$intInnovateurId]->getNom(),
                                              $objEntite->getIntitule()));
      }

      $strCopieEntites .= libelle_rtf("msg_rtf_unite_innovateur",
                                                  array($objEntite->getIntitule(),
                                                        $objEntite->getLieu(),
                                                        $objEntite->getVille()->getCodePostal(),
                                                        $objEntite->getVille()->getNom(),
                                                        $strCopieEntitesInnovateurs));
    }

    $arrVariables["copie_unite_innov"] = $strCopieEntites;

    //contact SE
    $strContactSe = "";
    $arrContacts = array();
    foreach($arrEntites as $objEntite)
    {
      $strCopieEntites2 .= ($strCopieEntites2 != "" ? self::CAR_NL.self::CAR_NL : "");
      $objContactSe = Contact_seTable::getInstance()->getContactSEParEntite($objEntite->getId());

      $strContactSe .= ($strContactSe != "" ? ($arrContacts[$intI] == count($arrContacts)-1 ? " et " : ", ") : "");
      $strContactSe .= libelle_rtf("msg_rtf_prenom_nom",array($objContactSe->getPrenom(),
                                                                    $objContactSe->getNom(),
                                                                    ));

      $strCopieEntites2.= libelle_rtf("msg_rtf_unite_contact_se",
                                                array($objEntite->getIntitule(),
                                                      $objEntite->getLieu(),
                                                      $objEntite->getVille()->getCodePostal(),
                                                      $objEntite->getVille()->getNom(),
                                                      $objContactSe->getPrenom()." ".$objContactSe->getNom()));

    }
    
    $arrVariables["contact_se"] = $strCopieEntites2;
    return $arrVariables;
  }

  /**
   * Permet de générer la lettre de cloture pour un innovateur"
   * @param integer $intDossierId ID de dossier MIP
   * @return array Variables à remplacer
   * @throws Exception Si le dossier n'existe pas
   * @author Jihad Sahebdin
   */
  private function creerDocumentMipAccuseReception($intDossierId,$intIdInnovateur)
  {
    // on récupere le dossier
    $objDossierMip = Dossier_mipTable::getInstance()->findOneById($intDossierId);
    if (!$objDossierMip)
    {
      throw new Exception("Le dossier MIP n'existe pas.");
    }

    // variables à remplacer
    $arrVariables["date"]           = date("d/m/Y");
    $arrVariables["dossier_incr"]   = $objDossierMip->getNumeroIncrement();
    $arrVariables["dossier_numero"] = $objDossierMip->getNumero();
    $arrVariables["dossier_titre"]  = $objDossierMip->getTitre();

    // pilote
    $objPilote = $objDossierMip->getPilote();
    $objPiloteGrade = $objPilote->getGrade();
    $arrVariables["pilote"]        = libelle_rtf("msg_rtf_grade_prenom_nom", array($objPiloteGrade != null ? $objPiloteGrade->getIntitule() : "", $objPilote->getPrenom(), $objPilote->getNom()));
    $arrVariables["pilote_tel"]    = $objPilote->getTelephoneFixe() != "" ? $objPilote->getTelephoneFixe() : $objPilote->getTelephoneMobile();
    $arrVariables["pilote_fax"]    = $objPilote->getFax();
    $arrVariables["pilote_mail"]   = $objPilote->getEmail();

    $arrVariables["date_rdv"] = "{DATE_RDV}";
    
    //unite
    $objInnovateur = UtilisateurTable::getInstance()->findOneById($intIdInnovateur);
    $arrVariables["unite"] =  $objInnovateur->getEntite()->getIntitule();

    //ville
    $arrVariables["ville"] = $objInnovateur->getEntite()->getVille()->getNom();

    //organisme_mindef
    $arrVariables["nom_organisme"] = $objInnovateur->getEntite()->getOrganisme_mindef()->getIntitule();
    

    // innovateur
    $objInnovateur = UtilisateurTable::getInstance()->findOneById($intIdInnovateur);
    $objInnovateurGrade = $objInnovateur->getGrade();
    $objInnovateurCivilite = $objInnovateur->getCivilite();
    $objEntiteInnovateur = $objInnovateur->getEntite();
    $arrVariables["innovateur"] = libelle_rtf("msg_rtf".($objInnovateurCivilite->getId() == CiviliteTable::M ? "_le" : "_la")."_grade_prenom_nom",
                                                array($objInnovateurGrade != null ? $objInnovateurGrade->getIntitule() : "",
                                                      $objInnovateur->getPrenom(),
                                                      $objInnovateur->getNom(),
                                                      ));

    // unité de l'innovateur
    $arrEntites = array();
    $arrInnovateurs = $objDossierMip->getInnovateurs();

    foreach($arrInnovateurs as $intI => $objInnovateur)
    {
      // on stocke les entités
      if (!isset($arrEntites[$objInnovateur->getEntiteId()]))
      {
        $arrEntites[$objInnovateur->getEntiteId()] = $objInnovateur->getEntite();
      }

      // on stocke les innovateurs de l'entité
      if (!isset($arrEntiteInnovateurs[$objInnovateur->getEntiteId()]))
      {
        $arrEntiteInnovateurs[$objInnovateur->getEntiteId()] = array();
      }
      $arrEntiteInnovateurs[$objInnovateur->getEntiteId()][] = $intI;

      $objInnovateurGrade = $objInnovateur->getGrade();
      $strInnovateurs .= ($strInnovateurs != "" ? (count($arrInnovateurs) - 1 == $intI ? " et " : ", ") : "");

      $objInnovateurCivilite = $objInnovateur->getCivilite();
      $strInnovateurs .= libelle_rtf("msg_rtf".($objInnovateurCivilite->getId() == CiviliteTable::M ? "_le" : "_la")."_grade_prenom_nom_entite",
                                        array($objInnovateurGrade != null ? $objInnovateurGrade->getIntitule() : "",
                                              $objInnovateur->getPrenom(),
                                              $objInnovateur->getNom(),
                                              $arrEntites[$objInnovateur->getEntiteId()]->getIntitule()));
    }



    $strCopieEntites = "";
    foreach($arrEntites as $objEntite)
    {
      $strCopieEntites .= ($strCopieEntites != "" ? self::CAR_NL.self::CAR_NL : "");

      $strCopieEntitesInnovateurs = "";
      foreach($arrEntiteInnovateurs[$objEntite->getId()] as $intI => $intInnovateurId)
      {
        $objInnovateurGrade = $arrInnovateurs[$intInnovateurId]->getGrade();
        $strCopieEntitesInnovateurs .= ($strCopieEntitesInnovateurs != "" ? (count($arrEntiteInnovateurs[$objEntite->getId()]) - 1 == $intI ? " et " : ", ") : "");
        $strCopieEntitesInnovateurs .= libelle_rtf("msg_rtf_grade_prenom_nom",
                                        array($objInnovateurGrade != null ? $objInnovateurGrade->getIntitule() : "",
                                              $arrInnovateurs[$intInnovateurId]->getPrenom(),
                                              $arrInnovateurs[$intInnovateurId]->getNom(),
                                              $objEntite->getIntitule()));
      }

      $strCopieEntites .= libelle_rtf("msg_rtf_unite_innovateur",
                                                  array($objEntite->getIntitule(),
                                                        $objEntite->getLieu(),
                                                        $objEntite->getVille()->getCodePostal(),
                                                        $objEntite->getVille()->getNom(),
                                                        $strCopieEntitesInnovateurs));
    }

    $arrVariables["copie_unite_innov"] = $strCopieEntites;

    return $arrVariables;
  }
}
