<?php


/**
 * Classe représentant la tache symfony d'envoi des mails stoqués en base.
 * Projet : GRID
 * Module : N.A
 * Date de création : 28/02/2011
 * Auteur : William Richards
 *
 */
class CreationMailsDeRelanceGridTask extends GridTask {

  /**
   * Configuration de la tâche: lancer avec :  php symfony grid:relances_mip --application=gridweb
   * @param   Console   application   spécifie l'application dont la configuration doit être chargée
   * @param   Console   env           spécifie l'environnement dont la configuration doit être chargée
   */
  protected function configure() {

    $this->app              = 'gridweb';
    $this->namespace        = 'grid';
    $this->name             = 'relances_mip';
    $this->briefDescription = 'Creation des mails de relance MIP';

    parent::configure();
  }

  protected function execute($arguments = array(), $options = array()) {

    // init d'execution
    $this->debut($arguments, $options);

    //Envoi la relance des relances N jours avant la date d'echeance
    $this->faitRelanceAvantDateEtatAvancement();

    //Envoi la relance des relance N jours apres la date d'echeance
    $this->faitRelanceApresDateEtatAvancement();

    //Envoi la relance des relance N jours avant la date d'echeance
    $this->faitRelanceAvantDateCompteRendu();

    //Envoi la relance des relance N jours apres la date d'echeance
    $this->faitRelanceApresDateCompteRendu();

    //Envoi la relance des relance N jours apres la demande avis etat majeur,
    // mais sans avis recu
    $this->faitRelanceApresEnvoieEtatMajeur();

    //Envoi la relance des relance N jours apres la reception d'un avis favorable,
    // mais avec lettre de soutien manquant
    $this->faitRelanceApresRecuAvisFavorable();

    // fin d'execution
    $this->fin(false, libelle("msg_tache_sans_erreur"));
  }

  /**
   * Effectu la recherche des dossier MIP nessessitant unt relance d'etat d'avancement
   *
   * @author Simeon PETEV
   */
  private function faitRelanceAvantDateEtatAvancement()
  {
    $this->logSection("faitRelanceAvantDateEtatAvancement() -> Start");

    $intJoursAvantEtatAvancement    = sfConfig::get("app_relances_mip_avant_date_limite_etat_avancement");

    $arrDossiers = Dossier_mipTable::getInstance()->retreveDossiersPourRelanceSurEtatAvancementAvant($intJoursAvantEtatAvancement);

    $this->envoiMailEtSaveRelance(Type_relance_dossier_mipTable::getInstance()->findOneById(Type_relance_dossier_mipTable::AVANT_ETAT_AVANCEMENT),
                                  $arrDossiers
                                  )
    ;

    $this->logSection("faitRelanceAvantDateEtatAvancement() -> Fin");
  }

  /**
   * Effectu la recherche des dossier MIP nessessitant unt relance d'etat d'avancement
   *
   * @author Simeon PETEV
   */
  private function faitRelanceApresDateEtatAvancement()
  {
    $this->logSection("faitRelanceApresDateEtatAvancement() -> Start");

    $intJoursApresEtatAvancement    = sfConfig::get("app_relances_mip_apres_date_limite_etat_avancement");

    $arrDossiers = Dossier_mipTable::getInstance()->retreveDossiersPourRelanceSurEtatAvancementApres($intJoursApresEtatAvancement);

    $this->envoiMailEtSaveRelance(Type_relance_dossier_mipTable::getInstance()->findOneById(Type_relance_dossier_mipTable::APRES_ETAT_AVANCEMENT),
                                  $arrDossiers
                                  )
    ;

    $this->logSection("faitRelanceApresDateEtatAvancement() -> Fin");
  }

  /**
   * Effectu la recherche des dossier MIP nessessitant une relance de compt rendu
   *
   * @author Simeon PETEV
   */
  private function faitRelanceAvantDateCompteRendu()
  {
    $this->logSection("faitRelanceAvantDateCompteRendu() -> Start");

    $intJoursAvantCompteRendu       = sfConfig::get("app_relances_mip_avant_date_limite_compte_rendu");

    $arrDossiers = Dossier_mipTable::getInstance()->retreveDossiersPourRelanceSurCompteRenduAvant($intJoursAvantCompteRendu);

    $this->envoiMailEtSaveRelance(Type_relance_dossier_mipTable::getInstance()->findOneById(Type_relance_dossier_mipTable::AVANT_COMPT_RENDU),
                                  $arrDossiers
                                  )
    ;

    $this->logSection("faitRelanceAvantDateCompteRendu() -> Fin");
  }

