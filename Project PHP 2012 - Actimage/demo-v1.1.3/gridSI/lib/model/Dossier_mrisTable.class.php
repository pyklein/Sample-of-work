<?php

/**
 * Description of Dossier_mrisTable
 *
 * @author William
 */
abstract class Dossier_mrisTable extends Doctrine_Table {

  /**
     *  Fourni des représentants cannoniques pour les années de création (widget Année Filtre)
     * @return DoctrineCollection liste des dossiers représentants canoniques
     *                            des années de création présentes en base
     * Auteur : Actimage, WilliamR
     */
  public function getAnneesDossiers() {
    $objRequeteDoctrine = $this->createQuery()->orderBy('created_at DESC');
    $arrDossiers = $objRequeteDoctrine->execute();
    $arrAnnees = array();
    $arrDossiersCanon = new Doctrine_Collection($this->getTypeDossier());


    //recupération de l'année et ajout dans liste des années / liste canonique selon présence
    foreach ($arrDossiers as $objDossier) {
      $annee = $objDossier->getDateTimeObject('created_at')->format('Y');
      if (!in_array($annee, $arrAnnees)) {
        $arrAnnees[] = $annee;
        $arrDossiersCanon->add($objDossier);
      }
    }
    return $arrDossiersCanon;
  }

  /**
   *  Ajoute le filtre par annee à la requête de recherche
   * @param Doctrine_Query  $objRequeteDoctrine   requête envoyée par le filtre
   * @param Id               $id                  Id du dossier Canon pour l'année choisie
   * @return Doctrine_Query                       requête retournée au filtre
   * Auteur : William RICHARDS
   */
  public function appliquerFiltreAnnee(Doctrine_Query $objRequeteDoctrine, $id) {
    $rootAlias = $objRequeteDoctrine->getRootAlias();
    $objDossier = $this->findOneById($id);
    if ($objDossier != false) {
      $annee = $objDossier->getDateTimeObject('created_at')->format('Y');
      $objRequeteDoctrine->andWhere($rootAlias . '.created_at >= ?', $annee . '-01-01 00:00:00');
      $objRequeteDoctrine->andWhere($rootAlias . '.created_at <= ?', $annee + 1 . '-01-01 00:00:00');
    }
    return $objRequeteDoctrine;
  }

  /**
   *  Ajoute le filtre par nom/prénom/email des innovateurs dans la requête de recherche des dossiers
   * @param Doctrine_Query      $objRequeteDoctrine   requête envoyée par le filtre
   * @param string              $strValeure           string a rechercher
   * @return Doctrine_Query                           requête retournée au filtre
   * Auteur : William RICHARDS, Actimage
   */
  public function appliquerFiltreNomPrenomEmail(Doctrine_Query $objRequeteDoctrine, $strValeure) {
    $rootAlias = $objRequeteDoctrine->getRootAlias();

    $objRequeteDoctrine->innerJoin($rootAlias . '.Etudiant e')
            ->andWhere('(e.nom LIKE ?', '%' . $strValeure . '%')
            ->orWhere('e.prenom LIKE ?', '%' . $strValeure . '%')
            ->orWhere('e.email LIKE ?' . ')', '%' . $strValeure . '%');
    return $objRequeteDoctrine;
  }

  /**
   *  Ajoute le filtre par nom/prénom/email des etudiants dans la requête de recherche des dossiers
   * @param Doctrine_Query      $objRequeteDoctrine   requête envoyée par le filtre
   * @param string              $strValeure           string a rechercher
   * @return Doctrine_Query                           requête retournée au filtre
   * Auteur : Alexandre WETTA
   */
  public function appliquerFiltreEtudiant(Doctrine_Query $objRequeteDoctrine, $strValeure) {
    return $this->appliquerFiltreNomPrenomEmail($objRequeteDoctrine, $strValeure);
  }

  /**
   * Ajoute le filtre des laboratoires pour la recherche des dossiers
   *
   * @param Doctrine_Query $objRequeteDoctrine
   * @param string $id Id du laboratoire
   * @author Alexandre WETTA
   */
  public function appliquerFiltreLaboratoire(Doctrine_Query $objRequeteDoctrine, $id) {
    $rootAlias = $objRequeteDoctrine->getRootAlias();

    $typeDossier = $this->getTypeDossier();
    if ($typeDossier == 'Dossier_these') {
      $strTypeDossier = 'these';
    } else if ($typeDossier == 'Dossier_postdoc') {
      $strTypeDossier = 'postdoc';
    } else if ($typeDossier == 'Dossier_ere') {
      $strTypeDossier = 'ere';
    }

    $objRequeteDoctrine->innerJoin($rootAlias . '.Dossier_' . $strTypeDossier . '_laboratoire l')
            ->andWhere('l.laboratoire_id = ?', $id)
    ;
    return $objRequeteDoctrine;
  }

