<?php

/**
 * Description of Dossier_mrisParser
 * Classe de parsing créant des dossier MRIS et leurs relations à partir du fichier XML iXarm
 *
 * @author William
 */
class Dossier_mrisParser extends Doctrine_Parser_Xml {

  private $arrCorrespondancesTables;
  private $arrCorrespondancesChamps;
  private $arrParamsRecherches;
  private $typeDossier = '';
  private $arrDossiersParses = null;
  private $arrErreurs = array();
  private $objDernierSauvegarde = null;
  private $Ids = array();
  private $profondeur = 0;
  private $logger;
  private $finder;
  private $tempTableFils;

  /**
   *  Le constructeur prends un sfLogger en argument, permettant de logger où on le désire
   * @param sfLogger $logger
   */
  public function __construct(sfLogger $logger) {
    //Imporation de la configuration du parser
    $objParserYaml = new Doctrine_Parser_Yml();
    $arrDonnees = $objParserYaml->loadData(sfConfig::get("sf_config_dir") . "/parsing_mris.yml");

    $this->logger = $logger;
    //création d'un ObjectFinder et injection du logger dans celui-ci
    $this->finder = new gridObjectFinder($this->logger);
    $this->arrCorrespondancesTables = $arrDonnees["Tables"];
    $this->arrCorrespondancesChamps = $arrDonnees["Champs"];
    $this->arrParamsRecherches = $arrDonnees["Recherche"];
    $this->arrTablesDirectes = $arrDonnees["SauvegardesDirectes"];
  }

  /**
   * Seule methode publique, lance l'ensemble des opération de parsing/sauvegarde
   * @param string $path chemin du xml iXarm
   * @return array Tableau contenant les dossier parsés acompagnés de leurs rapport d'erreur
   */
  public function importerDossiers($path) {
    $this->logger->info('Debut Importation dossiers depuis fichier ixarm ' . $path);
    //chargement du contenu du fichier iXarm
    $contenu = $this->doLoad($path);
    $simpleXml = simplexml_load_string($contenu);
    if (!$simpleXml) {
      $msg = "Le fichier ixarm '" . $path . "' n'est pas un fichier xml valide, fin de l'importation.";
      $this->reportErreur($msg, true);
      throw new Exception($msg);
    }
    $arrDossiers = $this->listDossiersXml($simpleXml);

    $i = 0;
    foreach ($arrDossiers as $objDossier) {
      $this->logger->info('Importation dossier numero ' . ++$i);
      $this->arrErreurs = array();
      $this->arrDossiersParses[] = array($this->tryParseDossier($objDossier), $this->arrErreurs);
    }
    return $this->arrDossiersParses;
  }

  /**
   * Enveloppe l'initialisation du parsing d'un dossier et son parsing effectif
   * @param SimpleXMLElement $xmlDossier élément <dossier> du fichier iXarm
   * @return mixed Soit l'objet Dossier résultant, false en cas de non reconnaissance du type de dossier
   */
  protected function tryParseDossier($xmlDossier) {
    if ($this->prepareParsing($xmlDossier)) {
      $this->parseDataMris($xmlDossier, true);
      $this->importerDocuments($xmlDossier);
      return $this->objDernierSauvegarde;
    } else {
      return false;
    }
  }

