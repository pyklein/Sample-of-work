<?php

/**
 * Classe représentant la tache symfony de génération des alertes.
 * @author Gabor JAGER
 */
class CreationAlertesBpiGridTask extends GridTask
{
  /**
   * Configuration de la tâche: lancer avec :  php symfony grid:alertes_bpi --application=gridweb
   * @param Console application   spécifie l'application dont la configuration doit être chargée
   * @param Console env           spécifie l'environnement dont la configuration doit être chargée
   */
  protected function configure()
  {
    $this->app              = 'gridweb';
    $this->namespace        = 'grid';
    $this->name             = 'alertes_bpi';
    $this->briefDescription = 'Creation des alertes BPI';

    parent::configure();
  }

  protected function execute($arguments = array(), $options = array())
  {
    // init d'execution
    $vieuxDossier = '+3 months';
    $this->debut($arguments, $options);

    $this->logSection(__CLASS__."->".__FUNCTION__."() -> Début");
    
    $arrDossierBpis = Dossier_bpiTable::getInstance()->getDossiersActifs();
    $intReussi = 0;
    $intErreur = 0;
    foreach ($arrDossierBpis as $objDossierBpi)
    {
      try
      {
        $this->creerAlertes($objDossierBpi);
        $intReussi++;
      }

      catch(Exception $ex)
      {
        $this->logSection(__CLASS__."->".__FUNCTION__."() -> Erreur: ".$ex->getTraceAsString());
        $intErreur++;
      }
    }

    $this->logSection(__CLASS__."->".__FUNCTION__."() -> Fin");
    
    // fin d'execution
    $this->fin(false, libelle("msg_tache_rapport_creation_alertes_bpi", array($intErreur, count($arrDossierBpis))));
  }