  /**
   * Ajoute le filtre des régions des laboratoires
   *
   * @param Doctrine_Query $objRequeteDoctrine
   * @param string $id Id de la région
   * @author Alexandre WETTA
   */
  public function appliquerFiltreRegionLaboratoire(Doctrine_Query $objRequeteDoctrine, $id) {
    $rootAlias = $objRequeteDoctrine->getRootAlias();

    $typeDossier = $this->getTypeDossier();
    if ($typeDossier == 'Dossier_these') {
      $arrDossierId = Dossier_these_laboratoireTable::getInstance()->retrieveDossierTheseByRegion($id);
    } else if ($typeDossier == 'Dossier_postdoc') {
      $arrDossierId = Dossier_postdoc_laboratoireTable::getInstance()->retrieveDossierPostdocByRegion($id);
    } else if ($typeDossier == 'Dossier_ere') {
      $arrDossierId = Dossier_ere_laboratoireTable::getInstance()->retrieveDossierEreByRegion($id);
    }


    if ($arrDossierId != null) {
      $objRequeteDoctrine->andWhereIn($rootAlias . '.id', $arrDossierId);
    } else {
      $objRequeteDoctrine->andWhere($rootAlias . '.id IS NULL');
    }

    return $objRequeteDoctrine;
  }

  /**
   *  Ajoute le filtre des encadrant
   * @param Doctrine_Query      $objRequeteDoctrine   requête envoyée par le filtre
   * @param string              $strValeure           string a rechercher
   * @return Doctrine_Query                           requête retournée au filtre
   * Auteur : Alexandre WETTA
   */
  public function appliquerFiltreEncadrant(Doctrine_Query $objRequeteDoctrine, $strValeure) {
    $rootAlias = $objRequeteDoctrine->getRootAlias();

    $typeDossier = $this->getTypeDossier();
    if ($typeDossier == 'Dossier_these') {
      $strTypeDossier = 'these';
    } else if ($typeDossier == 'Dossier_postdoc') {
      $strTypeDossier = 'postdoc';
    } else if ($typeDossier == 'Dossier_ere') {
      $strTypeDossier = 'ere';
    }

    $objRequeteDoctrine->innerJoin($rootAlias . '.Encadrant_' . $strTypeDossier . ' c')
            ->innerJoin('c.Intervenant i')
            ->andWhere('(i.nom LIKE ?', '%' . $strValeure . '%')
            ->orWhere('i.prenom LIKE ?', '%' . $strValeure . '%')
            ->orWhere('i.email LIKE ?' . ')', '%' . $strValeure . '%');
    return $objRequeteDoctrine;
  }

  /**
   * Ajoute le filtre titre dans la requête de recherche des dossiers
   * @param Doctrine_Query      $objRequeteDoctrine   requête envoyée par le filtre
   * @param string              $strValeure           string a rechercher
   * @param string              $strOperateur         operateur
   * @return Doctrine_Query                           requête retournée au filtre
   * @author Gabor JAGER
   */
  public function appliquerFiltreTitre(Doctrine_Query $objRequeteDoctrine, $strValeure, $strOperateur) {
    $rootAlias = $objRequeteDoctrine->getRootAlias();

    $strValeure = str_replace("  ", " ", trim($strValeure));
    $arrValeurs = explode(" ", $strValeure);

    $strSql = "";
    foreach ($arrValeurs as $strVal) {
      $strSql .= ( $strSql == "" ? "" : $strOperateur) . " titre LIKE '%" . $strVal . "%' ";
    }

    $strSql = "(" . $strSql . ")";

    $objRequeteDoctrine->andWhere($strSql);

    return $objRequeteDoctrine;
  }

  /**
   *  Filtre la requête d'affichage des dossiers MRIS en fonction des credentials (COR-MRIS)
   * @param Doctrine_Query $objRequeteDoctrine  requête envoyée par le filtre
   * @param myUser         $objUtilisateur      utilisateur courant
   * @return Doctrine_Query                     requête finale
   * @author Alexandre WETTA
   */
  public function getRequeteListeParUtilisateur(Doctrine_Query $objRequeteDoctrine, myUser $objUtilisateur) {
    $strRootAlias = $objRequeteDoctrine->getRootAlias();

    //si l'utilisateur est seulement correspondant MRIS
    if ($objUtilisateur->hasCredential('COR-MRIS') && !$objUtilisateur->hasCredential('SUP-BPI') && !$objUtilisateur->hasCredential('USR-BPI')) {
      $objRequeteDoctrine->andWhere($strRootAlias . '.organisme_mindef_id = 2');
    }
    return $objRequeteDoctrine;
  }