  /**
   * Effectu la recherche des dossier MIP nessessitant une relance de compt rendu
   *
   * @author Simeon PETEV
   */
  private function faitRelanceApresDateCompteRendu()
  {
    $this->logSection("faitRelanceApresDateCompteRendu() -> Start");

    $intJoursApresCompteRendu       = sfConfig::get("app_relances_mip_apres_date_limite_compte_rendu");

    $arrDossiers = Dossier_mipTable::getInstance()->retreveDossiersPourRelanceSurCompteRenduApres($intJoursApresCompteRendu);

    $this->envoiMailEtSaveRelance(Type_relance_dossier_mipTable::getInstance()->findOneById(Type_relance_dossier_mipTable::APRES_COMPT_RENDU),
                                  $arrDossiers
                                  )
    ;

    $this->logSection("faitRelanceApresDateCompteRendu() -> Fin");
  }

  /**
   * Effectu la recherche des dossier MIP nessessitant une relance d'avis d'etat
   *  major manquant
   *
   * @author Simeon PETEV
   */
  private function faitRelanceApresEnvoieEtatMajeur()
  {
    $this->logSection("faitRelanceApresEnvoieEtatMajeur() -> Start");

    $intJoursApresEnvoieEtatMajeur  = sfConfig::get("app_relances_mip_apres_date_envoie_etat_majeur");

    $arrDossiers = Dossier_mipTable::getInstance()->retreveDossiersPourRelanceApresEnvoieEtatMajeur($intJoursApresEnvoieEtatMajeur);

    $this->envoiMailEtSaveRelance(Type_relance_dossier_mipTable::getInstance()->findOneById(Type_relance_dossier_mipTable::APRES_ENVOI_ETAT_MAJEUR),
                                  $arrDossiers
                                  )
    ;

    $this->logSection("faitRelanceApresEnvoieEtatMajeur() -> Fin");
  }

  /**
   * Effectu la recherche des dossier MIP nessessitant une relance de lettre de
   * soutien manquant
   *
   * @author Simeon PETEV
   */
  private function faitRelanceApresRecuAvisFavorable()
  {
    $this->logSection("faitRelanceApresRecuAvisFavorable() -> Start");

    $intJoursApresRecuAvisFavorable = sfConfig::get("app_relances_mip_apres_date_recu_avis_favorable");

    $arrDossiers = Dossier_mipTable::getInstance()->retreveDossiersPourRelanceApresRecuAvisFavorable($intJoursApresRecuAvisFavorable);

    $this->envoiMailEtSaveRelance(Type_relance_dossier_mipTable::getInstance()->findOneById(Type_relance_dossier_mipTable::APRES_RECU_AVIS_FAVORABLE),
                                  $arrDossiers
                                  )
    ;

    $this->logSection("faitRelanceApresRecuAvisFavorable() -> Fin");
  }