  /**
   *  Methode gérant la liaison et la copie des documents importés avec le dossier
   * @param SimpleXMLElement $xmlDossier  élément <dossier> du fichier iXarm
   */
  protected function importerDocuments($xmlDossier) {
    if ($xmlDossier instanceof SimpleXMLElement) {
      $utilArbo = new ServiceArborescence();
      $objDossier = $this->objDernierSauvegarde;
      $children = $xmlDossier->children();
      foreach ($children as $element => $value) {//Parsing des valeurs scalaires d'un objet
        if ($value instanceof SimpleXMLElement) {
          if ($element == 'document') {
            $arrinfos = array();
            foreach ($value->children() as $typeInfo => $infoDocument) {
              $arrinfos[$typeInfo] = (string) $infoDocument;
            }
            $strCheminComplet = sfConfig::get("app_importation_ixarm_repertoire") . DIRECTORY_SEPARATOR . 'courant' . DIRECTORY_SEPARATOR . $this->typeDossier . str_replace(DIRECTORY_SEPARATOR, '_', $objDossier->getNumeroAAfficher()) . DIRECTORY_SEPARATOR . $arrinfos['fichier'];
            if (file_exists($strCheminComplet)) {
              $utilFichier = new UtilFichier();
              $strExt = $utilFichier->getExtension($strCheminComplet);
              $strMethodeArbo = "getRepertoireDossier".ucfirst($this->typeDossier);
              $strCheminBase = $utilArbo->$strMethodeArbo();
              $strFichierHashe = sha1($arrinfos['fichier'] . $this->typeDossier . str_replace(DIRECTORY_SEPARATOR, '_', $objDossier->getNumeroAAfficher())) . '.' . $strExt;
              if ($arrinfos['type'] == 'Descriptif') {//Fichier descriptif editable du dossier
                if (strpos(sfConfig::get("app_extensions_editable"), $strExt) === false) {
                  $message = "L'extension du fichier " . $arrinfos['fichier'] . " n'est pas autorisée pour le type Descriptif editable.";
                  $this->logger->err($message);
                  $this->arrErreurs[] = $message;
                  continue;
                }
                $this->logger->info('Fichier descriptif editable trouvé');
                $objDossier->setFichierEditable($strFichierHashe);
                $objDossier->setFichierEditableOrig($arrinfos['fichier']);
                $strCheminDestination = $strCheminBase . $strFichierHashe;
                if (!copy($strCheminComplet, $strCheminDestination)) {
                  $msg = "Echec de copie du fichier " . $arrinfos['fichier'] . " vers " . $strCheminDestination;
                  $this->logger->err($msg);
                  $this->arrErreurs[] = $msg;
                }
              } elseif ($arrinfos['type'] == 'DescriptifPdf') {//Fichier descriptif pdf du dossier
                if ('pdf' !== $strExt) {
                  $message = "L'extension du fichier " . $arrinfos['fichier'] . " n'est pas autorisée pour le type Descriptif pdf.";
                  $this->logger->err($message);
                  $this->arrErreurs[] = $message;
                  continue;
                }
                $this->logger->info('Fichier descriptif pdf trouvé');
                $objDossier->setFichierPdf($strFichierHashe);
                $objDossier->setFichierPdfOrig($arrinfos['fichier']);
                $strCheminDestination = $strCheminBase . $strFichierHashe;
              } else { //Documents supplémentaires
                if (strpos(sfConfig::get("app_extensions_bureau"), $strExt) === false && strpos(sfConfig::get("app_extensions_autres"), $strExt) === false) {
                  $message = "L'extension du fichier " . $arrinfos['fichier'] . " n'est pas autorisée.";
                  $this->logger->err($message);
                  $this->arrErreurs[] = $message;
                  continue;
                }
                $this->logger->info('Document joint ou lié trouvé');
                $utilPhp = new ServiceFichier();
                $objDocument = new Document_mris();
                $strSetTypeId = 'setType_document_' . $this->typeDossier . '_id';
                $strTypeTable = 'Type_document_' . $this->typeDossier . 'Table';
                $strSetDossierId = 'setDossier_' . $this->typeDossier . '_id';
                $objDocument->$strSetTypeId($strTypeTable::AUTRE);
                $objDocument->$strSetDossierId($objDossier->getId());
                $objDocument->setAutreType('Importé');
                if ($arrinfos['poids'] > $utilPhp->getMaxUploadSizeEnBytes()) {
                  $objDocument->setFichier($arrinfos['fichier']);
                  $objDocument->setFichierOrig($arrinfos['fichier']);
                  $objDocument->setEstJoint(false);
                  $strCheminDestination = sfConfig::get("app_documents_partages_dossier_" . $this->typeDossier . "_repertoire") . DIRECTORY_SEPARATOR . $objDossier->getNumeroAAfficher() . DIRECTORY_SEPARATOR . $arrinfos['fichier'];
                } else {
                  $objDocument->setFichier($strFichierHashe);
                  $objDocument->setFichierOrig($arrinfos['fichier']);
                  $objDocument->setEstJoint(true);
                  $strMethodeArbo = "getRepertoireDocumentsDossier" . ucfirst($this->typeDossier);
                  $strCheminDestination = $utilArbo->$strMethodeArbo($objDossier->getNumeroAAfficher()) . $arrinfos['fichier'];
                }
                try {
                  $objDocument->save();
                } catch (Exception $e) {
                  $msg = "Erreur de sauvegarde logique du fichier " . $arrinfos['fichier'];
                  $this->logger->err($msg);
                  $this->arrErreurs[] = $msg;
                }
              }
              if (!copy($strCheminComplet, $strCheminDestination)) {
                $msg = "Echec de copie du fichier " . $arrinfos['fichier'] . " vers " . $strCheminDestination;
                $this->logger->err($msg);
                $this->arrErreurs[] = $msg;
              }
            } else {
              $msg = "Le fichier " . $arrinfos['fichier'] . " n'a pas été trouvé dans le repertoire";
              $this->logger->err($msg);
              $this->arrErreurs[] = $msg;
            }
          }
        }
      }
      $objDossier->save();
    }
  }