  private function creerAlertes(Dossier_bpi $objDossierBpi)
  {
    $this->logSection(__CLASS__."->".__FUNCTION__."() -> Début - dossier ID: ".$objDossierBpi->getId());

    // Connection pour la transaction
    $connection = Doctrine_Manager::getInstance()->getCurrentConnection();

    // Init mailer
    $gestionnaireMail = new GestionnaireMail();
    
    // Start transaction sur l'envoi des mails et l'enregistrement des relances
    $connection->beginTransaction();

    try
    {
      $utilValidateurRegleMetierBPI = new ValidateurRegleMetierBPI($objDossierBpi);
      $arrErreurs = $utilValidateurRegleMetierBPI->getStatutValidation();

      $boolNouveauAlertes = false;
      
      // alertes actions à mener
      if (count($arrErreurs["actions"]) > 0)
      {
        foreach($arrErreurs["actions"] as $arrErreur)
        {
          $objAction       = $arrErreur["objet"];
          $strDateEcheance = $arrErreur["echeance"];

          // on crée l'alerte
          $this->logSection(__CLASS__."->".__FUNCTION__."() -> Créer alerte - action à mener - Action ID: ".$objAction->getId());
          
          if ((strtotime(date("Y-m-d")) > strtotime($strDateEcheance)) && (strtotime(date("Y-m-d")) < strtotime($strDateEcheance." ".$vieuxDossier)))
          {
            $boolDejaPasse = false;
          }
          else
          {
            $boolDejaPasse = true;
          }

          $boolResultat = $this->creerObjetAlerte($objDossierBpi, Type_alerte_bpiTable::ACTION_A_MENER, $strDateEcheance, $boolDejaPasse, $objAction);

          // on envoi le mail (si l'alerte a été crée)
          if ($boolResultat)
          {
            $boolNouveauAlertes = true;
            $this->logSection(__CLASS__."->".__FUNCTION__."() -> Mail de l'action à mener - Action ID: ".$objAction->getId());

            $strLienAction = sfConfig::get("app_url_application").'dossier_bpi/actionsDossiers/dossier_bpi/'.$objDossierBpi->getId();

            $strContenuMail = get_partial('email/contenuMailAlerteBpiActionAMener',
                                          array('objDossierBpi' => $objDossierBpi,
                                                'objAction' => $objAction,
                                                'strDateEcheance' => $strDateEcheance,
                                                'strLienAction' => $strLienAction
                                          ));

            $gestionnaireMail->envoyerMailAlerteBpiActionAMener($objAction->getPilote(), $strContenuMail, $objDossierBpi->getNumero());
          }
        }
      }

      // alertes classements
      if (count($arrErreurs["classements"]) > 0)
      {
        foreach($arrErreurs["classements"] as $arrErreur)
        {
          $strDateEcheance = $arrErreur["echeance"];

          //si la date est d'écheance est passée et est inférieur à 3 mois après l'écheance
          if ((strtotime(date("Y-m-d")) > strtotime($strDateEcheance)) && (strtotime(date("Y-m-d")) < strtotime($strDateEcheance." ".$vieuxDossier)))
          {
            $boolDejaPasse = false;
          }
          else
          {
            $boolDejaPasse = true;
          }

          $this->logSection(__CLASS__."->".__FUNCTION__."() -> Créer alerte - Délais pour le classement de l'invention");
          $boolResultat = $this->creerObjetAlerte($objDossierBpi, Type_alerte_bpiTable::DELAI_CLASSEMENT, $strDateEcheance, $boolDejaPasse);
          
          if ($boolResultat)
          {
            $boolNouveauAlertes = true;
          }
        }
      }

      // alertes droits
      if (count($arrErreurs["droits"]) > 0)
      {
        foreach($arrErreurs["droits"] as $arrErreur)
        {
          $strDateEcheance = $arrErreur["echeance"];

          if ((strtotime(date("Y-m-d")) > strtotime($strDateEcheance)) && (strtotime(date("Y-m-d")) < strtotime($strDateEcheance." ".$vieuxDossier)))
          {
            $boolDejaPasse = false;
          }
          else
          {
            $boolDejaPasse = true;
          }

          $this->logSection(__CLASS__."->".__FUNCTION__."() -> Créer alerte - Attribution des droits");
          $boolResultat = $this->creerObjetAlerte($objDossierBpi, Type_alerte_bpiTable::ATTRIBUTION_DROIT, $strDateEcheance, $boolDejaPasse);

          if ($boolResultat)
          {
            $boolNouveauAlertes = true;
          }
        }
      }

      // alertes brevets
      if (count($arrErreurs["brevets"]) > 0)
      {
        foreach($arrErreurs["brevets"] as $arrErreur)
        {
          $objBrevet       = $arrErreur["objet"];
          $strDateEcheance = $arrErreur["echeance"];

          if ((strtotime(date("Y-m-d")) > strtotime($strDateEcheance)) && (strtotime(date("Y-m-d")) < strtotime($strDateEcheance." ".$vieuxDossier)))
          {
            $boolDejaPasse = false;
          }
          else
          {
            $boolDejaPasse = true;
          }

          $this->logSection(__CLASS__."->".__FUNCTION__."() -> Créer alerte - Brevets - Brevet ID: ".$objBrevet->getId());
          $boolResultat = $this->creerObjetAlerte($objDossierBpi, Type_alerte_bpiTable::BREVET, $strDateEcheance, $boolDejaPasse, null, $objBrevet);

          if ($boolResultat)
          {
            $boolNouveauAlertes = true;
          }
        }
      }

      // alertes primes
      if (count($arrErreurs["primes"]) > 0)
      {
        foreach($arrErreurs["primes"] as $arrErreur)
        {
          $strDateEcheance = $arrErreur["echeance"];

          if ((strtotime(date("Y-m-d")) > strtotime($strDateEcheance)) && (strtotime(date("Y-m-d")) < strtotime($strDateEcheance." ".$vieuxDossier)))
          {
            $boolDejaPasse = false;
          }
          else
          {
            $boolDejaPasse = true;
          }

          $this->logSection(__CLASS__."->".__FUNCTION__."() -> Créer alerte - Prime au brevet");
          $boolResultat = $this->creerObjetAlerte($objDossierBpi, Type_alerte_bpiTable::PRIME_AU_BREVET, $strDateEcheance, $boolDejaPasse);

          if ($boolResultat)
          {
            $boolNouveauAlertes = true;
          }
        }
      }

      // alertes regroupé pour les super-utilisateurs BPIs
      if ($boolNouveauAlertes)
      {
        $strLienAction = sfConfig::get("app_url_application").'dossier_bpi/modifierDossier_bpi/id/'.$objDossierBpi->getId();

        $strContenuMail = get_partial('email/contenuMailAlerteBpi',
                                      array('objDossierBpi' => $objDossierBpi,
                                            'strLienAction' => $strLienAction,
                                            'arrErreurs' => $arrErreurs
                                      ));

        $arrUtilisateurs = UtilisateurTable::getInstance()->retrieveSuperUtilisateursByMetierId(MetierTable::BPI_ID);

        $this->logSection(__CLASS__."->".__FUNCTION__."() -> Mail de l'alerte aux super-utilisateurs BPIs");

        if (count($arrUtilisateurs) == 0)
        {
          $this->logSection(__CLASS__."->".__FUNCTION__."() -> Pas de super-utilisateur BPI");
        }

        $gestionnaireMail->envoyerMailAlerteBpi($arrUtilisateurs, $strContenuMail, $objDossierBpi->getNumero());
      }

      // commit
      $this->logSection(__CLASS__."->".__FUNCTION__."() -> Commit");
      $connection->commit();
    }

    // erreur -> rollback
    catch(Exception $ex)
    {
      $this->logSection(__CLASS__."->".__FUNCTION__."() -> Erreur: ".$ex->getTraceAsString());
      $connection->rollback();
    }

    $this->logSection(__CLASS__."->".__FUNCTION__."() -> Fin");
  }

