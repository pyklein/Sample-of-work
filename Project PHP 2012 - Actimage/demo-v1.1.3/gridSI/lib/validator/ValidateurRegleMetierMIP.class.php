<?php

/**
 * Description of UtilValidateurRegleMetierMIP
 *  Classe se chargant de verifier les regles métiers et informations manquantes dans un objet Dossier_MIP
 * @author William
 */
class ValidateurRegleMetierMIP implements ValidateurRegleMetierInterface {

  private $objDossierMip;

  public function __construct(Dossier_mip $objDossier) {
    $this->objDossierMip = $objDossier;
  }

  /**
   *  Methode retournant toutes les erreurs ou avertissements liées au dossiere
   * @param  booleen $boolRapide true si on cherche juste la présence d'erreurs et pas le détail complet
   * @return array array('infos' => array(<nomChampManquant> => <typeErreur>,...),'regles' => array(<nomRegle> => <typeErreur>,...))
   */
  public function getStatutValidation($boolRapide = false) {
    if (sfContext::hasInstance()) {
      $logger = sfContext::getInstance()->getLogger();
      $logger->debug('{UtilValidateurRegleMetierMIP} getStatutValidation début');
    }
    $arrStatut = array();

    $arrErreurInfos = $this->getErreurInfos($boolRapide);
    if (count($arrErreurInfos) != 0) {
      $arrStatut['infos'] = $arrErreurInfos;
      if ($boolRapide) {
        if (sfContext::hasInstance()) {
          $logger->debug('{UtilValidateurRegleMetierMIP} getStatutValidation fin rapide');
        }
        return $arrStatut;
      }
    }



    $arrReglesNonRespectees = $this->getErreurRegles($boolRapide);
    if (count($arrReglesNonRespectees) != 0) {
      $arrStatut['regles'] = $arrReglesNonRespectees;
      if ($boolRapide) {
        if (sfContext::hasInstance()) {
          $logger->debug('{UtilValidateurRegleMetierMIP} getStatutValidation fin rapide');
        }
        return $arrStatut;
      }
    }

    //écheances


    $arrEcheances = $this->getEcheances($boolRapide);
    if (count($arrEcheances) != 0) {
      $arrStatut['echeances'] = $arrEcheances;
    }

    //Finances

    $arrFinances = $this->getErreurFinaces($boolRapide);
    if (count($arrFinances) != 0) {
      $arrStatut['finances'] = $arrFinances;
    }

    if (sfContext::hasInstance()) {
      $logger->debug('{UtilValidateurRegleMetierMIP} getStatutValidation fin');
    }

    return $arrStatut;
  }

  /**
   *  Renvoi les erreurs liées aux champs non remplis
   * @return array
   */
  private function getErreurInfos($boolRapide = false) {
    //Informations manquantes
    $arrInfosManquantes = array();
    if ($this->objDossierMip->getTitre() == null) {
      array_push($arrInfosManquantes, array('titre' => 'controle_haut'));
      if ($boolRapide) {
        return $arrInfosManquantes;
      }
    }
    if ($this->objDossierMip->getDescriptif() == null) {
      array_push($arrInfosManquantes, array('descriptif' => 'controle_haut'));
      if ($boolRapide) {
        return $arrInfosManquantes;
      }
    }
    if ($this->objDossierMip->getInnovateurs()->count() == 0) {
      array_push($arrInfosManquantes, array('innovateurs' => 'controle_haut'));
      if ($boolRapide) {
        return $arrInfosManquantes;
      }
    }
    return array();//$arrInfosManquantes;
  }

