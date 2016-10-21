<?php

/**
 * Classe permettant de générer un fichier document MRIS
 * @author Gabor JAGER
 */
class ServiceDocumentMris extends ServiceDocument
{
  /**
   * Permet de générer un document MRIS dans le répertoire temporaire
   * @param integer $intCommissionId ID de commission
   * @param integer $intParticipantInterneId ID de participant interne
   * @return string Nom de fichier généré (sans chemin)
   * @throws Exception Si le modele n'est pas disponible ou si le dossier n'existe pas
   * @author Gabor JAGER
   */
  public function creerDocumentInvitationInterne($intCommissionId, $intParticipantInterneId)
  {
    $objUtilArbo = new ServiceArborescence();
    // prefixe de fichier généré
    $strFichierPrefixe = "invitation_interne";

    // on récupere le commission
    $objCommission = CommissionTable::getInstance()->findOneById($intCommissionId);
    if (!$objCommission)
    {
      throw new Exception(libelle("msg_libelle_documentsmris_aucune_commission"));
    }

    // on récupere le participant interne
    $objParticipantInterne = UtilisateurTable::getInstance()->findOneById($intParticipantInterneId);
    if (!$objParticipantInterne)
    {
      throw new Exception(libelle("msg_libelle_documentsmris_aucun_participant"));
    }

    //on récupère l'entité d'affectation pour l'adresse
    $objEntite = EntiteTable::getInstance()->findOneById($objParticipantInterne->getEntiteId() != null ? $objParticipantInterne->getEntiteId() : 0);
    //if (!$objEntite)
    //{
      //throw new Exception("Il n'y a pas d'entité.");
    //}

    // modèle utilisé
    $strFichierModele = $objUtilArbo->getRepertoireFichiersStatiques() . $objUtilArbo->getLettreInvitationPersonne();

    // variables à remplacer
    $arrVariables = array();

    // variables communes
    $this->remplirInvitationCommune($arrVariables, $objCommission);
    
    // organisme
    $arrVariables["organisme"] = libelle_rtf("msg_rtf_organisme_service", array($objParticipantInterne->getOrganisme_mindef()->getIntitule(), $objParticipantInterne->getEntite()->getIntitule()));
    
    // variables à remplacer - participant interne
    $arrVariables["personne"]          = libelle_rtf("msg_rtf_civilite_prenom_nom", array($objParticipantInterne->getCivilite()->getAbreviation(), $objParticipantInterne->getPrenom(), $objParticipantInterne->getNom()));
	if($objEntite != null)
	{
	  $arrVariables["personne_adresse"]  = $objEntite->getLieu();
	  $arrVariables["personne_cp_ville"] = libelle_rtf("msg_rtf_codepostal_ville", array($objEntite->getVille()->getCodePostal(), $objEntite->getVille()->getNom()));
	}
    
    // création du fichier
    return $this->creerDocumentModeleStatique($strFichierModele, $strFichierPrefixe, $arrVariables);
  }

  /**
   * Permet de remplier les variables communes d'une invitation
   * @param array $arrVariables tableau de remplacement
   * @param Commission $objCommission
   * @author Gabor JAGER
   */
  private function remplirInvitationCommune(&$arrVariables, Commission $objCommission)
  {
    // variables à remplacer
    $arrVariables["date"] = date("d/m/Y");

    // variables à remplacer - commission
    $arrVariables["commission_dates"] = libelle_rtf("msg_rtf_du_au", array(libelle("msg_rtf_date_heure", array(formatDate($objCommission->getDateDebut()), formatHeure($objCommission->getDateDebut()))),
                                                                           libelle("msg_rtf_date_heure", array(formatDate($objCommission->getDateFin()), formatHeure($objCommission->getDateFin())))));
    $arrVariables["commission_type"]           = $objCommission->getEstSelection() ? libelle_rtf("msg_rtf_commission_selection") : libelle_rtf("msg_rtf_commission_preselection");
    $arrVariables["commission_dossiers_types"] = libelle_rtf("msg_rtf_valeur", array(mb_strtolower($objCommission->getType_dossier_mris()->getIntitule(), 'UTF-8')));

    $utilDate = new UtilDate();
    $arrVariables["annee_scolaire"] = $utilDate->getAnneeScolaire($objCommission->getDateDebut());
  }