  /**
   * Permet de créer un objet Alerte dans la base de dnonnées
   * @param Dossier_bpi $objDossierBpi
   * @param integer $intTypeAlerteBpiId ID de type des alertes. Utilise les constantes de la table Type_alerte_bpiTable.
   * @param string $strDateEcheance
   * @param boolean $boolDejaPasse si la date d'echeance est déja dépassé ou pas
   * @param Action $objAction
   * @param Brevet $objBrevet
   * @return boolean true si l'objet a été créé
   *                 false si l'objet existe déja
   * @author Gabor JAGER
   */
  private function creerObjetAlerte(Dossier_bpi $objDossierBpi, $intTypeAlerteBpiId, $strDateEcheance, $boolDejaPasse, Action $objAction = null, Brevet $objBrevet = null)
  {
    $objAlerte = Alerte_bpiTable::getInstance()->getAlerteByDossierIdTypeAlerte($objDossierBpi->getId(), 
                                                                                $intTypeAlerteBpiId,
                                                                                $strDateEcheance,
                                                                                $objAction == null ? null : $objAction->getId(),
                                                                                $objBrevet == null ? null : $objBrevet->getId(),
                                                                                $boolDejaPasse);

    if (count($objAlerte) != 0)
    {
      $this->logSection(__CLASS__."->".__FUNCTION__."() -> Alerte existe déjà");
      return false;
    }

    $objAlerte = new Alerte_bpi();

    if ($objAction != null)
    {
      $objAlerte->setActionId($objAction->getId());
    }

    if ($objBrevet != null)
    {
      $objAlerte->setBrevetId($objBrevet->getId());
    }

    $objAlerte->setDateAlerte(date("Y-m-d H:i:s"));
    $objAlerte->setDejaPasse($boolDejaPasse);
    $objAlerte->setDateEcheance($strDateEcheance);
    $objAlerte->setDossierBpiId($objDossierBpi->getId());
    $objAlerte->setTypeAlerteBpiId($intTypeAlerteBpiId);
    $objAlerte->save();

    return true;
  }
}