  /**
   *  Cherche le type du dossier a parser et initialise la propriété interne $typeDossier, utilisée lors du parsing de ce dossier
   * @param SimpleXMLElement $xmlDossier
   * @return bool Si le type de dossier a été trouvé
   */
  protected function prepareParsing($xmlDossier) {
    if ($xmlDossier instanceof SimpleXMLElement) {
      $children = (array) $xmlDossier->children();
      $idTypeDossier = $children['type'];
      switch ($idTypeDossier) {
        case Type_dossier_mrisTable::TYPE_THESE:
          $this->typeDossier = "these";
          break;
        case Type_dossier_mrisTable::TYPE_POSTDOC:
          $this->typeDossier = "postdoc";
          break;
        case Type_dossier_mrisTable::TYPE_ERE:
          $this->typeDossier = "ere";
          break;
        default :
          $this->reportErreur("Type de dossier MRIS inconnu", true);
          return false;
      }
      $this->logger->info('Dossier_' . $this->typeDossier . ' trouvé.');
      return true;
    }
    return false;
  }

  /**
   * @param SimpleXMLElement $simpleXml contenu du fichier iXarm
   * @return array tableau des SimpleXMLElement représentant des dossiers
   */
  protected function listDossiersXml($simpleXml) {
    if ($simpleXml instanceof SimpleXMLElement) {
      $children = $simpleXml->children();

      $return = null;
    }
    //Recherche de tous les dossiers contenu dans le xml
    foreach ($children as $element => $value) {
      if ($value instanceof SimpleXMLElement && $element = 'dossier') {
        $return[] = $value;
      }
    }
    $this->logger->info(count($return) . " dossiers ont été trouvés dans le fichier ixarm");
    return $return;
  }