  /**
   * Permet de générer un document MRIS dans le répertoire temporaire
   * @param integer $intCommissionId ID de commission
   * @param integer $intParticipantExterneId ID de participant externe
   * @return string Nom de fichier généré (sans chemin)
   * @throws Exception Si le modele n'est pas disponible ou si le dossier n'existe pas
   * @author Gabor JAGER
   */
  public function creerDocumentInvitationExterne($intCommissionId, $intParticipantExterneId)
  {
    $objUtilArbo =  new ServiceArborescence();
    // prefixe de fichier généré
    $strFichierPrefixe = "invitation_externe";

    // on récupere le commission
    $objCommission = CommissionTable::getInstance()->findOneById($intCommissionId);
    if (!$objCommission)
    {
      throw new Exception(libelle("msg_libelle_documentsmris_aucune_commission"));
    }

    // on récupere le participant interne
    $objParticipantExterne = IntervenantTable::getInstance()->findOneById($intParticipantExterneId);
    if (!$objParticipantExterne) {
      throw new Exception(libelle("msg_libelle_documentsmris_aucun_participant"));
    }

    // modèle utilisé
    $strFichierModele = $objUtilArbo->getRepertoireFichiersStatiques() . $objUtilArbo->getLettreInvitationPersonne();

    $arrVariables = array();

    //recherche de l'adresse: on cherche d'abord l'adresse du labo et ensuite celui du service et enfin celui de l'organisme
    $ptContact = null;
    if ($objParticipantExterne->getLaboratoireId() != null) {
      $arrVariables["organisme"] = libelle_rtf("msg_rtf_organisme_service", array($objParticipantExterne->getLaboratoire()->getOrganisme()->getIntitule(), $objParticipantExterne->getLaboratoire()->getIntitule()));
      $ptContact = $this->recherchePtContactLaboratoire($objParticipantExterne->getLaboratoireId());
      //si on ne trouve pas de points de contact on continue la recherche
      if ($ptContact == null && $objParticipantExterne->getServiceId() != null) {
        $arrVariables["organisme"] = libelle_rtf("msg_rtf_organisme_service", array($objParticipantExterne->getService()->getOrganisme()->getIntitule(), $objParticipantExterne->getService()->getIntitule()));
        $ptContact = $this->recherchePtContactService($objParticipantExterne->getServiceId());
        //si on ne trouve pas de points de contact on continue la recherche
        if($ptContact == null && $objParticipantExterne->getOrganismeId() != null){
           $arrVariables["organisme"] = $objParticipantExterne->getOrganisme()->getIntitule();
           $ptContact = $this->recherchePtContactOrganisme($objParticipantExterne->getOrganismeId());
        }

      } else if ($ptContact == null && $objParticipantExterne->getOrganismeId() != null) {
        $arrVariables["organisme"] = $objParticipantExterne->getOrganisme()->getIntitule();
        $ptContact = $this->recherchePtContactOrganisme($objParticipantExterne->getOrganismeId());
      }

    } else if ($objParticipantExterne->getServiceId() != null) {
      $arrVariables["organisme"] = libelle_rtf("msg_rtf_organisme_service", array($objParticipantExterne->getService()->getOrganisme()->getIntitule(), $objParticipantExterne->getService()->getIntitule()));
      $ptContact = $this->recherchePtContactService($objParticipantExterne->getServiceId());
      //si on ne trouve pas de points de contact on continue la recherche
      if($ptContact == null && $objParticipantExterne->getOrganismeId() != null) {
         $arrVariables["organisme"] = $objParticipantExterne->getOrganisme()->getIntitule();
         $ptContact = $this->recherchePtContactOrganisme($objParticipantExterne->getOrganismeId());
      }

    } else if ($objParticipantExterne->getOrganismeId() != null) {
      $arrVariables["organisme"] = $objParticipantExterne->getOrganisme()->getIntitule();
      $ptContact = $this->recherchePtContactOrganisme($objParticipantExterne->getOrganismeId());
    } else {
      $arrVariables["organisme"] = "";
    }


    // variables à remplacer - commission
    $this->remplirInvitationCommune($arrVariables, $objCommission);

    // variables à remplacer - participant interne
    $arrVariables["personne"] = libelle_rtf("msg_rtf_civilite_prenom_nom", array($objParticipantExterne->getCivilite()->getAbreviation(), $objParticipantExterne->getPrenom(), $objParticipantExterne->getNom()));
    if ($ptContact != null)
    {
      //on vérifie s'il y y a une adresse Française, sinon on essaye avec une adresse étrangère
      if ($ptContact->getAdresse() != null)
      {
        $arrVariables["personne_adresse"] = $ptContact->getAdresse();
        $arrVariables["personne_cp_ville"] = libelle_rtf("msg_rtf_codepostal_ville", array($ptContact->getVille()->getCodePostal(), $ptContact->getVille()->getNom()));
      } 
      else if ($ptContact->getAdresseEtrangere() != null)
      {
        $arrVariables["personne_adresse"] = $ptContact->getAdresseEtrangere();
        $arrVariables["personne_cp_ville"] = $ptContact->getPaysId() != null ? $ptContact->getPays()->getNom() : "";
      } 
      else
      {
        $arrVariables["personne_adresse"]  = "";
        $arrVariables["personne_cp_ville"] = "";
      }
    }
    else
    {
      $arrVariables["personne_adresse"]  = "";
      $arrVariables["personne_cp_ville"] = "";
    }

    // création du fichier
    return $this->creerDocumentModeleStatique($strFichierModele, $strFichierPrefixe, $arrVariables);
  }

  /**
   * Permet de chercher un point contact
   * @param integer $laboId
   * @return Point_contact
   */
  private function recherchePtContactLaboratoire($laboId){
    $queryPointContacts = Point_contactTable::getInstance()->retrieveByLaboratoireIdAndMetierId($laboId, MetierTable::MRIS_ID);
    if($queryPointContacts->count() == 0){
      $ptContact = null;
    }else{
      $arrPointContacts =  $queryPointContacts->execute();
      $ptContact = $arrPointContacts[0];
    }
    return $ptContact;
  }

  /**
   * Permet de chercher un point contact
   * @param integer $serviceId
   * @return Point_contact
   */
  private function recherchePtContactService($serviceId){
    $queryPointContacts = Point_contactTable::getInstance()->retrieveByServiceIdAndMetierId($serviceId, MetierTable::MRIS_ID);
    if($queryPointContacts->count() == 0){
      $ptContact = null;
    } else {
      $arrPointContacts =  $queryPointContacts->execute();
      $ptContact = $arrPointContacts[0];
    }
    return $ptContact;
  }