  /**
   *  Renvoi les erreures liées aux règles métiers non respectées
   * @return array
   */
  private function getErreurRegles($boolRapide = false) {
    //préparation de l'array erreurs metiers
    $arrReglesNonRespectees = array();
    switch ($this->objDossierMip->getStatutDossierMipId()) {
      case Statut_dossier_mipTable::ATT_VISITE_INNOV :
        if ($this->objDossierMip->getRendez_vous()->getDate_rdv() == null) {
          array_push($arrReglesNonRespectees, array('date_rendez_vous' => 'controle_haut'));
          if ($boolRapide) {
            return $arrReglesNonRespectees;
          }
        }
        break;
      case Statut_dossier_mipTable::ATT_AVIS_EM :
        if ($this->objDossierMip->getAvis_etatmajor()->getDate_demande() == null) {
          array_push($arrReglesNonRespectees, array('date_avis_etat_major' => 'controle_haut'));
          if ($boolRapide) {
            return $arrReglesNonRespectees;
          }
        }
        if ($this->objDossierMip->getAvis_etatmajor()->getReference_demande() == null) {
          array_push($arrReglesNonRespectees, array('reference_avis_etat_major' => 'controle_haut'));
          if ($boolRapide) {
            return $arrReglesNonRespectees;
          }
        }
        break;
      case Statut_dossier_mipTable::LET_SOUTIEN_A_ENVOYER :
        if ($this->objDossierMip->getAvis_etatmajor()->getDate_reception() == null) {
          array_push($arrReglesNonRespectees, array('aucune_reception_avis' => 'controle_haut'));
          if ($boolRapide) {
            return $arrReglesNonRespectees;
          }
        }
        if ($this->objDossierMip->getAvis_etatmajor()->getReference() == null) {
          array_push($arrReglesNonRespectees, array('aucune_ref_avis' => 'controle_haut'));
          if ($boolRapide) {
            return $arrReglesNonRespectees;
          }
        }
        break;
      //trois cas identiques
      case Statut_dossier_mipTable::ATT_FINANCE :
      case Statut_dossier_mipTable::ATT_EA :
      case Statut_dossier_mipTable::ATT_CR :
        if ($this->objDossierMip->getSoutien()->getDate_emission() == null) {
          array_push($arrReglesNonRespectees, array('aucune_date_emission' => 'controle_haut'));
          if ($boolRapide) {
            return $arrReglesNonRespectees;
          }
        }
        if ($this->objDossierMip->getAvis_etatmajor()->getReference() == null) {
          array_push($arrReglesNonRespectees, array('aucune_ref_soutien' => 'controle_haut'));
          if ($boolRapide) {
            return $arrReglesNonRespectees;
          }
        }
        break;
      case Statut_dossier_mipTable::EN_ATT_CLOTURE :
        if ($this->objDossierMip->getRemise_documents()->getDate_reception_ea() == null) {
          array_push($arrReglesNonRespectees, array('aucune_date_reception_ea' => 'controle_haut'));
          if ($boolRapide) {
            return $arrReglesNonRespectees;
          }
        }
        if ($this->objDossierMip->getRemise_documents()->getReference_ea() == null) {
          array_push($arrReglesNonRespectees, array('aucune_ref_ea' => 'controle_haut'));
          if ($boolRapide) {
            return $arrReglesNonRespectees;
          }
        }
        break;
      case Statut_dossier_mipTable::FINANCE_CLOS :
        if ($this->objDossierMip->getRemise_documents()->getDate_reception_ea() == null) {
          array_push($arrReglesNonRespectees, array('aucune_date_reception_ea' => 'controle_haut'));
          if ($boolRapide) {
            return $arrReglesNonRespectees;
          }
        }
        if ($this->objDossierMip->getRemise_documents()->getReference_ea() == null) {
          array_push($arrReglesNonRespectees, array('aucune_ref_ea' => 'controle_haut'));
          if ($boolRapide) {
            return $arrReglesNonRespectees;
          }
        }
        if ($this->objDossierMip->getRemise_documents()->getDate_reception_cr() == null) {
          array_push($arrReglesNonRespectees, array('aucune_date_reception_cr' => 'controle_haut'));
          if ($boolRapide) {
            return $arrReglesNonRespectees;
          }
        }
        if ($this->objDossierMip->getRemise_documents()->getReference_cr() == null) {
          array_push($arrReglesNonRespectees, array('aucune_ref_cr' => 'controle_haut'));
          if ($boolRapide) {
            return $arrReglesNonRespectees;
          }
        }
        if ($this->objDossierMip->getRemise_documents()->getDate_reception_video() == null) {
          array_push($arrReglesNonRespectees, array('aucune_date_reception_video' => 'controle_haut'));
          if ($boolRapide) {
            return $arrReglesNonRespectees;
          }
        }
        if ($this->objDossierMip->getRemise_documents()->getReference_video() == null) {
          array_push($arrReglesNonRespectees, array('aucune_ref_video' => 'controle_haut'));
          if ($boolRapide) {
            return $arrReglesNonRespectees;
          }
        }
        break;
      case Statut_dossier_mipTable::ABANDON_CLOS :
        if ($this->objDossierMip->getTransfert_cloture()->getDate_cloture() == null) {
          array_push($arrReglesNonRespectees, array('aucune_date_cloture' => 'controle_haut'));
          if ($boolRapide) {
            return $arrReglesNonRespectees;
          }
        }
        if ($this->objDossierMip->getTransfert_cloture()->getReference_cloture() == null) {
          array_push($arrReglesNonRespectees, array('aucune_ref_cloture' => 'controle_haut'));
          if ($boolRapide) {
            return $arrReglesNonRespectees;
          }
        }
      case Statut_dossier_mipTable::TRANSFERE :
        if ($this->objDossierMip->getTransfert_cloture()->getDate_transfert() == null) {
          array_push($arrReglesNonRespectees, array('aucune_date_transfert' => 'controle_haut'));
          if ($boolRapide) {
            return $arrReglesNonRespectees;
          }
        }
        if ($this->objDossierMip->getTransfert_cloture()->getReference_transfert() == null) {
          array_push($arrReglesNonRespectees, array('aucune_ref_transfert' => 'controle_haut'));
          if ($boolRapide) {
            return $arrReglesNonRespectees;
          }
        }
        if ($this->objDossierMip->getTransfert_cloture()->getDestination_autre() == null) {
          array_push($arrReglesNonRespectees, array('aucune_destination' => 'controle_haut'));
          if ($boolRapide) {
            return $arrReglesNonRespectees;
          }
        }
      default :
        break;
    }
    return $arrReglesNonRespectees;
  }