  /**
   * Methode fesant le gros du travail, parse chaque élément, injecte les informations dans l'objet en cours selon la configuration,
   * apelle la classe finder lorsque des relations sont détéctées, applique certaines règles métier
   * @param SimpleXMLElement $simpleXml element à parser
   * @param bool $boolDossier si on est en train de parser le niveau <dossier> du xml
   * @return null si erreur, rien sinon
   */
  protected function parseDataMris($simpleXml, $boolDossier = false) {

    $objReferentiel = null;
    $table = '';

    if ($simpleXml instanceof SimpleXMLElement) {

      //cas initial : l'objet est un dossier
      if ($boolDossier) {
        $table = 'Dossier_' . $this->typeDossier;
        $objReferentiel = new $table();
        $this->Ids = array();
        $this->profondeur = 0;

        if ($table == 'Dossier_these') {
          $objReferentiel->setTypeConventionOrganismeId(6);
          $objReferentiel->setStatutDossierTheseId(Statut_dossier_theseTable::PROPOSITION);
        }
      }
      // <editor-fold desc="Le noeud XML en cours est il un objet du référentiel">
      if (array_key_exists($simpleXml->getName(), $this->arrCorrespondancesTables)) {

        $table = $this->arrCorrespondancesTables[$simpleXml->getName()];

        if (strpos($table, '+') !== false) {
          //cas tables variables selon critèrs
          $arrTableComplexe = explode('+', $table);
          $table = $arrTableComplexe[0];
          $arrTableComplexe = explode(':', $arrTableComplexe[1]);

          //recupération de la propriété correspondant dans l'objet Parser
          $prop = $arrTableComplexe[0] . ucfirst($arrTableComplexe[1]);
          $table = $table . $this->$prop;
          if (isset($arrTableComplexe[2])) {
            $table = $table . $arrTableComplexe[2];
          }
        }

        if ($this->arrTablesDirectes[$table] != false) {
          $this->profondeur++;
          unset($this->Ids[$this->profondeur]);
        }

        //création de l'objet que l'on va tenter d'importer/lier
        $objReferentiel = new $table();

        $this->tempTableFils = $table;
        //Application de certaines règles métier
        if ($table == "Point_contact") {
          $objReferentiel->setMetierId(3);
        }
        if ($table == "Intervenant") {
          $objReferentiel->setEstResponsable(true);
        }
      }
      //</editor-fold>

      $this->logger->info('Objet ' . $table . " trouvé, tentative d'importation");

      $children = $simpleXml->children();

      // <editor-fold desc="objet simple">
      foreach ($children as $element => $value) {//Parsing des valeurs scalaires d'un objet
        if ($value instanceof SimpleXMLElement) {
          if ($objReferentiel != null) {//Recupération de l'equivalent GRID du champ xml
            if (isset($this->arrCorrespondancesChamps[$table][$element])) {
              $strChamp = $this->arrCorrespondancesChamps[$table][$element];
            } else {
              continue;
            }
          }
          $values = (array) $value->children();
          if (!count($values) > 0) {//On ne prends en compte que les champs scalaires pour commencer
            $value = (string) $value;
            if ($table != '' && $strChamp != '') {//le champ xml correspond à un champ dans la base
              if (strpos($strChamp, ' ')) { //cas enumération a rechercher
                $strChampComplexe = explode(' ', $strChamp);
                $value = $this->finder->tryFindOrBuildSimpleRelation($strChamp, $value);
                $strChamp = $strChampComplexe[0];
              }
              if ($value !== null) {
                if (strpos($strChamp, 'date') !== false) {
                  try {
                    $validator = new gridValidatorDate();
                    $value = $validator->clean($value);
                  } catch (sfValidatorError $er) {
                    $this->reportErreur("Date invalide trouvée");
                  }
                }
                $objReferentiel[$strChamp] = $value;
              } else {
                $objReferentiel[$strChamp] = null;
                $this->reportErreur("Erreur importation d'un champ relatif");
              }
            }
          }
        }
      }

      // </editor-fold>
      // <editor-fold desc="sauvegarde intermediaire">
      if ($objReferentiel !== null) {
        if (isset($this->Ids[$this->profondeur - 1])) {
          try { //Tentative d'injection d'Ids dans objets inclus
            $strChampId = strtolower($this->Ids[$this->profondeur - 1][1] . '_id');
            $objReferentiel[$strChampId] = $this->Ids[$this->profondeur - 1][0];
          } catch (Exception $ignoree) {

          }
        }
        $objReferentiel = $this->loadOrSave($objReferentiel, $boolDossier);


        //Si l'objet est invalide, on passe au suivant
        if ($objReferentiel === null) {
          $this->objDernierSauvegarde = null;
          if ($this->arrTablesDirectes[$table] !== false) {
            $this->profondeur--;
          }
          return null;
        }

        if ($objReferentiel->getId() != null) {
          $this->Ids[$this->profondeur] = array($objReferentiel->getId(), $table);
        }
      }
      // </editor-fold>
      $this->logger->info("Importation des relations");
      // <editor-fold desc="objets inclus et relations">
      foreach ($children as $element => $value) {//Parsing d'un objet
        if ($value instanceof SimpleXMLElement) {

          if ($objReferentiel !== null) {
            if (isset($this->arrCorrespondancesChamps[$table][$element])) {
              $strChamp = $this->arrCorrespondancesChamps[$table][$element];
            } else {
              continue;
            }
          }

          $values = (array) $value->children();


          if (count($values) > 0) { //cas value = objet ou collection
            $this->parseDataMris($value);
            if ($this->objDernierSauvegarde !== null) {
              if ($strChamp != '') { //cas objet interne correspondant à une table
                if (strpos($strChamp, ' ') !== false) {
                  $strRelation = '';
                  $relation = explode(" ", $strChamp);
                  if (strpos($relation[1], 'collection=') !== false) { //cas table intermediaire
                    $arrRelation = explode('=', $relation[1]);
                    $strRelation = $arrRelation[1];

                    $objRelation = new $strRelation();
                    $strSetUn = 'set' . get_class($objReferentiel);
                    $strSetDeux = 'set' . $relation[0];

                    try {
                      $objRelation->$strSetUn($objReferentiel);
                      $objRelation->$strSetDeux($this->objDernierSauvegarde);
                      $objRelation->save();
                    } catch (Exception $ex) {
                      $this->reportErreur("Echec de création d'une relation");
                    }
                  } else { //cas relation 1-n
                    $strRelation = $relation[0];

                    $objRelation = $objReferentiel->$strRelation;
                    $objRelation[] = $this->objDernierSauvegarde;
                  }
                } else {//cas objet simple
                  $objReferentiel[$strChamp] = $this->objDernierSauvegarde;
                }
              }
            }
          }
        }
      }
      // </editor-fold>


      if ($objReferentiel !== null) {
        if ($boolDossier) {
          $this->finaliseDossier($objReferentiel);
        }
        $this->loadOrSave($objReferentiel, $boolDossier);
        if ($this->arrTablesDirectes[$table] !== false) {
          $this->profondeur--;
        }
      }
    }
  }