  /**
   * Permet de chercher un point contact
   * @param integer $organismeId
   * @return Point_contact
   */
  private function recherchePtContactOrganisme($organismeId) {
    $queryPointContacts = Point_contactTable::getInstance()->retrieveByOrganismeIdAndMetierId($organismeId, MetierTable::MRIS_ID);
    if($queryPointContacts->count() == 0){
      $ptContact = null;
    } else {
      $arrPointContacts =  $queryPointContacts->execute();
      $ptContact = $arrPointContacts[0];
    }
    return $ptContact;
  }

  /**
   * Permet de générer un document MRIS dans le répertoire temporaire
   * @param integer $intCommissionId ID de commission
   * @param integer $intLaboratoireId ID de laboratoire
   * @return string Nom de fichier généré (sans chemin)
   * @throws Exception Si le modele n'est pas disponible ou si le dossier n'existe pas
   * @author Gabor JAGER
   */
  public function creerDocumentInvitationLaboratoire($intCommissionId, $intLaboratoireId)
  {
    $objUtilArbo = new ServiceArborescence();
    // prefixe de fichier généré
    $strFichierPrefixe = "invitation_laboratoire";

    // on récupere le commission
    $objCommission = CommissionTable::getInstance()->findOneById($intCommissionId);
    if (!$objCommission)
    {
      throw new Exception(libelle("msg_libelle_documentsmris_aucune_commission"));
    }

    // on récupere le participant interne
    $objLaboratoire = LaboratoireTable::getInstance()->findOneById($intLaboratoireId);
    if (!$objLaboratoire)
    {
      throw new Exception(libelle("msg_libelle_documentsmris_aucun_laboratoire"));
    }

    // modèle utilisé
    $strFichierModele = $objUtilArbo->getRepertoireFichiersStatiques() . $objUtilArbo->getLettreInvitationLaboratoire();

    $arrVariables = array();
    
    // variables à remplacer - commission
    $this->remplirInvitationCommune($arrVariables, $objCommission);

    // variables à remplacer - laboratoire
    $arrVariables["organisme"]   = $objLaboratoire->getOrganisme()->getIntitule();
    $arrVariables["laboratoire"] = $objLaboratoire->getIntitule();

    $objPointContact = $this->recherchePtContactLaboratoire($intLaboratoireId);
    if ($objPointContact == null)
    {
      $arrVariables["laboratoire_adresse"]  = "";
      $arrVariables["laboratoire_cp_ville"] = "";
    }
    else
    {
      if ($objPointContact->getAdresse() != null)
      {
        $arrVariables["laboratoire_adresse"]  = $objPointContact->getAdresse();
        $arrVariables["laboratoire_cp_ville"] = libelle_rtf("msg_rtf_codepostal_ville", array($objPointContact->getCodePostal() != null ? $objPointContact->getCodePostal() : $objPointContact->getVille()->getCodePostal(), $objPointContact->getVille()->getNom()));
      }
      else if ($objPointContact->getAdresseEtrangere() != null)
      {
        $arrVariables["laboratoire_adresse"]  = $objPointContact->getAdresseEtrangere();
        $arrVariables["laboratoire_cp_ville"] = $objPointContact->getPaysId() != null ? $objPointContact->getPays()->getNom() : "";
      }
      else
      {
        $arrVariables["personne_adresse"]  = "";
        $arrVariables["personne_cp_ville"] = "";
      }
    }

    // création du fichier
    return $this->creerDocumentModeleStatique($strFichierModele, $strFichierPrefixe, $arrVariables);
  }

  /**
   * Permet de générer un document MRIS dans le répertoire temporaire
   * @param integer $intCommissionId ID de commission
   * @param integer $intServiceId ID de service
   * @return string Nom de fichier généré (sans chemin)
   * @throws Exception Si le modele n'est pas disponible ou si le dossier n'existe pas
   * @author Gabor JAGER
   */
  public function creerDocumentInvitationService($intCommissionId, $intServiceId)
  {
    $objUtilArbo = new ServiceArborescence();
    // prefixe de fichier généré
    $strFichierPrefixe = "invitation_service";

    // on récupere le commission
    $objCommission = CommissionTable::getInstance()->findOneById($intCommissionId);
    if (!$objCommission)
    {
      throw new Exception(libelle("msg_libelle_documentsmris_aucune_commission"));
    }

    // on récupere le participant interne
    $objService = ServiceTable::getInstance()->findOneById($intServiceId);
    if (!$objService)
    {
      throw new Exception(libelle("msg_libelle_documentsmris_aucun_service"));
    }

    // modèle utilisé
    $strFichierModele = $objUtilArbo->getRepertoireFichiersStatiques() . $objUtilArbo->getLettreInvitationService();

    $arrVariables = array();
    
    // variables à remplacer - commission
    $this->remplirInvitationCommune($arrVariables, $objCommission);
    
    // variables à remplacer - service
    $arrVariables["organisme"] = $objService->getOrganisme()->getIntitule();
    $arrVariables["service"]   = $objService->getIntitule();

    // point contact
    $objPointContact = $this->recherchePtContactService($intServiceId);
    if ($objPointContact == null)
    {
      $arrVariables["service_adresse"]  = "";
      $arrVariables["service_cp_ville"] = "";
    }

    else
    {
      if ($objPointContact->getAdresse() != null)
      {
        $arrVariables["service_adresse"]  = $objPointContact->getAdresse();
        $arrVariables["service_cp_ville"] = libelle_rtf("msg_rtf_codepostal_ville", array($objPointContact->getCodePostal() != null ? $objPointContact->getCodePostal() : $objPointContact->getVille()->getCodePostal(), $objPointContact->getVille()->getNom()));
      }
      else if ($objPointContact->getAdresseEtrangere() != null)
      {
        $arrVariables["service_adresse"]  = $objPointContact->getAdresseEtrangere();
        $arrVariables["service_cp_ville"] = $objPointContact->getPaysId() != null ? $objPointContact->getPays()->getNom() : "";
      }
      else
      {
        $arrVariables["service_adresse"]  = "";
        $arrVariables["service_cp_ville"] = "";
      }
    }

    // création du fichier
    return $this->creerDocumentModeleStatique($strFichierModele, $strFichierPrefixe, $arrVariables);
  }