  /**
   *  Renvoi les informations liées aux échéances
   * @return array
   */
  private function getEcheances($boolRapide = false) {
    $arrEcheances = array();

    //avis EM envoi
    $objAvis = $this->objDossierMip['Avis_etatmajor'];
    if ($objAvis->getDateDemande() != null) {
      $arrTemp = array();
      if (date('Y-m-d') >= $objAvis->getDateTimeObject('date_demande')->modify('+30 days')->format('Y-m-d')
	      && ($objAvis->getDateReception() == null)
	  ) {
        $arrTemp = array(
            'intitule' => 'avis_em_demande',
            'class' => 'controle_haut',
            'date' => $objAvis->getDateTimeObject('date_demande')->format('Y-m-d'),
        );
        if ($this->objDossierMip->aRelanceEnvoyeeDeType(Type_relance_dossier_mipTable::APRES_ENVOI_ETAT_MAJEUR)) {
          $arrTemp['dateRelance'] = array($this->objDossierMip->getRelanceDeType(Type_relance_dossier_mipTable::APRES_ENVOI_ETAT_MAJEUR)->getDateTimeObject("created_at")->format('Y-m-d'));
        }
        array_push($arrEcheances, $arrTemp);
        if ($boolRapide) {
          return $arrEcheances;
        }
      }
    }
    //avis EM reception
    if ($objAvis->getDateReception() != null) {
	  $objSoutien = $this->objDossierMip->getSoutien();
      $arrTemp = array();
      if (date('Y-m-d') >= $objAvis->getDateTimeObject('date_reception')->modify('+7 days')->format('Y-m-d')
	      && ($objSoutien == null || $objSoutien->getDateEmission() == null)
	  ) {
        $arrTemp = array(
            'intitule' => 'avis_em_reception',
            'class' => 'controle_haut',
            'date' => $objAvis->getDateTimeObject('date_reception')->format('Y-m-d'),
        );
        if ($this->objDossierMip->aRelanceEnvoyeeDeType(Type_relance_dossier_mipTable::APRES_RECU_AVIS_FAVORABLE)) {
          $arrTemp['dateRelance'] = array($this->objDossierMip->getRelanceDeType(Type_relance_dossier_mipTable::APRES_RECU_AVIS_FAVORABLE)->getDateTimeObject("created_at")->format('Y-m-d'));
        }
        array_push($arrEcheances, $arrTemp);
        if ($boolRapide) {
          return $arrEcheances;
        }
      }
    }
    //Echeance EA
    $objEcheance = $this->objDossierMip->getEcheance();
	$objRemiseDocuments = $this->objDossierMip->getRemise_documents();
    if ($objEcheance->getDateEcheanceEa() != null) {
      $arrTemp = array();
      if (date('Y-m-d') >= $objEcheance->getDateTimeObject('date_echeance_ea')->modify('-30 days')->format('Y-m-d')
	      && ($objRemiseDocuments == null || $objRemiseDocuments->getDateReceptionEa() == null)
	  ) {
        $arrTemp = array(
            'intitule' => 'echeance_ea',
            'class' => 'controle_bas',
            'date' => $objEcheance->getDateTimeObject('date_echeance_ea')->format('Y-m-d'),
        );
        $arrTemp['dateRelance'] = array();
        if ($this->objDossierMip->aRelanceEnvoyeeDeType(Type_relance_dossier_mipTable::AVANT_ETAT_AVANCEMENT)) {
          array_push($arrTemp['dateRelance'], $this->objDossierMip->getRelanceDeType(Type_relance_dossier_mipTable::AVANT_ETAT_AVANCEMENT)->getDateTimeObject("created_at")->format('Y-m-d'));
        }
        if ($this->objDossierMip->aRelanceEnvoyeeDeType(Type_relance_dossier_mipTable::APRES_ETAT_AVANCEMENT)) {
          array_push($arrTemp['dateRelance'], $this->objDossierMip->getRelanceDeType(Type_relance_dossier_mipTable::APRES_ETAT_AVANCEMENT)->getDateTimeObject("created_at")->format('Y-m-d'));
        }
        if (date('Y-m-d') == $objEcheance->getDateTimeObject('date_echeance_ea')->format('Y-m-d')) {
          $arrTemp['class'] = 'controle_haut';
          if ($boolRapide) {
            array_push($arrEcheances, $arrTemp);
            return $arrEcheances;
          }
        }
        array_push($arrEcheances, $arrTemp);
      }
    }
    //Echeance CR
    $objEcheance = $this->objDossierMip->getEcheance();
    if ($objEcheance->getDateEcheanceCr() != null) {
      $arrTemp = array();
      if (date('Y-m-d') >= $objEcheance->getDateTimeObject('date_echeance_cr')->modify('-30 days')->format('Y-m-d')
	      && ($objRemiseDocuments == null || $objRemiseDocuments->getDateReceptionCr() == null)
	  ) {
        $arrTemp = array(
            'intitule' => 'echeance_cr',
            'class' => 'controle_bas',
            'date' => $objEcheance->getDateTimeObject('date_echeance_cr')->format('Y-m-d'),
        );
        $arrTemp['dateRelance'] = array();
        if ($this->objDossierMip->aRelanceEnvoyeeDeType(Type_relance_dossier_mipTable::AVANT_COMPT_RENDU)) {
          array_push($arrTemp['dateRelance'], $this->objDossierMip->getRelanceDeType(Type_relance_dossier_mipTable::AVANT_COMPT_RENDU)->getDateTimeObject("created_at")->format('Y-m-d'));
        }
        if ($this->objDossierMip->aRelanceEnvoyeeDeType(Type_relance_dossier_mipTable::APRES_COMPT_RENDU)) {
          array_push($arrTemp['dateRelance'], $this->objDossierMip->getRelanceDeType(Type_relance_dossier_mipTable::APRES_COMPT_RENDU)->getDateTimeObject("created_at")->format('Y-m-d'));
        }
        if (date('Y-m-d') == $objEcheance->getDateTimeObject('date_echeance_cr')->format('Y-m-d')) {
          $arrTemp['class'] = 'controle_haut';
          if ($boolRapide) {
            array_push($arrEcheances, $arrTemp);
            return $arrEcheances;
          }
        }
		array_push($arrEcheances, $arrTemp);
      }
    }

    return $arrEcheances;
  }

