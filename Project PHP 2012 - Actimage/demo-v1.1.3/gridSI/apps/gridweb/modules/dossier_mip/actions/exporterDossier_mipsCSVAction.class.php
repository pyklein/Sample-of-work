<?php

sfContext::getInstance()->getConfiguration()->loadHelpers("Format");

/**
 * Action d'export CSV
 * @author Gabor JAGER
 */
class exporterDossier_mipsCSVAction extends gridAction
{
  /**
   * @var sfLogger
   */
  var $logger;

  public function preExecute()
  {
    $this->logger = sfContext::getInstance()->getLogger();
  }
  
  public function execute($request)
  {
    $this->logger->debug("{".__CLASS__."} ".__FUNCTION__."");

    $strNomFichier = "export_dossiers_mips_".date("YmdHis").".csv";

    $this->objFormFiltre = new Dossier_mipFormFilter(true,null,array('dossier_vivant' => 'on'));
    $this->credentials = $this->getUser()->getAttribute('credentials');
    
    if ($this->getUser()->hasAttributeAction('filtre_dossier_mips', "dossier_mip/listerDossier_mips"))
    {
      $this->logger->debug("Avec le filtre");

      $this->getUser()->setAttributeAction('filtre_dossier_mips', $this->getUser()->getAttributeAction('filtre_dossier_mips', null, "dossier_mip/listerDossier_mips"));
    }
    else
    {
      $this->logger->debug("Sans filtre");
    }

    $objRequeteDoctrine = $this->processFiltre();
    $objRequeteDoctrine = Dossier_mipTable::getInstance()->getRequeteListeParUtilisateur($objRequeteDoctrine,$this->getUser());

    $arrResultatsDossiers = $objRequeteDoctrine->execute();

    // creation du fichier + téléchargement
    $this->creerFichier($strNomFichier, $arrResultatsDossiers);

    // on ne devrait jamais y arriver
    $this->logger->error("{".__CLASS__."} ".__FUNCTION__." - strNomFichier: ".$strNomFichier);
  }