  /**
   * Permet de générer un document MRIS dans le répertoire temporaire pour la validation d'un dossier dans le cas d'un refus
   * @param integer $intDossierId Id du dossier MRIS
   * @param string $typeDossier Type du dossier MRIS (Dossier_these, Dossier_postdoc, Dossier_ere)
   * @return string
   * @author Alexandre WETTA
   */
  public function creerDocumentValidationRefus($intDossierId, $typeDossier){
    $objUtilArbo = new ServiceArborescence();

    if($typeDossier == 'Dossier_these'){
      $strModelDossier = "Dossier_these";
      $strModelEncadrant = "Encadrant_these" ;
    } else if ($typeDossier == 'Dossier_postdoc'){
      $strModelDossier = "Dossier_postdoc";
      $strModelEncadrant = "Encadrant_postdoc" ;
    }else if ($typeDossier == 'Dossier_ere'){
      $strModelDossier = "Dossier_ere";
      $strModelEncadrant = "Encadrant_ere" ;
    }
    
    //recherche du dossier
    $objDossier = Doctrine_Core::getTable($strModelDossier)->findOneById($intDossierId);
    if (!$objDossier)
    {
      throw new Exception(libelle("msg_libelle_documentsmris_aucun_dossier"));
    }

    //recherche du directeur du dossier
    $objEncadrantFinal = null;
    if($typeDossier == 'Dossier_these'){
      $arrEncadrant = Doctrine_Core::getTable($strModelEncadrant)->findByDossierTheseId($intDossierId);
    } else if ($typeDossier == 'Dossier_postdoc') {
      $arrEncadrant = Doctrine_Core::getTable($strModelEncadrant)->findByDossierPostdocId($intDossierId);
    } else if ($typeDossier == 'Dossier_ere') {
      $arrEncadrant = Doctrine_Core::getTable($strModelEncadrant)->findByDossierEreId($intDossierId);
    }

    foreach ($arrEncadrant as $objEncadrant) {
      if ($typeDossier == 'Dossier_these') {
        if ($objEncadrant->getRoleTheseId() == Role_theseTable::DIRECTEUR_THESE) {
          $objEncadrantFinal = IntervenantTable::getInstance()->findOneById($objEncadrant->getIntervenantId());
        }
      } else if ($typeDossier == 'Dossier_postdoc') {
        if ($objEncadrant->getRolePostdocId() == Role_postdocTable::DIRECTEUR_POSTDOC) {
          $objEncadrantFinal = IntervenantTable::getInstance()->findOneById($objEncadrant->getIntervenantId());
        }
      } else if ($typeDossier == 'Dossier_ere') {
        if ($objEncadrant->getRoleEreId() == Role_ereTable::DIRECTEUR_ERE) {
          $objEncadrantFinal = IntervenantTable::getInstance()->findOneById($objEncadrant->getIntervenantId());
        }
      }
    }
    //vérification qu'il y a un directeur pour le dossier
    if ($objEncadrantFinal == null) {
      throw new Exception(libelle("msg_libelle_documentsmris_aucun_directeur"));
    }

    //recherche de l'étudiant
    $objEtudiant = EtudiantTable::getInstance()->findOneById($objDossier->getRealisePar());

    //recherche de la commission
    $objCommission = CommissionTable::getInstance()->retrieveCommissionSelection($objDossier->getCreatedAt(), strtolower($typeDossier) );

    // variables à remplacer - directeur
    $arrVariables["GENRE_DIRECTEUR"] = $objEncadrantFinal->getCivilite()->getIntitule();
    $arrVariables["ABR_GENRE_PRENOM_NOM_DIRECTEUR"] = $objEncadrantFinal->afficheEncadrantAbrLettre();
    $arrVariables["ORGANISME_DIRECTEUR"]        = $objEncadrantFinal->getNomOrganisme();
    if($objEncadrantFinal->getNomLaboratoire() != null){
      $arrVariables["ORGANISME_DIRECTEUR"] = $objEncadrantFinal->getNomOrganisme()."\n". $objEncadrantFinal->getNomLaboratoire();
    }

    //adresses du directeur
    if($objEncadrantFinal->getAdresse() != null){
      $arrVariables["ADRESSE_DIRECTEUR"]      = $objEncadrantFinal->getAdresse();
      $arrVariables["CODE_POSTAL_DIRECTEUR"]  = $objEncadrantFinal->getCodePostal();
      $arrVariables["VILLE_DIRECTEUR"]        = $objEncadrantFinal->getVille()->getNom();
      $arrVariables["ADRESSE_DIRECTEUR_COMPLEMENT"]     = $objEncadrantFinal->getComplementAdresse();
      $arrVariables["ADRESSE_ETRANGERE_DIRECTEUR_PAYS"] = "";
    }
    if($objEncadrantFinal->getAdresseEtrangere() != null){
      $arrVariables["ADRESSE_DIRECTEUR"]      = $objEncadrantFinal->getAdresseEtrangere();
      $arrVariables["ADRESSE_ETRANGERE_DIRECTEUR_PAYS"] = $objEncadrantFinal->getPays()->getNom();
      $arrVariables["CODE_POSTAL_DIRECTEUR"]  = "";
      $arrVariables["VILLE_DIRECTEUR"]        = "";
      $arrVariables["ADRESSE_DIRECTEUR_COMPLEMENT"]    = "";
    }

    // variables à remplacer - date
    $arrVariables["ANNEE_EN_COURS"]   = date("Y");
    $arrVariables["ANNEE_PROCHAINE"]  = date("Y",mktime(0,0,0,date('n'),date('j'),date('Y')+1));
    $arrVariables["DATE_EN_COURS"] = date("d/m/Y");

    // variables à remplacer - Etudiant
    $arrVariables["GENRE_NOM_COMPLET_ETUDIANT"] = $objEtudiant->getCivilite()->getIntitule();
    $arrVariables["GENRE_NOM_PRENOM_ETUDIANT"] = $objEtudiant;

    //variables du dossier
    $arrVariables["NUM_DOSSIER"] = $objDossier->getNumeroAAfficher();
    if ($typeDossier == 'Dossier_these') {
      $arrVariables["TYPE_DOSSIER"] = "thèse";
      $arrVariables["TYPE_DOSSIER_AVEC_DETER"] = "une thèse";
      $arrVariables["FINANCE"] = "financée";
    } else if ($typeDossier == 'Dossier_postdoc') {
      $arrVariables["TYPE_DOSSIER"] = "stage postdoctoral" ;
      $arrVariables["TYPE_DOSSIER_AVEC_DETER"] = "un stage postdoctoral";
      $arrVariables["FINANCE"] = "financé";
    } else if ($typeDossier == 'Dossier_ere') {
      $arrVariables["TYPE_DOSSIER"] = "stage ERE" ;
      $arrVariables["TYPE_DOSSIER_AVEC_DETER"] = "un stage ERE";
      $arrVariables["FINANCE"] = "financé";
    }


    //variables de la commission
    $arrVariables["DATE_COMMISSION"] = $objCommission->getDateTimeObject('date_debut')->format('d/m/Y');


    // prefixe de fichier généré
    $strFichierPrefixe = "validation_refus";
    
    // modèle utilisé
    if($objDossier->getMisEnAttenteLe()!= null){
      $strFichierModele = $objUtilArbo->getRepertoireFichiersStatiques() . $objUtilArbo->getLettreValidationRefusApresAttente();
    }else{
      $strFichierModele = $objUtilArbo->getRepertoireFichiersStatiques() . $objUtilArbo->getLettreValidationRefus();
    }

    // création du fichier
    return $this->creerDocumentModeleStatique($strFichierModele, $strFichierPrefixe, $arrVariables);
  }

