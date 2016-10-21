<?php

sfContext::getInstance()->getConfiguration()->loadHelpers("Format");

/**
 * Classe se chargant de verifier les regles métiers et informations manquantes
 * dans un objet Dossier_bpi
 * @author Gabor JAGER
 */
class ValidateurRegleMetierBPI implements ValidateurRegleMetierInterface
{
  private $strDelaiClassement  = "+2 months";
  private $strDelaiDroits      = "+4 months";
  private $strDelaiPrimeBrevet = "+1 year";

  /**
   * Pour calculer la date d'approche
   * @var string
   */
  private $strDateApproche = "+15 days";

  /**
   * Dossier concerné
   * @var Dossier_bpi
   */
  private $objDossierBpi;

  /**
   * @var sfLogger
   */
  private $logger;

  /**
   * Constructeur
   * @param Dossier_bpi $objDossier
   */
  public function __construct(Dossier_bpi $objDossier)
  {
    $this->objDossierBpi = $objDossier;

    if (sfContext::hasInstance()) {
      $this->logger = sfContext::getInstance()->getLogger();
      $this->logger->debug(__CLASS__."->".__FUNCTION__."() - contructeur, dossier id=".$objDossier->getId());
    }
  }

  /**
   *  Methode retournant toutes les erreurs ou avertissements liées au dossiere
   * @param  booleen $boolRapide true si on cherche juste la présence d'erreurs et pas le détail complet
   * @return array array('infos' => array(<nomChampManquant> => <typeErreur>,...),'regles' => array(<nomRegle> => <typeErreur>,...))
   */
  public function getStatutValidation($boolRapide = false)
  {
    if (sfContext::hasInstance())
    {
      $this->logger->debug(__CLASS__."->".__FUNCTION__."() - début");
    }

    $arrStatut = array();

    // actions à mener
    $arrActions = $this->getActions($boolRapide);
    if (count($arrActions) != 0)
    {
      $arrStatut['actions'] = $arrActions;
    }

    // brevets
    $arrBrevets = $this->getBrevets($boolRapide);
    if (count($arrBrevets) != 0)
    {
      $arrStatut['brevets'] = $arrBrevets;
    }

    // classements
    $arrClassements = $this->getClassements($boolRapide);
    if (count($arrClassements) != 0)
    {
      $arrStatut['classements'] = $arrClassements;
    }

    // droits
    $arrDroits = $this->getAttributionDroits($boolRapide);
    if (count($arrDroits) != 0)
    {
      $arrStatut['droits'] = $arrDroits;
    }

    // primes
    $arrPrimes = $this->getPrimeBrevet($boolRapide);
    if (count($arrPrimes) != 0)
    {
      $arrStatut['primes'] = $arrPrimes;
    }

    if (sfContext::hasInstance())
    {
      $this->logger->debug(__CLASS__."->".__FUNCTION__."() - fin");
    }

    return $arrStatut;
  }

  /**
   * Renvoi les informations liées aux actions à mener
   * @return array
   */
  private function getActions($boolRapide = false)
  {
    if (sfContext::hasInstance())
    {
      $this->logger->debug(__CLASS__."->".__FUNCTION__."() - début");
    }

    $arrEcheances = array();

    // date limite
    $strDateEcheance = date("Y-m-d", strtotime($this->strDateApproche));

    // actions à mener
    $arrActions = ActionTable::getInstance()->getActionsAMenerByDossierBpi($this->objDossierBpi->getId(), $strDateEcheance)->execute();

    foreach($arrActions as $objAction)
    {
      $arrTemp = array();
      $arrTemp['objet'] = $objAction;
      $arrTemp['echeance'] = $objAction->getDateTimeObject('date_echeance')->format('Y-m-d');

      // déjà dépassé
      if (strtotime(date('Y-m-d')) >= strtotime($arrTemp['echeance']))
      {
        $arrTemp['class'] = 'controle_haut';
      }

      // pas encore dépassé
      else
      {
        $arrTemp['class'] = 'controle_bas';
      }

      $arrTemp['alertes'] = $this->getDatesAlertes(Type_alerte_bpiTable::ACTION_A_MENER, $arrTemp['echeance'], $objAction->getId(), null);

      array_push($arrEcheances, $arrTemp);
      if ($boolRapide)
      {
        return $arrEcheances;
      }
    }

    if (sfContext::hasInstance())
    {
      $this->logger->debug(__CLASS__."->".__FUNCTION__."() - fin");
    }

    return $arrEcheances;
  }