  /**
   * Créer le fichier CSV
   * @param string $strNomFichier
   * @param Dossier_mip[] $arrResultatsDossiers
   * @author Gabor JAGER
   */
  private function creerFichier($strNomFichier, $arrResultatsDossiers=array())
  {
    $this->logger->debug("{".__CLASS__."} ".__FUNCTION__." - strNomFichier: ".$strNomFichier);

    $objUtilCsv = new UtilCsv($strNomFichier);
    $objUtilString = new UtilString();

    // en tete
    //description
    $objUtilCsv->ajouterValeur(libelle("msg_libelle_numero"));
    $objUtilCsv->ajouterValeur(libelle("msg_libelle_intitule"));
    $objUtilCsv->ajouterValeur(libelle("msg_libelle_acronyme"));
    $objUtilCsv->ajouterValeur(libelle("msg_libelle_descriptif"));
    $objUtilCsv->ajouterValeur(libelle("msg_libelle_pilote"));
    $objUtilCsv->ajouterValeur(libelle("msg_libelle_date_creation"));
    $objUtilCsv->ajouterValeur(libelle("msg_libelle_statut_dossier"));
    $objUtilCsv->ajouterValeur(libelle("msg_libelle_organisme_armee"));
    $objUtilCsv->ajouterValeur(libelle("msg_libelle_classification"));
    $objUtilCsv->ajouterValeur(libelle("msg_libelle_statut_systeme"));
    $objUtilCsv->ajouterValeur(libelle("msg_libelle_etat_partage"));
    $objUtilCsv->ajouterValeur(libelle("msg_libelle_est_publie"));
    
    //calendrier
    //rendez-vous
    $objUtilCsv->ajouterValeur(libelle("msg_gestion_calendrier_innovateur_prise_rdv"));
    $objUtilCsv->ajouterValeur(libelle("msg_gestion_calendrier_innovateur_date_rdv_date"));

    //echeances
    $strEnteteEcheance = libelle("msg_dossier_mip_fieldset_echeance");
    $objUtilCsv->ajouterValeur($strEnteteEcheance." - ".libelle("msg_gestion_calendrier_echeance_ea"));
    $objUtilCsv->ajouterValeur($strEnteteEcheance." - ".libelle("msg_gestion_calendrier_echeance_cr"));

    //avis d'état major
    $strEnteteEm = libelle("msg_gestion_calendrier_creeravisetatmajor");
    $objUtilCsv->ajouterValeur($strEnteteEm." - ".libelle("msg_gestion_calendrier_avis_em_date_demande"));
    $objUtilCsv->ajouterValeur($strEnteteEm." - ".libelle("msg_gestion_calendrier_avis_em_ref_demande"));
    $objUtilCsv->ajouterValeur($strEnteteEm." - ".libelle("msg_gestion_calendrier_avis_em_date_reception_avis"));
    $objUtilCsv->ajouterValeur($strEnteteEm." - ".libelle("msg_gestion_calendrier_avis_em_date_envoi_avis"));
    $objUtilCsv->ajouterValeur($strEnteteEm." - ".libelle("msg_gestion_calendrier_avis_em_ref_avis"));
    $objUtilCsv->ajouterValeur($strEnteteEm." - ".libelle("msg_gestion_calendrier_avis_em_est_favorable"));
    $objUtilCsv->ajouterValeur($strEnteteEm." - ".libelle("msg_libelle_recommandation"));

    //Remise des documents
    //etat d'avancement
    $strEnteteEa = libelle("msg_gestion_calendrier_creerremisedocuments")." - ".libelle("msg_gestion_calendrier_creerremisedocuments_ea");
    $objUtilCsv->ajouterValeur($strEnteteEa." - ".libelle("msg_gestion_calendrier_remise_docs_date_reception"));
    $objUtilCsv->ajouterValeur($strEnteteEa." - ".libelle("msg_gestion_calendrier_remise_docs_mode_transmission"));
    $objUtilCsv->ajouterValeur($strEnteteEa." - ".libelle("msg_gestion_calendrier_remise_docs_reference"));
    $objUtilCsv->ajouterValeur($strEnteteEa." - ".libelle("msg_gestion_calendrier_remise_docs_date_envoi_ar"));
    $objUtilCsv->ajouterValeur($strEnteteEa." - ".libelle("msg_gestion_calendrier_remise_docs_reference_ar"));

    //compte_rendu
    $strEnteteCr = libelle("msg_gestion_calendrier_creerremisedocuments")." - ".libelle("msg_gestion_calendrier_creerremisedocuments_cr");
    $objUtilCsv->ajouterValeur($strEnteteCr." - ".libelle("msg_gestion_calendrier_remise_docs_date_reception"));
    $objUtilCsv->ajouterValeur($strEnteteCr." - ".libelle("msg_gestion_calendrier_remise_docs_mode_transmission"));
    $objUtilCsv->ajouterValeur($strEnteteCr." - ".libelle("msg_gestion_calendrier_remise_docs_reference"));
    $objUtilCsv->ajouterValeur($strEnteteCr." - ".libelle("msg_gestion_calendrier_remise_docs_date_envoi_ar"));
    $objUtilCsv->ajouterValeur($strEnteteCr." - ".libelle("msg_gestion_calendrier_remise_docs_reference_ar"));

    //video
    $strEnteteVideo = libelle("msg_gestion_calendrier_creerremisedocuments")." - ".libelle("msg_gestion_calendrier_creerremisedocuments_video");
    $objUtilCsv->ajouterValeur($strEnteteVideo." - ".libelle("msg_gestion_calendrier_remise_docs_date_reception"));
    $objUtilCsv->ajouterValeur($strEnteteVideo." - ".libelle("msg_gestion_calendrier_remise_docs_mode_transmission"));
    $objUtilCsv->ajouterValeur($strEnteteVideo." - ".libelle("msg_gestion_calendrier_remise_docs_reference"));
    $objUtilCsv->ajouterValeur($strEnteteVideo." - ".libelle("msg_gestion_calendrier_remise_docs_date_envoi_ar"));
    $objUtilCsv->ajouterValeur($strEnteteVideo." - ".libelle("msg_gestion_calendrier_remise_docs_reference_ar"));

    //décision de soutien
    $strEnteteSoutien = libelle("msg_gestion_calendrier_creersoutien");
    $objUtilCsv->ajouterValeur($strEnteteSoutien." - ".libelle("msg_gestion_calendrier_soutien_date_emission"));
    $objUtilCsv->ajouterValeur($strEnteteSoutien." - ".libelle("msg_gestion_calendrier_soutien_reference"));

    //Transfert/Cloture
    $strEnteteTransfert = libelle("msg_gestion_calendrier_creertransfertcloture");
    $objUtilCsv->ajouterValeur($strEnteteTransfert." - ".libelle("msg_gestion_calendrier_transfert_date_transfert"));
    $objUtilCsv->ajouterValeur($strEnteteTransfert." - ".libelle("msg_gestion_calendrier_transfert_ref_transfert"));
    $objUtilCsv->ajouterValeur($strEnteteTransfert." - ".libelle("msg_gestion_calendrier_transfert_dest_autre"));
    $objUtilCsv->ajouterValeur($strEnteteTransfert." - ".libelle("msg_gestion_calendrier_transfert_date_cloture"));
    $objUtilCsv->ajouterValeur($strEnteteTransfert." - ".libelle("msg_gestion_calendrier_transfert_ref_cloture"));

    //Valorisation
    //Généralisation
    $strEnteteGeneralisation = libelle("msg_valorisation_generalisation");
    $objUtilCsv->ajouterValeur($strEnteteGeneralisation." - ".libelle("msg_valorisation_libelle_date_demande"));
    $objUtilCsv->ajouterValeur($strEnteteGeneralisation." - ".libelle("msg_valorisation_libelle_destinataire"));

    $objUtilCsv->ajouterValeur(libelle("msg_libelle_avantages_inconvenients"));
    $objUtilCsv->ajouterValeur(libelle("msg_valorisation_retour_experience"));
    $objUtilCsv->ajouterValeur(libelle("msg_valorisation_fiche_internet"));
    $objUtilCsv->ajouterValeur(libelle("msg_valorisation_prix_recompense"));
    $objUtilCsv->ajouterValeur(libelle("msg_valorisation_dossier_bpi_libelle_brevet"));

    //Suivi Financier
    $strEnteteTotal = libelle("msg_libelle_total");
    $objUtilCsv->ajouterValeur($strEnteteTotal." ".libelle("msg_libelle_budgets")." (en euros)");
    $objUtilCsv->ajouterValeur($strEnteteTotal." ".libelle("msg_libelle_financements")." (en euros)");
    $objUtilCsv->ajouterValeur($strEnteteTotal." ".libelle("msg_libelle_engagement")." (en euros)");
    $objUtilCsv->ajouterValeur($strEnteteTotal." ".libelle("msg_libelle_paiements")." (en euros)");
    
    
    for ($i = 1; $i <= 6 ; $i++){
    $objUtilCsv->ajouterValeur(libelle("msg_libelle_innovateur")." ". $i);
    }
    
    $objUtilCsv->ajouterLigne();
    // contenu
    foreach ($arrResultatsDossiers as $objDossier)
    {
      $objUtilCsv->ajouterValeur($objDossier->getNumero());
      $objUtilCsv->ajouterValeur($objDossier->getTitre());
      $objUtilCsv->ajouterValeur($objDossier->getAcronyme());
      $objUtilCsv->ajouterValeur('"'.str_replace("\r", "", $objDossier->getDescriptif()).'"');
      $objUtilCsv->ajouterValeur($objDossier->getPilote());
      $objUtilCsv->ajouterValeur(formatDate($objDossier->getCreatedAt()));
      $objUtilCsv->ajouterValeur($objDossier['Statut_dossier_mip']);
      $objUtilCsv->ajouterValeur($objDossier['Organisme_mindef']);
      $objUtilCsv->ajouterValeur($objDossier['Niveau_protection']);
      $objUtilCsv->ajouterValeur($objDossier->getEstActif() ? libelle("msg_libelle_actif") : libelle("msg_libelle_inactif"));
      $objUtilCsv->ajouterValeur($objDossier->getEtat_partage());
      $objUtilCsv->ajouterValeur($objDossier->getEst_publie() ? libelle("msg_libelle_publie") : libelle("msg_libelle_non_publie"));
      
      //calendrier
      //date de prise de rdv
      $date_prise_rdv = "";
      if($objDossier->getRendez_vous()->getDate_prise_rdv() != NULL )
      {
        $date_prise_rdv = formatDate($objDossier->getRendez_vous()->getDate_prise_rdv());
      }
      $objUtilCsv->ajouterValeur($date_prise_rdv);

      //date rdv
      $date_rdv = "";
      if($objDossier->getRendez_vous()->getDate_rdv() != NULL)
      {
        $date_rdv = formatDate($objDossier->getRendez_vous()->getDate_rdv())." à ".formatHeure($objDossier->getRendez_vous()->getDate_rdv());
      }
      $objUtilCsv->ajouterValeur($date_rdv);

      //echeance
      $echeance_ea = "";
      if($objDossier->getEcheance()->getDate_echeance_ea() != NULL)
      {
        $echeance_ea = formatDate($objDossier->getEcheance()->getDate_echeance_ea());
      }
      $objUtilCsv->ajouterValeur($echeance_ea);

      $echeance_cr = "";
      if($objDossier->getEcheance()->getDate_echeance_cr() != NULL)
      {
        $echeance_cr = formatDate($objDossier->getEcheance()->getDate_echeance_cr());
      }
      $objUtilCsv->ajouterValeur($echeance_cr);

      //avis d'état major
      $date_avis = "";
      if($objDossier->getAvis_etatmajor()->getDate_demande() != NULL)
      {
        $date_avis = formatDate($objDossier->getAvis_etatmajor()->getDate_demande());
      }
      $objUtilCsv->ajouterValeur($date_avis);

      $objUtilCsv->ajouterValeur($objDossier->getAvis_etatmajor()->getReference_demande());

      $date_reception_avis = "";
      if($objDossier->getAvis_etatmajor()->getDate_reception() != NULL)
      {
        $date_reception_avis = formatDate($objDossier->getAvis_etatmajor()->getDate_reception());
      }
      $objUtilCsv->ajouterValeur($date_reception_avis);

      $date_envoi_avis = "";
      if($objDossier->getAvis_etatmajor()->getDate_envoi() != NULL)
      {
        $date_envoi_avis = formatDate($objDossier->getAvis_etatmajor()->getDate_envoi());
      }
      $objUtilCsv->ajouterValeur($date_envoi_avis);

      $objUtilCsv->ajouterValeur($objDossier->getAvis_etatmajor()->getReference());
      $objUtilCsv->ajouterValeur($objDossier->getAvis_etatmajor()->getEst_favorable() ? libelle("msg_gestion_calendrier_avis_em_favorable") : libelle("msg_gestion_calendrier_avis_em_defavorable") );

      $strRecommandations = $objDossier->getAvis_etatmajor()->getRecommandation();
      
      $strRecommandations = $objUtilString->filtrer_balises_pour_csv($strRecommandations);
      $objUtilCsv->ajouterValeur("\"".$strRecommandations."\"");

      //remise des documents
      //état d'avancement
      $date_reception_ea = "";
      if($objDossier->getRemise_documents()->getDate_reception_ea()!= NULL)
      {
        $date_reception_ea = formatDate($objDossier->getRemise_documents()->getDate_reception_ea());
      }
      $objUtilCsv->ajouterValeur($date_reception_ea);

      $objModeTransmissionEa = " ";
      $intModeTransmissionEaId = $objDossier->getRemise_documents()->getModeTransmissionEa();
      if($intModeTransmissionEaId)
      {
        $objModeTransmissionEa = Mode_transmissionTable::getInstance()->findOneById($intModeTransmissionEaId);
      }
      $objUtilCsv->ajouterValeur($objModeTransmissionEa);

      $objUtilCsv->ajouterValeur($objDossier->getRemise_documents()->getReference_ea());

      $date_envoi_ar_ea = "";
      if($objDossier->getRemise_documents()->getDate_envoi_ar_ea()!= NULL)
      {
        $date_envoi_ar_ea = formatDate($objDossier->getRemise_documents()->getDate_envoi_ar_ea());
      }
      $objUtilCsv->ajouterValeur($date_envoi_ar_ea);

      $objUtilCsv->ajouterValeur($objDossier->getRemise_documents()->getReference_ar_ea());

      //Compte-rendu
      $date_reception_cr = "";
      if($objDossier->getRemise_documents()->getDate_reception_cr()!= NULL)
      {
        $date_reception_cr = formatDate($objDossier->getRemise_documents()->getDate_reception_cr());
      }
      $objUtilCsv->ajouterValeur($date_reception_cr);

      $objModeTransmissionCr = " ";
      $intModeTransmissionCrId = $objDossier->getRemise_documents()->getModeTransmissionCr();
      if($intModeTransmissionCrId)
      {
        $objModeTransmissionCr = Mode_transmissionTable::getInstance()->findOneById($intModeTransmissionCrId);
      }
      $objUtilCsv->ajouterValeur($objModeTransmissionCr);

      $objUtilCsv->ajouterValeur($objDossier->getRemise_documents()->getReference_cr());

      $date_envoi_ar_cr = "";
      if($objDossier->getRemise_documents()->getDate_envoi_ar_cr()!= NULL)
      {
        $date_envoi_ar_cr = formatDate($objDossier->getRemise_documents()->getDate_envoi_ar_cr());
      }
      $objUtilCsv->ajouterValeur($date_envoi_ar_cr);

      $objUtilCsv->ajouterValeur($objDossier->getRemise_documents()->getReference_ar_cr());

      //Video
      $date_reception_video = "";
      if($objDossier->getRemise_documents()->getDate_reception_video()!= NULL)
      {
        $date_reception_video = formatDate($objDossier->getRemise_documents()->getDate_reception_video());
      }
      $objUtilCsv->ajouterValeur($date_reception_video);

      $objModeTransmissionVideo = " ";
      $intModeTransmissionVideoId = $objDossier->getRemise_documents()->getMode_transmission_video();
      if($intModeTransmissionVideoId)
      {
        $objModeTransmissionVideo = Mode_transmissionTable::getInstance()->findOneById($intModeTransmissionVideoId);
      }
      $objUtilCsv->ajouterValeur($objModeTransmissionVideo);

      $objUtilCsv->ajouterValeur($objDossier->getRemise_documents()->getReference_video());

      $date_envoi_ar_video = "";
      if($objDossier->getRemise_documents()->getDate_envoi_ar_video()!= NULL)
      {
        $date_envoi_ar_video = formatDate($objDossier->getRemise_documents()->getDate_envoi_ar_video());
      }
      $objUtilCsv->ajouterValeur($date_envoi_ar_video);

      $objUtilCsv->ajouterValeur($objDossier->getRemise_documents()->getReference_ar_video());

      //Décision de soutien
      $date_emission_soutien = "";
      if($objDossier->getSoutien()->getDate_emission()!= NULL)
      {
        $date_emission_soutien = formatDate($objDossier->getSoutien()->getDate_emission());
      }
      $objUtilCsv->ajouterValeur($date_emission_soutien);

      $objUtilCsv->ajouterValeur($objDossier->getSoutien()->getReference());

      //Transfert / Clôture
      $date_transfert = "";
      if($objDossier->getTransfert_cloture()->getDate_transfert() != NULL)
      {
        $date_transfert = formatDate($objDossier->getTransfert_cloture()->getDate_transfert());
      }
      $objUtilCsv->ajouterValeur($date_transfert);

      $objUtilCsv->ajouterValeur($objDossier->getTransfert_cloture()->getReference_transfert());
      $objUtilCsv->ajouterValeur($objDossier->getTransfert_cloture()->getDestination_autre());

      $date_cloture = "";
      if($objDossier->getTransfert_cloture()->getDate_cloture() != NULL)
      {
        $date_cloture = formatDate($objDossier->getTransfert_cloture()->getDate_cloture());
      }
      $objUtilCsv->ajouterValeur($date_cloture);

      $objUtilCsv->ajouterValeur($objDossier->getTransfert_cloture()->getReference_cloture());

      //Valorisation
      //Généralisation
      $date_demande_gene = "";
      if($objDossier->getValorisation()->getDate_demande_generalisation() != NULL)
      {
        $date_demande_gene = formatDate($objDossier->getValorisation()->getDate_demande_generalisation());
      }
      $objUtilCsv->ajouterValeur($date_demande_gene);

      $objUtilCsv->ajouterValeur($objDossier->getValorisation()->getDestinataire_demande_generalisation());

      $strAvantage_inconvenient = $objDossier->getValorisation()->getAvantage_inconvenient();
      $strAvantage_inconvenient = $objUtilString->filtrer_balises_pour_csv($strAvantage_inconvenient);
      $objUtilCsv->ajouterValeur("\"".$strAvantage_inconvenient."\"");
      // var_dump( $strAvantage_inconvenient);
//      die();
      
      $strRetourExp = $objDossier->getValorisation()->getRetour_experience();
      $strRetourExp = $objUtilString->filtrer_balises_pour_csv($strRetourExp);
      $objUtilCsv->ajouterValeur("\"".$strRetourExp."\"");

      $objUtilCsv->ajouterValeur($objDossier->getValorisation()->getFiche_internet());

      //Prix
      $strPrix = "";
      $arrPrixDossier = Prix_dossier_mipTable::getInstance()->retrievePrixByDossierId($objDossier->getId());
      if($arrPrixDossier->count() > 0)
      {
        foreach($arrPrixDossier as $objPrixDossier)
        {
          if($objPrixDossier->getEst_selectionne())
          {
            $strPrix .= ($strPrix == "" ? "" : ", ").$objPrixDossier->getAnnee()." - ".$objPrixDossier->getPrix()." - ".libelle("msg_valorisation_prix_libelle_selectionne");
          }
          if($objPrixDossier->getEst_obtenu())
          {
            $strPrix .= ($strPrix == "" ? "" : ", ").$objPrixDossier->getAnnee()." - ".$objPrixDossier->getPrix()." - ".libelle("msg_valorisation_prix_libelle_obtenu");
          }
        }
      }
      $objUtilCsv->ajouterValeur($strPrix);

      //Brevet (Dossier BPI)
      $strBrevet = "";
      $arrBrevetDossier = Dossier_mip_dossier_bpiTable::getInstance()->retrieveDossiersBPIByDossiersMIP($objDossier->getId())->execute();
      if($arrBrevetDossier->count() > 0)
      {
        foreach($arrBrevetDossier as $objBrevetDossier)
        {
          $objDossierBpi = $objBrevetDossier->getDossier_bpi();
          $strBrevet .= ($strBrevet == "" ? "" : ", ").$objDossierBpi->getNumero()." - ".$objDossierBpi;
        }
      }
      $objUtilCsv->ajouterValeur($strBrevet);

      //Suivi financier
      //Budget
      $floatBudget = $objDossier->getBudgetTotalGlobal();
      $objUtilCsv->ajouterValeur(formatNombreFr($floatBudget));

      //Financement
      $arrFinancementParAnnee = $objDossier->getFinancementsGlobauxParAnnees();
      $floatFinancement = end($arrFinancementParAnnee);
      $objUtilCsv->ajouterValeur(formatNombreFr($floatFinancement));

      //Engagement
      $arrEngagementParAnnee = $objDossier->getEngagementsGlobauxParAnnees();
      $floatEngagementTotal = end($arrEngagementParAnnee);
      $objUtilCsv->ajouterValeur(formatNombreFr($floatEngagementTotal));

      //Paiement
      $arrPaiementParAnnee = $objDossier->getPaiementsGlobauxParAnnees();
      $floatPaiementTotal = end($arrPaiementParAnnee);
      $objUtilCsv->ajouterValeur(formatNombreFr($floatPaiementTotal));
      
      $i = 0;
      foreach ($objDossier->getInnovateurs() as $objInnovateur)
      {
        if ($i < 6){          
            $objUtilCsv->ajouterValeur($objInnovateur);
            $i++;          
        }
      }
      
      while ($i < 6){
        $objUtilCsv->ajouterValeur("");
        $i++;
      }     
      $objUtilCsv->ajouterLigne();
    }

    $this->logger->debug("{".__CLASS__."} ".__FUNCTION__." - telecharger");

    // on télécharge le fichier
    $objUtilCsv->telechargerFichier();

  }
}