  /**
   * Recupere les erreurs liées au finances
   *
   * @param boolean $boolRapide true si on cherche juste la présence d'erreurs et pas le détail complet
   * @return array
   *
   * @author Simeon PETEV
   */
  private function getErreurFinaces($boolRapide = false)
  {
    $arrFinances = array();

    //Verifi si le reserve global des financements est negatif
    $arrFinancements = $this->objDossierMip->getFinancementsGlobauxParAnnees();
    if ($this->objDossierMip->getBudgetTotalGlobal() - end($arrFinancements) < 0) {
      array_push($arrFinances, array('financement_reserve_global' => 'controle_bas'));
      if ($boolRapide) {
        return $arrFinances;
      }
    }

    //Verifi si le reserve global des engagements est negatif
    $arrEngagements = $this->objDossierMip->getEngagementsGlobauxParAnnees();
    if ($this->objDossierMip->getBudgetTotalGlobal() - end($arrEngagements) < 0) {
      array_push($arrFinances, array('engagement_reserve_global' => 'controle_bas'));
      if ($boolRapide) {
        return $arrFinances;
      }
    }

    //verifie si le total des paiements est supérieur au total des engagements
    //recherche des paiements
    $arrPaiementParAnnee = $this->objDossierMip->getPaiementsGlobauxParAnnees();
    if ((end($arrEngagements) - end($arrPaiementParAnnee)) < 0) {
      array_push($arrFinances, array('paiement_superieur_engagement' => 'controle_bas'));
      if ($boolRapide) {
        return $arrFinances;
      }
    }

    return $arrFinances;
  }

}

?>
