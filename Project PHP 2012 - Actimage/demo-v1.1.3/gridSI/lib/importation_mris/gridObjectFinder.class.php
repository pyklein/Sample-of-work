<?php

/**
 * Classe chargée de retrouvé des objets potentiellement déjà en base lors de l'importation
 *
 * @author William
 */
class gridObjectFinder {

  private $logger;


  public function __construct(sfLogger $logger) {
    $this->logger = $logger;
  }

  /**
   *  Recherche un objet complet dans le referentiel
   * @param Doctrine_Record $objReferentiel
   * @param array $arrParams  parametres de la recherche (trouvés dans le fichier de config import MRIS)
   * @return l'objet trouvé, false sinon
   */
  public function tryFindFullObject(Doctrine_Record $objReferentiel, $arrParams) {
                       
    $objResultat = $this->RechercherExistantFullObjet($objReferentiel, $arrParams);

    if ($objResultat->count() === 1) {
      return $objResultat[0];
    } else {
      return false;
    }
  }

  /**
   *  Recherche des objets simples (généralement enums GRID) pour les relations n-1, les crée si cela est possible (spécifié dans le fichier de conf)
   * @param String $strChampComplexe valeure trouvée dans le fichier de conf
   * @param mixed $value valeure trouvée dans le xml correspondant au champ décrit dans le fichier de conf
   * @return objet trouvé ou nouvel objet si sa création est possible, null sinon
   */
  public function tryFindOrBuildSimpleRelation($strChampComplexe, $value) {
    //recupération des parametres
    $arrParametreRecherche = explode(" ", $strChampComplexe);
    $strTableRecherche = $arrParametreRecherche[0];
    $boolPeutConstuire = $arrParametreRecherche[1] == 'dynamique';

    $objReferentiel = null;
    $strArrRecherche = array();

    foreach ($arrParametreRecherche as $pos => $param) {
      //récupération options de recherche (prends en compte arguments > 3)
      if (strpos($param, '=') != false && (!in_array($pos, array(0, 1)))) {
        $option = explode('=', $param);
        $strArrRecherche[$option[0]] = $option[1];
      }
    }

    $objResultat = $this->RechercherExistantSimple($strTableRecherche, $strArrRecherche, $value);

    if ($objResultat->count() === 1) {
      return $objResultat[0];
    } else {
      if ($objResultat->count() === 0) { //cas non trouvé
        if ($boolPeutConstuire) { //cas enumération simple dynamique
          $objReferentiel = new $strTableRecherche();
          foreach ($strArrRecherche as $champ => $comparaison) {
            $objReferentiel[$champ] = $value;
          }
          if ($objReferentiel->trySave()) {
            return $objReferentiel;
          } else {
            $this->logger->err("Erreur de sauvegarde :" . $ex->getMessage());
          }
        }
        $this->logger->err("Relation par champ unique impossible, la valeure ne corresponds pas à l'énumération statique GRID :" . $strTableRecherche . " -> " . $value);
        return null;
      }
    }
  }

  /**
   * Methode créant et executant la requête de recherche
   * @param Doctrine_Record $objReferentiel
   * @param array $arrParams  parametres de la recherche (trouvés dans le fichier de config import MRIS)
   * @return Doctrine_collection resultat de la requête
   */
  protected function RechercherExistantFullObjet(Doctrine_Record $objReferentiel, $arrParams) {
     
    if ($arrParams == null) {
      return new Doctrine_collection(get_class($objReferentiel));
    }
    
    $query = Doctrine_Core::getTable(get_class($objReferentiel))->createQuery('o');
    foreach ($arrParams as $champ => $comparaison) {
      if ($objReferentiel[$champ] !== null) {
        switch ($comparaison) {
          case 'identique':
            $query = $query->andWhere('o.' . $champ . ' = ?', $objReferentiel[$champ]);
            break;
          case 'like':
            $query = $query->andWhere('o.' . $champ . ' LIKE ?', $objReferentiel[$champ]);
            break;
        }
      }
    }
    return $query->execute();
  }

  /**
   * Methode créant et executant la requête de recherche
   * @param string $strModele Nom du modèle à rechercher
   * @param array $arrRecherche  champs sur lequel rechercher et indicateur like/= (trouvés dans le fichier de config import MRIS)
   * @param mixed $value valeure recherchée
   * @return Doctrine_collection resultat de la requête
   */
  protected function RechercherExistantSimple($strModele, $arrRecherche, $value) {
    $query = Doctrine_Core::getTable($strModele)->createQuery('o');
    foreach ($arrRecherche as $champ => $comparaison) {
      switch ($comparaison) {
        case 'identique':
          $query = $query->andWhere('o.' . $champ . ' = ?', $value);
          break;
        case 'like':
          $query = $query->andWhere('o.' . $champ . ' LIKE ?', $value);
          break;
      }
    }
    return $query->execute();
  }

}

?>