  /**
   * Permet de générer un document MRIS dans le répertoire temporaire pour la validation d'un dossier dans le cas de la liste d'attente
   * @param integer $intDossierId Id du dossier MRIS
   * @param string $typeDossier Type du dossier MRIS (Dossier_these, Dossier_postdoc, Dossier_ere)
   * @return string
   * @author Alexandre WETTA
   */
  public function creerDocumentValidationListeAttente($intDossierId, $typeDossier) {
     $objUtilArbo = new ServiceArborescence();

    if ($typeDossier == 'Dossier_these') {
      $strModelDossier = "Dossier_these";
      $strModelEncadrant = "Encadrant_these";
    } else if ($typeDossier == 'Dossier_postdoc') {
      $strModelDossier = "Dossier_postdoc";
      $strModelEncadrant = "Encadrant_postdoc";
    } else if ($typeDossier == 'Dossier_ere') {
      $strModelDossier = "Dossier_ere";
      $strModelEncadrant = "Encadrant_ere";
    }

    //recherche du dossier
    $objDossier = Doctrine_Core::getTable($strModelDossier)->findOneById($intDossierId);
    if (!$objDossier) {
      throw new Exception(libelle("msg_libelle_documentsmris_aucun_dossier"));
    }

    //recherche du directeur du dossier
    $objEncadrantFinal = null;
    if ($typeDossier == 'Dossier_these') {
      $arrEncadrant = Doctrine_Core::getTable($strModelEncadrant)->findByDossierTheseId($intDossierId);
    } else if ($typeDossier == 'Dossier_postdoc') {
      $arrEncadrant = Doctrine_Core::getTable($strModelEncadrant)->findByDossierPostdocId($intDossierId);
    } else if ($typeDossier == 'Dossier_ere') {
      $arrEncadrant = Doctrine_Core::getTable($strModelEncadrant)->findByDossierEreId($intDossierId);
    }

    foreach ($arrEncadrant as $objEncadrant) {
      if ($typeDossier == 'Dossier_these') {
        if ($objEncadrant->getRoleTheseId() == Role_theseTable::DIRECTEUR_THESE) {
          $objEncadrantFinal = IntervenantTable::getInstance()->findOneById($objEncadrant->getIntervenantId());
        }
      } else if ($typeDossier == 'Dossier_postdoc') {
        if ($objEncadrant->getRolePostdocId() == Role_postdocTable::DIRECTEUR_POSTDOC) {
          $objEncadrantFinal = IntervenantTable::getInstance()->findOneById($objEncadrant->getIntervenantId());
        }
      } else if ($typeDossier == 'Dossier_ere') {
        if ($objEncadrant->getRoleEreId() == Role_ereTable::DIRECTEUR_ERE) {
          $objEncadrantFinal = IntervenantTable::getInstance()->findOneById($objEncadrant->getIntervenantId());
        }
      }
    }
    //vérification qu'il y a un directeur pour le dossier
    if ($objEncadrantFinal == null) {
      throw new Exception(libelle("msg_libelle_documentsmris_aucun_directeur"));
    }

    //recherche de l'étudiant
    $objEtudiant = EtudiantTable::getInstance()->findOneById($objDossier->getRealisePar());

    // variables à remplacer - directeur
    $arrVariables["GENRE_DIRECTEUR"] = $objEncadrantFinal->getCivilite()->getIntitule();;
    $arrVariables["ABR_GENRE_PRENOM_NOM_DIRECTEUR"] = $objEncadrantFinal->afficheEncadrantAbrLettre();
    $arrVariables["ORGANISME_DIRECTEUR"] = $objEncadrantFinal->getNomOrganisme();
    if($objEncadrantFinal->getNomLaboratoire() != null){
      $arrVariables["ORGANISME_DIRECTEUR"] = $objEncadrantFinal->getNomOrganisme()."\n". $objEncadrantFinal->getNomLaboratoire();
    }

    //adresses du directeur
    if ($objEncadrantFinal->getAdresse() != null) {
      $arrVariables["ADRESSE_DIRECTEUR"] = $objEncadrantFinal->getAdresse();
      $arrVariables["CODE_POSTAL_DIRECTEUR"] = $objEncadrantFinal->getCodePostal();
      $arrVariables["VILLE_DIRECTEUR"] = $objEncadrantFinal->getVille()->getNom();
      $arrVariables["ADRESSE_DIRECTEUR_COMPLEMENT"] = $objEncadrantFinal->getComplementAdresse();
      $arrVariables["ADRESSE_ETRANGERE_DIRECTEUR_PAYS"] = "";
    }
	if ($objEncadrantFinal->getAdresseEtrangere() != null) {
      $arrVariables["ADRESSE_DIRECTEUR"] = $objEncadrantFinal->getAdresseEtrangere();
      $arrVariables["ADRESSE_ETRANGERE_DIRECTEUR_PAYS"] = $objEncadrantFinal->getPays()->getNom();
      $arrVariables["CODE_POSTAL_DIRECTEUR"] = "";
      $arrVariables["VILLE_DIRECTEUR"] = "";
      $arrVariables["ADRESSE_DIRECTEUR_COMPLEMENT"] = "";
    }

    // variables à remplacer - date
    $arrVariables["ANNEE_EN_COURS"] = date("Y");
    $arrVariables["ANNEE_PROCHAINE"] = date("Y", mktime(0, 0, 0, date('n'), date('j'), date('Y') + 1));
    $arrVariables["DATE_EN_COURS"] = date("d/m/Y");

    // variables à remplacer - Etudiant
    $arrVariables["GENRE_NOM_COMPLET_ETUDIANT"] = $objEtudiant->getCivilite()->getIntitule();
    $arrVariables["GENRE_NOM_PRENOM_ETUDIANT"] = $objEtudiant;

    //variables du dossier
    $arrVariables["NUM_DOSSIER"] = $objDossier->getNumeroAAfficher();
    if ($typeDossier == 'Dossier_these') {
      $arrVariables["TYPE_DOSSIER"] = "thèse";
    } else if ($typeDossier == 'Dossier_postdoc') {
      $arrVariables["TYPE_DOSSIER"] = "stage postdoctoral";
    } else if ($typeDossier == 'Dossier_ere') {
      $arrVariables["TYPE_DOSSIER"] = "stage ERE";
    }

    // prefixe de fichier généré
    $strFichierPrefixe = "validation_listeAttente";

    // modèle utilisé
    $strFichierModele = $objUtilArbo->getRepertoireFichiersStatiques() . $objUtilArbo->getLettreValidationListeAttente();

    // création du fichier
    return $this->creerDocumentModeleStatique($strFichierModele, $strFichierPrefixe, $arrVariables);
  }