  /**
   * Renvoi les informations liées aux brevets
   * @return array
   */
  private function getBrevets($boolRapide = false)
  {
    if (sfContext::hasInstance())
    {
      $this->logger->debug(__CLASS__."->".__FUNCTION__."() - début");
    }

    $arrEcheances = array();

    $strDateEcheance = date("Y-m-d", strtotime($this->strDateApproche));

    // brevets
    $arrBrevets = BrevetTable::getInstance()->retrieveBrevetsAlertes($this->objDossierBpi->getId(), $strDateEcheance)->execute();

    foreach($arrBrevets as $objBrevet)
    {
      $arrTemp = array();
      $arrTemp['objet'] = $objBrevet;
      $arrTemp['echeance'] = $objBrevet->getDateTimeObject('date_objectif_depot')->format('Y-m-d');

      // brevet échéance
      $strDateBrevetEcheance = date("Y-m-d", strtotime($arrTemp['echeance']." ".$this->strDateApproche));

      // déjà dépassé
      if (strtotime(date('Y-m-d')) >= strtotime($strDateBrevetEcheance))
      {
        $arrTemp['class'] = 'controle_haut';
      }

      // pas encore dépassé
      else
      {
        $arrTemp['class'] = 'controle_bas';
      }

      $arrTemp['alertes'] = $this->getDatesAlertes(Type_alerte_bpiTable::BREVET, $arrTemp['echeance'], null, $objBrevet->getId());

      array_push($arrEcheances, $arrTemp);
      if ($boolRapide)
      {
        return $arrEcheances;
      }
    }

    if (sfContext::hasInstance())
    {
      $this->logger->debug(__CLASS__."->".__FUNCTION__."() - fin");
    }

    return $arrEcheances;
  }

  /**
   * Renvoi les informations liées aux classements
   * @return array
   */
  private function getClassements($boolRapide = false)
  {
    if (sfContext::hasInstance())
    {
      $this->logger->debug(__CLASS__."->".__FUNCTION__."() - début");
    }

    $arrEcheances = array();

    if ($this->objDossierBpi->getDateDeclarationConforme() == null
            && $this->objDossierBpi->getDateClassement() == null)
    {
      return array();
    }

    // date de classement renseigné
    if ($this->objDossierBpi->getDateClassement() != null)
    {
      return array();
    }

    // on calcule l'échéance
    $strDateEcheance = date("Y-m-d", strtotime($this->objDossierBpi->getDateDeclarationConforme()." ".$this->strDelaiClassement));

    // trop tôt pour alerte
    if (strtotime(date("Y-m-d")." ".$this->strDateApproche) < strtotime($strDateEcheance))
    {
      return array();
    }
    
    $arrTemp = array();
    $arrTemp['echeance'] = $strDateEcheance;
    $arrTemp['objet'] = $this->objDossierBpi;
    
    // déjà dépassé
    if (strtotime(date('Y-m-d')) >= strtotime($strDateEcheance))
    {
      $arrTemp['class'] = 'controle_haut';
    }

    // pas encore dépassé
    else
    {
      $arrTemp['class'] = 'controle_bas';
    }

    $arrTemp['alertes'] = $this->getDatesAlertes(Type_alerte_bpiTable::DELAI_CLASSEMENT, $arrTemp['echeance']);

    $arrEcheances[] = $arrTemp;

    if (sfContext::hasInstance())
    {
      $this->logger->debug(__CLASS__."->".__FUNCTION__."() - fin");
    }
    
    return $arrEcheances;
  }