  /**
   *  Applique quelques règles métiers et règles d'intégrité SQL pour finaliser l'importation du dossier
   * @param gridDoctrine_Record $objReferentiel dossier en fin de parsing
   */
  protected function finaliseDossier(gridDoctrine_Record $objReferentiel) {
    //Finalisation dossier -> ajout references dans tables de liaison
    $this->logger->info("Finalisation de l'importation du dossier_" . $this->typeDossier);
    foreach ($objReferentiel["Encadrant_" . $this->typeDossier] as $encadrant) {
      $strSet = 'setDossier_' . $this->typeDossier;
      $encadrant->$strSet($objReferentiel);
    }
    if ($this->typeDossier == 'these') {
      if ($objReferentiel['Cofinance_these']->count() > 0) {
        switch ($objReferentiel['Cofinance_these'][0]->getOrganisme()->getTypeOrganismeId()) {
          case Type_organismeTable::INDUSTRIEL:
            $objReferentiel->setTypeConventionOrganismeId(5);
            break;
          case Type_organismeTable::UNIVERSITAIRE:
            $objReferentiel->setTypeConventionOrganismeId(3);
            break;
          case Type_organismeTable::REGION:
            $objReferentiel->setTypeConventionOrganismeId(4);
            break;
          default:
            break;
        }
      }
    }
  }

  /**
   *  Méthode chargée de détécter la pré-existance des objets que l'on tente de sauvegarder, les mettre a jour si trouvés,
   * les créer sinon. Cette methode procède également à une validation des données
   * @param gridDoctrine_Record $objReferentiel objet du référentiel actuellement en mémoire (PAS en base)
   * @param bool $boolDossier si on est en train de parser le niveau <dossier> du xml
   * @return null si erreure, l'objet final ou intermédiaire mais présent en base.
   */
  protected function loadOrSave(gridDoctrine_Record $objReferentiel, $boolDossier = false) {
    $arrParamsRecherche = $this->arrParamsRecherches[get_class($objReferentiel)];
    $this->logger->info("Recherche de pré-éxistence de l'objet " . get_class($objReferentiel));

    $tempArrInfosObjet = $objReferentiel->toArray(false);

    $objEnBase = $this->finder->tryFindFullObject($objReferentiel, $arrParamsRecherche, $boolDossier);
    if ($objEnBase !== false) {
      $this->logger->info("Objet : " . get_class($objReferentiel) . "  Trouvé en base");
      $objEnBase = $this->mergeInformations($tempArrInfosObjet, $objReferentiel, $objEnBase);
      if ($objEnBase === null) {
        $this->objDernierSauvegarde = null;
        return null;
      }
    } else {
      $this->logger->info("Objet : " . get_class($objReferentiel) . " à créer");
      $objEnBase = $objReferentiel;
    }
    $table = get_class($objEnBase);

    if (($this->arrTablesDirectes[$table] !== false)) {
      $strValidator = "gridValidatorSchema" . $table;
      $objValidator = new $strValidator();
      $arrObjet = $objEnBase->toArray();
      if (!$arrObjet) {
        $this->objDernierSauvegarde = null;
        return null;
      }
      foreach ($objValidator->getFields() as $clef => $validateur) {
        try {//validation de l'objet
          if ($validateur->clean($arrObjet[$clef]) !== null) {
            $objEnBase[$clef] = $validateur->clean($arrObjet[$clef]);
          }
        } catch (sfValidatorError $err) {
          if ($err->getValidator()->getOption('required')) {
            $this->reportErreur("Champ requis non trouvé :" . $clef, $boolDossier);
            $this->objDernierSauvegarde = null;
            return null;
          } else {
            $objEnBase[$clef] = null;
          }
        }
      }
    }
    try {//sauvegarde
      if ($this->arrTablesDirectes[$table] === true) {
        $objEnBase->save();
        $this->logger->info("Objet sauvegardé");
      }
    } catch (Exception $ex) {
      $this->reportErreur("Erreur de sauvegarde :" . $ex->getMessage());
      $this->objDernierSauvegarde = null;
      return null;
    }
    $this->objDernierSauvegarde = $objEnBase;
    return $objEnBase;
  }