   /**
   * Permet de générer un document MRIS dans le répertoire temporaire pour la validation d'un dossier dans le cas de l'acceptation
   * @param integer $intDossierId Id du dossier MRIS
   * @param string $typeDossier Type du dossier MRIS (Dossier_these, Dossier_postdoc, Dossier_ere)
   * @return string
   * @author Alexandre WETTA
   */
  public function creerDocumentValidationAcceptation($intDossierId, $typeDossier) {
     $objUtilArbo = new ServiceArborescence();
     
    if ($typeDossier == 'Dossier_these') {
      $strModelDossier = "Dossier_these";
      $strModelEncadrant = "Encadrant_these";
    } else if ($typeDossier == 'Dossier_postdoc') {
      $strModelDossier = "Dossier_postdoc";
      $strModelEncadrant = "Encadrant_postdoc";
    } else if ($typeDossier == 'Dossier_ere') {
      $strModelDossier = "Dossier_ere";
      $strModelEncadrant = "Encadrant_ere";
    }

    //recherche du dossier
    $objDossier = Doctrine_Core::getTable($strModelDossier)->findOneById($intDossierId);
    if (!$objDossier) {
      throw new Exception(libelle("msg_libelle_documentsmris_aucun_dossier"));
    }

    //recherche du directeur du dossier
    $objEncadrantFinal = null;
    if ($typeDossier == 'Dossier_these') {
      $arrEncadrant = Doctrine_Core::getTable($strModelEncadrant)->findByDossierTheseId($intDossierId);
    } else if ($typeDossier == 'Dossier_postdoc') {
      $arrEncadrant = Doctrine_Core::getTable($strModelEncadrant)->findByDossierPostdocId($intDossierId);
    } else if ($typeDossier == 'Dossier_ere') {
      $arrEncadrant = Doctrine_Core::getTable($strModelEncadrant)->findByDossierEreId($intDossierId);
    }

    foreach ($arrEncadrant as $objEncadrant) {
      if ($typeDossier == 'Dossier_these') {
        if ($objEncadrant->getRoleTheseId() == Role_theseTable::DIRECTEUR_THESE) {
          $objEncadrantFinal = IntervenantTable::getInstance()->findOneById($objEncadrant->getIntervenantId());
        }
      } else if ($typeDossier == 'Dossier_postdoc') {
        if ($objEncadrant->getRolePostdocId() == Role_postdocTable::DIRECTEUR_POSTDOC) {
          $objEncadrantFinal = IntervenantTable::getInstance()->findOneById($objEncadrant->getIntervenantId());
        }
      } else if ($typeDossier == 'Dossier_ere') {
        if ($objEncadrant->getRoleEreId() == Role_ereTable::DIRECTEUR_ERE) {
          $objEncadrantFinal = IntervenantTable::getInstance()->findOneById($objEncadrant->getIntervenantId());
        }
      }
    }
    //vérification qu'il y a un directeur pour le dossier
    if ($objEncadrantFinal == null) {
      throw new Exception(libelle("msg_libelle_validation_doc_aucun_directeur"));
    }

    //recherche de la commission
    $objCommission = CommissionTable::getInstance()->retrieveCommissionSelection($objDossier->getCreatedAt(), strtolower($typeDossier) );
    if($objCommission == null){
       throw new Exception(libelle("msg_libelle_validation_doc_aucune_commission"));
    }

    //recherche de l'étudiant
    $objEtudiant = EtudiantTable::getInstance()->findOneById($objDossier->getRealisePar());

    // variables à remplacer - directeur
    $arrVariables["GENRE_DIRECTEUR"] = $objEncadrantFinal->getCivilite()->getIntitule();;
    $arrVariables["ABR_GENRE_PRENOM_NOM_DIRECTEUR"] = $objEncadrantFinal->afficheEncadrantAbrLettre();
    $arrVariables["ORGANISME_DIRECTEUR"] = $objEncadrantFinal->getNomOrganisme();
    if($objEncadrantFinal->getNomLaboratoire() != null){
      $arrVariables["ORGANISME_DIRECTEUR"] = $objEncadrantFinal->getNomOrganisme()."\n". $objEncadrantFinal->getNomLaboratoire();
    }

    //adresses du directeur
    if ($objEncadrantFinal->getAdresse() != null) {
      $arrVariables["ADRESSE_DIRECTEUR"] = $objEncadrantFinal->getAdresse();
      $arrVariables["CODE_POSTAL_DIRECTEUR"] = $objEncadrantFinal->getCodePostal();
      $arrVariables["VILLE_DIRECTEUR"] = $objEncadrantFinal->getVille()->getNom();
      $arrVariables["ADRESSE_DIRECTEUR_COMPLEMENT"] = $objEncadrantFinal->getComplementAdresse();
      $arrVariables["ADRESSE_ETRANGERE_DIRECTEUR_PAYS"] = "";
    }
	if ($objEncadrantFinal->getAdresseEtrangere() != null) {
      $arrVariables["ADRESSE_DIRECTEUR"] = $objEncadrantFinal->getAdresseEtrangere();
	  $arrVariables["ADRESSE_ETRANGERE_DIRECTEUR_PAYS"] = $objEncadrantFinal->getPays()->getNom();
      $arrVariables["CODE_POSTAL_DIRECTEUR"] = "";
      $arrVariables["VILLE_DIRECTEUR"] = "";
      $arrVariables["ADRESSE_DIRECTEUR_COMPLEMENT"] = "";
    }

    // variables à remplacer - date
    $arrVariables["ANNEE_EN_COURS"] = date("Y");
    $arrVariables["ANNEE_PROCHAINE"] = date("Y", mktime(0, 0, 0, date('n'), date('j'), date('Y') + 1));
    $arrVariables["DATE_EN_COURS"] = date("d/m/Y");

    // variables à remplacer - Etudiant
    $arrVariables["GENRE_NOM_COMPLET_ETUDIANT"] = $objEtudiant->getCivilite()->getIntitule();
    $arrVariables["GENRE_NOM_PRENOM_ETUDIANT"] = $objEtudiant;

    //variables du dossier
    $arrVariables["NUM_DOSSIER"] = $objDossier->getNumeroAAfficher();
    if ($typeDossier == 'Dossier_these') {
      $arrVariables["TYPE_DOSSIER"] = "thèse";
      $arrVariables["TYPE_DOSSIER_PLR"] = "thèses";
      $arrVariables["TYPE_DOSSIER_AVEC_DETER"] = "une thèse";
      $arrVariables["FINANCE"] = "financée";
      $arrVariables["TYPE_DIRECTEUR"] = "directeur de thèse";
    } else if ($typeDossier == 'Dossier_postdoc') {
      $arrVariables["TYPE_DOSSIER"] = "stage postdoctoral";
      $arrVariables["TYPE_DOSSIER_PLR"] = "stages postdoctoraux";
      $arrVariables["TYPE_DOSSIER_AVEC_DETER"] = "un stage postdoctoral";
      $arrVariables["FINANCE"] = "financé";
      $arrVariables["TYPE_DIRECTEUR"] = "directeur de stage postdoctoral";
    } else if ($typeDossier == 'Dossier_ere') {
      $arrVariables["TYPE_DOSSIER"] = "stage ERE";
      $arrVariables["TYPE_DOSSIER_PLR"] = "stages ERE";
      $arrVariables["TYPE_DOSSIER_AVEC_DETER"] = "un stage ere";
      $arrVariables["FINANCE"] = "financé";
      $arrVariables["TYPE_DIRECTEUR"] = "directeur de stage ERE";
    }

    //variables de la commission
    $arrVariables["DATE_COMMISSION"] = $objCommission->getDateTimeObject('date_debut')->format('d/m/Y');

    // prefixe de fichier généré
    $strFichierPrefixe = "validation_acceptation";

    // modèle utilisé
    if($objDossier->getMisEnAttenteLe()!= null){
      $strFichierModele = $objUtilArbo->getRepertoireFichiersStatiques() . $objUtilArbo->getLettreValidationAcceptationApresAttente();
    }else{
      $strFichierModele = $objUtilArbo->getRepertoireFichiersStatiques() . $objUtilArbo->getLettreValidationAcceptationDirecte();
    }

    // création du fichier
    return $this->creerDocumentModeleStatique($strFichierModele, $strFichierPrefixe, $arrVariables);
  }