  /**
   * Envoie les mails au pilotes des dossier concernés par un type de relance
   *
   * @param object $objTypeRelance Type_relance_dossier_mip
   * @param array $arrDossiers Array de dossiers MIP concernés
   *
   * @author Simeon PETEV
   */
  private function envoiMailEtSaveRelance($objTypeRelance,$arrDossiers)
  {
    $this->logSection("envoiMailEtSaveRelance() -> Start");
    
    //Nom du fichier partial (sans le underscore) contenant le template
    $strNomPartial="";

    //Remplir le nom du partial
    switch ($objTypeRelance->getId())
    {
      case Type_relance_dossier_mipTable::AVANT_ETAT_AVANCEMENT :
      {
        $strNomPartial = "contenuMailRelanceEtatAvancementEcheance";
        break;
      }

      case Type_relance_dossier_mipTable::APRES_ETAT_AVANCEMENT :
      {
        $strNomPartial = "contenuMailRelanceEtatAvancementRetard";
        break;
      }

      case Type_relance_dossier_mipTable::AVANT_COMPT_RENDU :
      {
        $strNomPartial = "contenuMailRelanceComptRenduEcheance";
        break;
      }

      case Type_relance_dossier_mipTable::APRES_COMPT_RENDU :
      {
        $strNomPartial = "contenuMailRelanceComptRenduRetard";
        break;
      }

      case Type_relance_dossier_mipTable::APRES_ENVOI_ETAT_MAJEUR :
      {
        $strNomPartial = "contenuMailRelanceAvisEtatMajeur";
        break;
      }

      case Type_relance_dossier_mipTable::APRES_RECU_AVIS_FAVORABLE :
      {
        $strNomPartial = "contenuMailRelanceLettreSoutien";
        break;
      }

      default:
      {
        $this->logSection('Type_dossier_mip introuvable id: ' , $objTypeRelance->getId(). '  Erreur:' . $exc->getMessage());
        if ($options['env'] != 'prod') {
          echo $exc->getTraceAsString();
        }
      }
        break;
    }

    //Connection pour la transaction
    $connection = Doctrine_Manager::getInstance()->getCurrentConnection();

    //Init mailer
    $gestionnaireMail = new GestionnaireMail();

    //Start transaction sur l'envoi des mails et l'nregistrement des relances
    $connection->beginTransaction();

    foreach ($arrDossiers as $objDossier)
    {
      //Si le dossier a un pilote
      if ($objDossier->getPilote()->getId())
      {
        $strUrlRenvoiVersDossier = sfConfig::get("app_url_application").'dossier_mip/modifierDossier_mip/id/'.$objDossier->getId();

        //Date referncé dans les mails (relance, date de receprion d'avis d'etat major, ...)
        $strDateReferance = '';

        //Recupere la date referncée
        switch ($objTypeRelance->getId())
        {
          case Type_relance_dossier_mipTable::APRES_ETAT_AVANCEMENT :
          {
            foreach ($objDossier->getRelance_dossier_mip() as $objRelance)
            {
              if ($objRelance->getTypeRelanceDossierMipId() == Type_relance_dossier_mipTable::APRES_ETAT_AVANCEMENT)
              {
                $strDateReferance = $objRelance->getCreatedAt();
              }
            }
            
            break;
          }

          case Type_relance_dossier_mipTable::APRES_COMPT_RENDU :
          {
            foreach ($objDossier->getRelance_dossier_mip() as $objRelance)
            {
              if ($objRelance->getTypeRelanceDossierMipId() == Type_relance_dossier_mipTable::APRES_COMPT_RENDU)
              {
                $strDateReferance = $objRelance->getCreatedAt();
              }
            }
            
            break;
          }

          case Type_relance_dossier_mipTable::APRES_ENVOI_ETAT_MAJEUR :
          {
            $strDateReferance = $objDossier->getAvis_etatmajor()->getDateDemande();
            break;
          }

          case Type_relance_dossier_mipTable::APRES_RECU_AVIS_FAVORABLE :
          {
            $strDateReferance = $objDossier->getAvis_etatmajor()->getDateEnvoi();;
            break;
          }

          default:
          {
            //$this->logSection('Type_dossier_mip introuvable id: ' , $objTypeRelance->getId());
          }
            break;
        }
        

        try {
          $strContenuMail = get_partial('email/'.$strNomPartial,array('objDossier' => $objDossier,'strDateReferance' => $strDateReferance, 'strLienModifierDossier' => $strUrlRenvoiVersDossier));
          $gestionnaireMail->envoyerMailDeRelanceDossierMIP($objDossier->getPilote(), $strContenuMail, $objDossier->getNumero());

          try {
            $objRelance = new Relance_dossier_mip();
            $objRelance->setDossierMIP($objDossier);
            $objRelance->setTypeRelanceDossierMipId($objTypeRelance->getId());
            $objRelance->save();
          } catch (Exception $exc) {
            $this->logSection('Echec enregistrement relance de type - '.$objTypeRelance->getIntitule().' - pour dossier MIP id: ' , $objDossier->getId(). '  Erreur:' . $exc->getMessage());
            if ($options['env'] != 'prod') {
              echo $exc->getTraceAsString();
            }
          }
        } catch (Exception $exc) {
          $this->logSection('Echec envoi mail de relance de type - '.$objTypeRelance->getIntitule().' - pour dossier MIP id: ' , $objDossier->getId(). '  Erreur:' . $exc->getMessage());
          if ($options['env'] != 'prod') {
            echo $exc->getTraceAsString();
          }
        }
      }
    }

    //Fin transaction sur l'envoi des mails et l'nregistrement des relances
    $connection->commit();

    $this->logSection("envoiMailEtSaveRelance() -> Fin");
  }

}

?>