  /**
   *  Mets à jour un objet trouvé en base avec les informations de celui en mémoire
   * @param array $tempArrInfosObjet représentation array de l'objet en mémoire (nécéssaire a cause du fonctionnement doctrine)
   * @param gridDoctrine_Record $objReferentiel objet en mémoire
   * @param gridDoctrine_Record $objEnBase  objet trouvé en base
   * @return gridDoctrine_Record null si erreure, $objEnBase mis à jour sinon
   */
  protected function mergeInformations($tempArrInfosObjet, $objReferentiel, $objEnBase) {
    $this->logger->info("Fusion des informations de l'objet");
    foreach ($this->arrCorrespondancesChamps[get_class($objReferentiel)] as $strChamp) {
      if (strpos($strChamp, ' ')) { //cas complexe
        $strChampComplexe = explode(' ', $strChamp);
        if (strpos($strChampComplexe[1], 'collection') !== false) {
          $strChamp = $strChampComplexe[0];
          if (strpos($strChampComplexe[1], '=') !== false) {
            continue;
            $arrRelation = explode('=', $strChampComplexe[1]);
            $strChamp = $arrRelation[1];
          }
          $collection = $objReferentiel[$strChamp];

          $strRelation = $objEnBase->$strChamp;
          foreach ($collection as $obj) {
            $strRelation[] = $obj;
          }
        } else {
          $strChamp = $strChampComplexe[0];
        }
      }//cas simple
      if (isset($objReferentiel[$strChamp])) {
        $objEnBase[$strChamp] = $objReferentiel[$strChamp];
      }//mis a jour des champs depuis array ($objReferentiel s'update lors de la requête, on repasse donc les infos originelles)
      if (isset($tempArrInfosObjet[$strChamp])) {
        $objEnBase[$strChamp] = $tempArrInfosObjet[$strChamp];
      }
    }
    try {
      $objEnBase->save();
      $this->logger->info("Objet mis à jour");
    } catch (Exception $ex) {
      $this->reportErreur("Erreur de mise à jour de l'objet :" . $ex->getMessage());
      return null;
    }
    return $objEnBase;
  }

  /**
   * Log une erreure avec des informations sur le moment de son arrivée, ajoute également cette erreure dans le tableau d'erreurs final.
   * @param string $message message à logger
   * @param bool $boolEstFatale si l'erreure loggée empêche l'importation d'un dossier
   */
  protected function reportErreur($message, $boolEstFatale = false) {
    if ($boolEstFatale) {
      $message = "Erreur fatale: " . $message;
    } else {
      $message = $message . " à: ";
      for ($i = 0; $i < $this->profondeur; $i++) {
        if (isset($this->Ids[$i])) {
          $message = $message . "/" . $this->Ids[$i][1] . "(" . Doctrine_core::getTable($this->Ids[$i][1])->findOneById($this->Ids[$i][0]) . ")";
        }
      }
      $message = $message . '/' . $this->tempTableFils;
    }
    $this->logger->err($message);
    if (strpos($message, 'SQLSTATE') !== false) {
      $this->arrErreurs[] = $message;
    }
  }

}

?>