  /**
   * Cherche les dossiers actifs avec un statut "Validé" de l'année de la commission et de l'année suivante
   * en fonction d'un domaine scientifique
   * @param String $anneeCommission L'année de la commission(format 'Y')
   * @param Integer $domaineScId  L'id du domaine scientifique
   * @return Requete doctrine
   * Auteur : Actimage
   */
  protected function retrieveDossierMRISValideByDomaineScientifiqueId($domaineScId, $anneeCommission, $constStatutValide) {

    $objRequeteDoctrine = $this->createQuery('d');
    $objRequeteDoctrine->where('d.created_at <= ?', $anneeCommission + 1 . '-01-01 00:00:00')
            ->andWhere('d.est_actif = 1')
            ->andWhere('d.domaine_scientifique_id = ?', $domaineScId)
            ->andWhere('d.statut_' . strtolower($this->getTypeDossier()) . '_id = ?', $constStatutValide)
            ->orderBy('d.created_at DESC');

    return $objRequeteDoctrine;
  }

  /**
   * Cherche les dossiers actifs avec un statut "Proposition" de l'année de la commission et de l'année suivante
   * en fonction d'un domaine scientifique
   * @param String $anneeCommission L'année de la commission(format 'Y')
   * @param String $dateCommission La date de la commission (format 'Y-m-d')
   * @param Integer $domaineScId  L'id du domaine scientifique
   * @return Requete Doctrine
   * Auteur : Actimage
   */
  protected function retrieveDossierMRISPropositionByDomaineScientifiqueId($domaineScId, $anneeCommission, $dateCommission, $constStatutProposition) {

    $objRequeteDoctrine = $this->createQuery('d');
    $objRequeteDoctrine->where('d.created_at >= ?', $anneeCommission - 1 . '-01-01 00:00:00')
            ->andWhere('d.created_at <= ?', $dateCommission . ' 00:00:00')
            ->andWhere('d.est_actif = 1')
            ->andWhere('d.domaine_scientifique_id = ?', $domaineScId)
            ->andWhere('d.statut_' . strtolower($this->getTypeDossier()) . '_id = ?', $constStatutProposition)
            ->orderBy('d.created_at DESC');

    return $objRequeteDoctrine;
  }

  protected function retrieveDossierMRISParStatutParOrganismeId($intOrganismeId, $constStatut) {
    $objRequeteDoctrine = $this->createQuery('d')
                    ->where('d.est_actif = 1')
                    ->andWhere('d.organisme_id = ?', $intOrganismeId)
                    ->andWhere('d.statut_' . strtolower($this->getTypeDossier()) . '_id = ?', $constStatut);

    return $objRequeteDoctrine;
  }

  protected function retrieveDossierMRISParOrganismeId($intOrganismeId) {
    $objRequeteDoctrine = $this->createQuery('d')
                    ->where('d.est_actif = 1')
                    ->andWhere('d.organisme_id = ?', $intOrganismeId);

    return $objRequeteDoctrine;
  }

  /**
   * Cherche les Id des organismes des dossiers
   */
  public function getOrganismeParDossier() {
    $arrOrganimesDossiers = array();
    $arrDossiersActifs = $this->createQuery('d')
                    ->where('d.est_actif = 1')->execute();

    if ($arrDossiersActifs->count() > 0) {
      foreach ($arrDossiersActifs as $objDossier) {
        if (!in_array($objDossier->getOrganismeId(), $arrOrganimesDossiers)) {
          $arrOrganimesDossiers[] = $objDossier->getOrganismeId();
        }
      }
    }

    return $arrOrganimesDossiers;
  }

  public function getDomaineScientifiqueDossier() {
    $arrDomaineScientifiqueDossiers = array();
    $arrDossiersActifs = $this->createQuery('d')
                    ->where('d.est_actif = 1')->execute();

    if ($arrDossiersActifs->count() > 0) {
      foreach ($arrDossiersActifs as $objDossier) {
        if (!in_array($objDossier->getDomaineScientifiqueId(), $arrDomaineScientifiqueDossiers)) {
          $arrDomaineScientifiqueDossiers[] = $objDossier->getDomaineScientifiqueId();
        }
      }
    }

    return $arrDomaineScientifiqueDossiers;
  }