  /**
   * Renvoi les informations liées aux attributions droits
   * @return array
   */
  private function getAttributionDroits($boolRapide = false)
  {
    if (sfContext::hasInstance())
    {
      $this->logger->debug(__CLASS__."->".__FUNCTION__."() - début");
    }
    
    $arrEcheances = array();

    if ($this->objDossierBpi->getDateDeclarationConforme() == null)
    {
      return array();
    }

    $objAttributionDroit = Attribution_droitTable::getInstance()->findOneByDossierBpiId($this->objDossierBpi->getId());

    // on calcule l'échéance
    if ($objAttributionDroit != null && $objAttributionDroit->getEcheanceSupplementaire() != null)
    {
      $strDateEcheance = $objAttributionDroit->getEcheanceSupplementaire();
    }

    else
    {
      $strDateEcheance = date("Y-m-d", strtotime($this->objDossierBpi->getDateDeclarationConforme()." ".$this->strDelaiDroits));
    }
    
    // déjà renseigné
    if ($objAttributionDroit != null && $objAttributionDroit->getDateDecisionAttribution() != null)
    {
      return array();
    }

    // trop tôt pour alerte
    if (strtotime(date("Y-m-d")." ".$this->strDateApproche) < strtotime($strDateEcheance))
    {
      return array();
    }

    $arrTemp = array();
    $arrTemp['objet'] = $objAttributionDroit;
    $arrTemp['echeance'] = date("Y-m-d", strtotime($strDateEcheance));

    // déjà dépassé
    if (strtotime(date('Y-m-d')) >= strtotime($strDateEcheance))
    {
      $arrTemp['class'] = 'controle_haut';
    }

    // pas encore dépassé
    else
    {
      $arrTemp['class'] = 'controle_bas';
    }

    $arrTemp['alertes'] = $this->getDatesAlertes(Type_alerte_bpiTable::ATTRIBUTION_DROIT, $arrTemp['echeance']);

    $arrEcheances[] = $arrTemp;

    if (sfContext::hasInstance())
    {
      $this->logger->debug(__CLASS__."->".__FUNCTION__."() - fin");
    }
    
    return $arrEcheances;
  }

  /**
   * Renvoi les informations liées aux primes de brevets versées
   * @return array
   */
  private function getPrimeBrevet($boolRapide = false)
  {
    if (sfContext::hasInstance())
    {
      $this->logger->debug(__CLASS__."->".__FUNCTION__."() - début");
    }

    $arrEcheances = array();

    // date limite
    $strDateEcheance = date("Y-m-d", strtotime($this->objDossierBpi->getDateDeclarationConforme()." ".$this->strDelaiPrimeBrevet));
    
    // trop tôt pour alerte
    if (strtotime(date("Y-m-d")." ".$this->strDateApproche) < strtotime($strDateEcheance))
    {
      return array();
    }
    
    // recompenses
    $arrRecompenses = RecompensesTable::getInstance()->getRecompensesByDossier($this->objDossierBpi->getId())->execute();

    $arrTemp = array();
    $arrTemp['objet'] = $this->objDossierBpi;
    $arrTemp['echeance'] = date("Y-m-d", strtotime($strDateEcheance));

    // déjà dépassé
    if (strtotime(date('Y-m-d')) >= strtotime($strDateEcheance))
    {
      $arrTemp['class'] = 'controle_haut';
    }

    // pas encore dépassé
    else
    {
      $arrTemp['class'] = 'controle_bas';
    }

    $arrTemp['alertes'] = $this->getDatesAlertes(Type_alerte_bpiTable::PRIME_AU_BREVET, $arrTemp['echeance']);

    $arrEcheances[] = $arrTemp;

    // on vérifie le nombre de recompenses
    $arrInventeurs = $this->objDossierBpi->getInventeurs();

    // il manque des recompenses -> alerte
    if (count($arrInventeurs) != count($arrRecompenses))
    {
      return $arrEcheances;
    }

    foreach($arrRecompenses as $objRecompenses)
    {
      if ($objRecompenses->getDateVersement_20() == null)
      {
        return $arrEcheances;
      }
    }

    if (sfContext::hasInstance())
    {
      $this->logger->debug(__CLASS__."->".__FUNCTION__."() - fin");
    }

    // pas d'alerte
    return array();
  }

  /**
   * Permet de récupérer les dates des alertes envoyées en format de string
   * @param integer $intTypeAlerteBpiId ID de type des alertes. Utilise les constantes de la table Type_alerte_bpiTable.
   * @param string $strDateEcheance
   * @param integer $intActionId
   * @param integer $intBrevetId
   * @return string String à afficher
   */
  private function getDatesAlertes($intTypeAlerteBpiId, $strDateEcheance, $intActionId = null, $intBrevetId = null)
  {
    $arrAlertes = Alerte_bpiTable::getInstance()->getAlerteByDossierIdTypeAlerte($this->objDossierBpi->getId(), $intTypeAlerteBpiId, $strDateEcheance, $intActionId, $intBrevetId);

    $strRetour = "";
    foreach ($arrAlertes as $objAlerte)
    {
      $strRetour .= ($strRetour != "" ? ", " : "").formatDate($objAlerte->getDateAlerte());
    }

    return $strRetour;
  }
}