    /**
   * Permet de générer un document MRIS dans le répertoire temporaire pour la validation d'un dossier dans le cas de l'attestation
   * @param integer $intDossierId Id du dossier MRIS
   * @param string $typeDossier Type du dossier MRIS (Dossier_these, Dossier_postdoc, Dossier_ere)
   * @return string
   * @author Alexandre WETTA
   */
  public function creerDocumentValidationAttestation($intDossierId, $typeDossier) {
    $objUtilArbo = new ServiceArborescence();

    if ($typeDossier == 'Dossier_these') {
      $strModelDossier = "Dossier_these";
      $strModelEncadrant = "Encadrant_these";
    } else if ($typeDossier == 'Dossier_postdoc') {
      $strModelDossier = "Dossier_postdoc";
      $strModelEncadrant = "Encadrant_postdoc";
    } else if ($typeDossier == 'Dossier_ere') {
      $strModelDossier = "Dossier_ere";
      $strModelEncadrant = "Encadrant_ere";
    }

    //recherche du dossier
    $objDossier = Doctrine_Core::getTable($strModelDossier)->findOneById($intDossierId);
    if (!$objDossier) {
      throw new Exception(libelle("msg_libelle_documentsmris_aucun_dossier"));
    }

    //recherche de l'étudiant
    $objEtudiant = EtudiantTable::getInstance()->findOneById($objDossier->getRealisePar());

    //variables à remplacer - Etudiant
    if($objEtudiant->getCiviliteId() == CiviliteTable::M){
      $arrVariables["SOUSSIGNE"] = "soussigné";
    }else{
      $arrVariables["SOUSSIGNE"] = "soussignée";
    }

    $arrVariables["NOM_PRENOM_ETUDIANT"] = $objEtudiant->getPrenom()." ".$objEtudiant->getNom();

    //Dates
    $arrVariables["ANNEE_EN_COURS"] = date("Y");

    //variables sur le dossier
    if ($typeDossier == 'Dossier_these') {
      $arrVariables["TYPE_DOSSIER"] = "thèse";
      $arrVariables["TYPE_DOSSIER_PLR"] = "thèses";
      $arrVariables["TYPE_DOSSIER_MAJ"] = "THESE";
      $arrVariables["TYPE_DOSSIER_PLR_MAJ"] = "THESES";
      $arrVariables["TYPE_DOSSIER_AVEC_DETER"] = "la thèse";
      $arrVariables["REALISE"] = "réalisée";
    } else if ($typeDossier == 'Dossier_postdoc') {
      $arrVariables["TYPE_DOSSIER"] = "stage postdoctoral";
      $arrVariables["TYPE_DOSSIER_PLR"] = "stages postdoctoraux";
      $arrVariables["TYPE_DOSSIER_MAJ"] = "STAGE POSTDOCTORAL";
      $arrVariables["TYPE_DOSSIER_PLR_MAJ"] = "STAGES POSTDOCTORAUX";
      $arrVariables["TYPE_DOSSIER_AVEC_DETER"] = "le stage postdoctoral";
      $arrVariables["REALISE"] = "réalisé";
    } else if ($typeDossier == 'Dossier_ere') {
      $arrVariables["TYPE_DOSSIER"] = "stage ERE";
      $arrVariables["TYPE_DOSSIER_PLR"] = "stages ERE";
      $arrVariables["TYPE_DOSSIER_MAJ"] = "STAGE ERE";
      $arrVariables["TYPE_DOSSIER_PLR_MAJ"] = "STAGES ERE";
      $arrVariables["TYPE_DOSSIER_AVEC_DETER"] = "le stage ERE";
      $arrVariables["REALISE"] = "réalisé";
    }

    // prefixe de fichier généré
    $strFichierPrefixe = "validation_attestation";

    // modèle utilisé
    $strFichierModele = $objUtilArbo->getRepertoireFichiersStatiques() . $objUtilArbo->getLettreValidationAttestation();

    // création du fichier
    return $this->creerDocumentModeleStatique($strFichierModele, $strFichierPrefixe, $arrVariables);
  }
}