  /**
   *  getCountsByX retourne une array('clef' => 'compte') donnant le nombre de dossier par clef
   *  getCountByX  retourne le compte correspondant au nombre de dossiers selon une condition
   * @param Doctrine_Query $objRequeteDoctrine Requête donnée par le filtre statistique donnant la liste de dossiers
   *                                           sur laquelle les statistique doivent être faites
   * @return array voir ci-dessus
   *
   * @author Jihad SAHEBDIN
   */
  public function getCountsByOrigine(Doctrine_Query $objRequeteDoctrine = null) {
    $arrResults = array();
    foreach (Type_cursusTable::getInstance()->findAll() as $objCursus) {
      $arrResults[$objCursus->getIntitule()] = $this->getCountByOrigine($objCursus->getId(), $objRequeteDoctrine);
    }
    return $arrResults;
  }

  protected function getCountByOrigine($intId, Doctrine_Query $objRequeteDoctrine = null) {
    if ($objRequeteDoctrine == null) {
      $objRequeteDoctrine = $this->createQuery();
    }
    $rootAlias = $objRequeteDoctrine->getRootAlias();

    $result = clone $objRequeteDoctrine;
    $result->leftJoin($rootAlias . '.Etudiant e')
            ->andWhere('e.type_cursus_id = ' . $intId);

    return $result->execute()->count();
  }

  public function getCountsByRegion(Doctrine_Query $objRequeteDoctrine = null) {
    $arrResults = array();
    foreach (RegionTable::getInstance()->findAll() as $objRegion) {
      $arrResults[$objRegion->getIntitule()] = $this->getCountByRegion($objRegion->getId(), $objRequeteDoctrine);
    }
    return $arrResults;
  }

  protected function getCountByRegion($intId, Doctrine_Query $objRequeteDoctrine = null) {
    if ($objRequeteDoctrine == null) {
      $objRequeteDoctrine = $this->createQuery();
    }
    $rootAlias = $objRequeteDoctrine->getRootAlias();

    $result = clone $objRequeteDoctrine;
    $arrDossierFiltrer = $result->execute();

    $arrIdDossiersFiltrer = array();

    if ($arrDossierFiltrer->count() > 0) {
      foreach ($arrDossierFiltrer as $objDossier) {
        if (!in_array($objDossier->getId(), $arrIdDossiersFiltrer)) {
          $arrIdDossiersFiltrer[] = $objDossier->getId();
        }
      }
    }

    $strTableLiasion = $this->getTypeDossier() . "_laboratoireTable";
    $strMethodeTableLiaison = "retrieveDossier" . ucfirst(str_replace("Dossier_", "", $this->getTypeDossier())) . "ByRegion";
    $arrDossierParRegion = call_user_func($strTableLiasion.'::getInstance')->$strMethodeTableLiaison($intId);

    $arrResult = array();

    if (count($arrDossierParRegion) > 0) {
      foreach ($arrDossierParRegion as $intIdDossierParRegion) {
        if (in_array($intIdDossierParRegion, $arrIdDossiersFiltrer) && !in_array($intIdDossierParRegion, $arrResult)) {
          $arrResult[] = $intIdDossierParRegion;
        }
      }
    }

    return count($arrResult);
  }

  public function getCountsByOrganisme(Doctrine_Query $objRequeteDoctrine = null) {
    $arrResults = array();
    foreach (OrganismeTable::getInstance()->getOrganismesAAfficher($this->getTypeDossier()) as $organisme) {
      $arrResults[$organisme->getIntitule()] = $this->getCountByOrganisme($organisme->getId(), $objRequeteDoctrine);
    }
    return $arrResults;
  }

  protected function getCountByOrganisme($intId, Doctrine_Query $objRequeteDoctrine = null) {
    if ($objRequeteDoctrine == null) {
      $objRequeteDoctrine = $this->createQuery();
    }
    $rootAlias = $objRequeteDoctrine->getRootAlias();

    $result = clone $objRequeteDoctrine;
    $result->andWhere($rootAlias . '.organisme_id = ?', $intId);

    return $result->execute()->count();
  }

  public function getCountsByDomaineScientifique(Doctrine_Query $objRequeteDoctrine = null) {
    $arrResults = array();
    foreach (Domaine_scientifiqueTable::getInstance()->findAll() as $objDomaineScientifique) {
      $arrResults[$objDomaineScientifique->getIntitule()] = $this->getCountByDomaineScientifique($objDomaineScientifique->getId(), $objRequeteDoctrine);
    }
    return $arrResults;
  }

  protected function getCountByDomaineScientifique($intId, Doctrine_Query $objRequeteDoctrine = null) {
    if ($objRequeteDoctrine == null) {
      $objRequeteDoctrine = $this->createQuery();
    }
    $rootAlias = $objRequeteDoctrine->getRootAlias();

    $result = clone $objRequeteDoctrine;
    $result->andWhere($rootAlias . '.domaine_scientifique_id = ?', $intId);

    return $result->execute()->count();
  }

}

?>
