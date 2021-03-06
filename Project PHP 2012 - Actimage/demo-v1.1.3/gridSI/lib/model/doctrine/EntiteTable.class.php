<?php

/**
 * EntiteTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class EntiteTable extends Doctrine_Table {

  /**
   * Returns an instance of this class.
   *
   * @return EntiteTable
   */
  public static function getInstance() {
    return Doctrine_Core::getTable('Entite');
  }

  /**
   * Recupere un entité actif par son ID
   * @param string $intId identifiant de l'objet
   * @return Entite objet trouvé ou null
   * @author Gabor JAGER
   */
  public function getEntiteActifById($intId)
  {
    $objEntite = $this->createQuery()
                      ->where("id = ?", $intId)
                      ->andWhere("est_actif = 1")
                      ->execute();
    $objEntite = count($objEntite) > 0 ? $objEntite[0] : null;
    return $objEntite;
  }

  /**
   * Retourne les entites de la base par ordre ascendant
   *
   * @param boolean $getInactifAussi Indique si on doit recupere les entités inactifs
   * @return  array Un array d'objets Entites
   *
   * @author Simeon PETEV
   */
  public function getEntitesTrieAsc($getInactifAussi=false) {
    if (sfContext::hasInstance())
      sfContext::getInstance()->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    $q = Doctrine_Query::create()
                    ->from("Entite e")
                    ->where("e.est_actif = 1")
                    ->orderBy("e.intitule ASC");

    if ($getInactifAussi) {
      $q = Doctrine_Query::create()
                      ->from("Entite e")
                      ->orderBy("e.intitule ASC");
    }

    if (sfContext::hasInstance())
      sfContext::getInstance()->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");

    return $q->execute();
  }
 
  /**
   * Retourne la requette qui recupere les entite triés par ordre ascendant de
   * leur libelle ET du libelle des Organismes_mindes auquels ils sont depandants
   *
   * @param boolean $getInactifAussi Indique si on doit recupere les entités inactifs
   * @return  object Un Query
   *
   * @author Simeon PETEV
   */
  public function getQueryEntitesTrieAscPourSelectBox($getInactifAussi=false) {
    if (sfContext::hasInstance())
      sfContext::getInstance()->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    //On retourne tous les entité, mais triés
    if ($getInactifAussi)
    {
      $q = Doctrine_Query::create()
                      ->select("e.id, e.intitule")
                      ->from("Entite e, Organisme_mindef om")
                      ->whereNotIn("e.id", array(0))
                      ->addWhere("e.organisme_mindef_id = om.id")
                      ->addOrderBy("om.intitule ASC")
                      ->addOrderBy("e.intitule ASC")
      ;

      if (sfContext::hasInstance())
      sfContext::getInstance()->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");

      return $q;
    }

    //Les entites qui n'ont pas d'autres entites comme pere
    $arrEntitesRoots = $this->getQueryObject()
                                    ->where('entite_id IS NULL')
                                    ->orWhere('entite_id = ""')
                                    ->execute();

    $arrIdsEntitesListables = array();

    foreach ($arrEntitesRoots as $objEntiteRoot) {
      $arrIdsEntitesListables = array_merge($arrIdsEntitesListables, $objEntiteRoot->getIdsSousEntites($getInactifAussi,array()));
    }

    if (empty($arrIdsEntitesListables)) {
      $arrIdsEntitesListables[] = 0;
    }

    $q = Doctrine_Query::create()
                    ->select("e.id, e.intitule")
                    ->from("Entite e, Organisme_mindef om")
                    ->whereIn("e.id", $arrIdsEntitesListables)
                    ->addWhere("e.organisme_mindef_id = om.id")
                    ->andWhere("om.est_actif = 1")
                    ->addOrderBy("om.intitule ASC")
                    ->addOrderBy("e.intitule ASC")
    ;
    
    if (sfContext::hasInstance())
      sfContext::getInstance()->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");

    return $q;
  }

  /**
   * Retourne la requette qui recupere les entite executsnts triés par ordre ascendant de
   * leur libelle ET du libelle des Organismes_mindes auquels ils sont depandants
   *
   * @param boolean $getInactifAussi Indique si on doit recupere les entités inactifs
   * @return  object Un Query
   *
   * @author Simeon PETEV
   */
  public function getQueryEntitesExecutantTrieAscPourSelectBox($getInactifAussi=false)
  {
    if (sfContext::hasInstance())
      sfContext::getInstance()->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    $objQuery = $this->getQueryEntitesTrieAscPourSelectBox();
    $objQuery = $objQuery->andWhere('est_executant = 1');

    if (sfContext::hasInstance())
      sfContext::getInstance()->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
    
    return $objQuery;
  }

  /**
   * Recupere les entites feuilles - qui ne dominent personne
   *
   * @param boolean $getInactifAussi - Indique si on doit recupere les entités inactifs
   * @return array - Un array d'entités
   *
   * @author Simeon PETEV
   */
  public function getEntitesFeuillesTrieAsc($getInactifAussi=false) {
    if (sfContext::hasInstance())
      sfContext::getInstance()->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    $q = Doctrine_Query::create()
                    ->from("Entite e")
                    ->orderBy("e.intitule ASC");


    $arrInstances = $q->execute();
    $arrCibles = array();

    foreach ($arrInstances as $entite) {
      if (($entite->getEntite() != null) && ($entite->getEntite()->getId() != null)) {
        $arrCibles[] = $entite->getEntite()->getId();
      }
    }

    $qRes = Doctrine_Query::create()
                    ->from("Entite e")
                    ->where("e.est_actif = 1")
                    ->andWhereNotIn("e.id", $arrCibles)
                    ->orderBy("e.intitule ASC");

    if ($getInactifAussi) {
      $qRes = Doctrine_Query::create()
                      ->from("Entite e")
                      ->whereNotIn("e.id", $arrCibles)
                      ->orderBy("e.intitule ASC");
    }

    if (sfContext::hasInstance())
      sfContext::getInstance()->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");

    return $qRes->execute();
  }

  /**
   * Verifie si un entité d'affectation fait partie d'un organisme Mindef
   *
   * @param integer $idEntite Identifiant entité d'affectation
   * @param integer $idOrganismeMindef Identifiant Organisme Mindef
   * @return boolean
   *
   * @author Simeon PETEV
   */
  public function estCompatibleEntiteAvecOrganismeMindef($idEntite, $idOrganismeMindef) {
    if (sfContext::hasInstance())
      sfContext::getInstance()->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    $objQuery = $this->getQueryObject()
                    ->where("id" . " = ?", $idEntite)
                    ->andWhere("organisme_mindef_id" . " = ?", $idOrganismeMindef);


    if (sfContext::hasInstance())
      sfContext::getInstance()->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");

    return ($objQuery->count() > 0) ? true : false;
  }

  /**
   * Permet de récuperer un tableau de l'organisme Mindef
   * @param integer[] $arrEntiteIds Id des entités
   * @return Entite[]
   * @author Gabor JAGER
   */
  public function getEntites($arrEntiteIds)
  {
    if (sfContext::hasInstance())
    {
      sfContext::getInstance()->getLogger()->debug('EntiteTable->getEntites() Start');
    }

    if (count($arrEntiteIds) == 0)
    {
      return array();
    }

    $objQuery = $this->getQueryObject()
                    ->whereIn("id", $arrEntiteIds);

    $arrResultat = $objQuery->execute();
    $arrRetour = array();
    foreach($arrResultat as $objEntite)
    {
      $arrRetour[$objEntite->getId()] = $objEntite;
    }

    if (sfContext::hasInstance())
    {
      sfContext::getInstance()->getLogger()->debug('EntiteTable->getEntites() Fin');
    }

    return $arrRetour;
  }

  /**
   * Permet de récalculer (récursivement) le champ "parents"
   * @return string au forat id;id;...;id pour asc et id,...,id pour desc
   * @author Gabor JAGER
   * @update Julien GAUTIER
   * @update Simeon PETEV
   */
  public function calculerParents($intEntiteId, $ord = "asc")
  {
    if (!$intEntiteId || $intEntiteId == "" || !is_numeric($intEntiteId))
    {
      return null;
    }

    $objEntite = $this->findOneById($intEntiteId);

    if ($objEntite == null || $objEntite->getId() == "" || $objEntite->getId() == null)
    {
      return $intEntiteId;
    }
    
    $strParents = $intEntiteId;
    $objParent = $objEntite->getEntite();

    while($objParent->getId() != "")
    {
      if ($ord == "asc") 
         $strParents .= ($strParents == "" ? "" : ";").$objParent->getId();
      else
          $strParents = $objParent->getId(). ($strParents == "" ? "" : ",") . $strParents;
      $objParent = $objParent->getEntite();
    }

    return $strParents;
  }

  /**
   * Verifie si un entite d'affectation et un grade sont compatibles par rapprt
   * à ses Organismes MINDEF
   *
   * @param integer $idEntite Identifiant de l'entite
   * @param integer $idGrade Identifiant du grade
   * @return boolean 
   *
   * @author Simeon PETEV
   */
  public function estCompatibleEntiteAvecGrade($idEntite, $idGrade) {
    if (sfContext::hasInstance())
      sfContext::getInstance()->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    $objQuery = Doctrine_Query::create()
                    ->select("e." . "id")
                    ->from("Entite e")
                    ->addFrom("Grade g")
                    ->where("e." . "id" . " = ?", $idEntite)
                    ->andWhere("g." . "id" . " = ?", $idGrade)
                    ->andWhere("e." . "organisme_mindef_id" . " = g." . "organisme_mindef_id");

    if (sfContext::hasInstance())
      sfContext::getInstance()->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");

    return ($objQuery->count() > 0) ? true : false;
  }

  /**
   * Retourne les entites en fonction d'un ID d'un intitulé
   *
   * @return DoctrineCollection
   * Auteurs: Actimage
   */
  public function retrieveEntiteByEntiteId($id) {
    $requete = $this->createQuery()
                    ->where('entite_id = ?', $id)
                    ->orderBy('intitule');
    return $requete->execute();
  }

   /**
   * Retourne les entites pour le selectbox de création/modification d'entité
   *
   * @author Actimage
   */
  public function retrieveEntiteFiltre($objRequeteDoctrine = null){

    if ($objRequeteDoctrine == null){
        $objRequeteDoctrine = $this->createQuery();
      }
      $rootAlias = $objRequeteDoctrine->getRootAlias();

      return $objRequeteDoctrine->orderBy('intitule');
    
  }

  /**
   * Retourne les entites en fonction d'un entite ID OU ID
   *
   * @return DoctrineCollection
   * Auteurs: Actimage
   */
  public function retrieveEntiteByEntiteIdOrId($id) {
    $requete = $this->createQuery()
                    ->where('entite_id = ?', $id)
                    ->orWhere('id = ?', $id)
                    ->orderBy('intitule');
    return $requete->execute();
  }

  /**
   * Retourne les entites par ordre des intitulés
   *
   * @return DoctrineCollection
   * Auteurs: Actimage
   */
  public function retrieveEntites($objRequeteDoctrine = null) {
    $baseAlias = 'e';

    if ($objRequeteDoctrine == null) {
      $objRequeteDoctrine = $this->createQuery($baseAlias);
    } else {
      $baseAlias = $objRequeteDoctrine->getRootAlias();
    }


    $objRequeteDoctrine->from('Entite ' . $baseAlias)
            ->leftJoin($baseAlias . '.Organisme_mindef o')
            ->andWhere('entite_id is NULL')
            ->orderBy('intitule');
    return $objRequeteDoctrine;
  }

  /**
   *  Methode retournant la requête doctrine selectionnant les grades d'un organisme mindef (triés)
   * @param   string $id identifiant de l'organisme mindef
   * @return  DoctrineQuery requête Doctrine à passer au paginateur ou au filtre
   * Auteurs: Actimage
   */
  public function getEntitesByOrgMindefId($id) {
//    var_dump($id);
//    die();
    return $this->retrieveEntites($this->createQuery('e')->where('e.organisme_mindef_id = ?', $id));
  }

  /**
   *  Methode proxy pour retrieveEntites() utilisée dans gridAction lors de filtres par modèle relatif
   * @param   DoctrineQuery $objRequeteDoctrine requête à trier
   * @return  DoctrineQuery requête Doctrine à passer au paginateur ou au filtre
   * Auteurs: Actimage
   */
  public function retrieveQuery($objRequeteDoctrine = null) {
    return $this->retrieveEntites($objRequeteDoctrine);
  }

  /**
   *  Methode proxy pour getEntitesByOrgMindefId() utilisée dans gridAction lors de filtres par modèle relatif
   * @param   Int $id Identifiant du modèle filtrant
   * @return  DoctrineQuery requête Doctrine à passer au paginateur ou au filtre
   * Auteurs: Actimage
   */
  public function retrieveByRelationId($id) {
    return $this->getEntitesByOrgMindefId($id);
  }

  /**
   *  Methode pour vérifier si l'entité et ses parents sont actifs
   * @param   Integer $entiteId id de l'entité à vérifier
   * @return  boolean
   * Auteurs: Actimage
   */
  public function verifieEntiteActiveRecursif($entiteId) {

    $objEntite = $this->getInstance()->findOneById($entiteId);

    $boolVerifEntite = $objEntite->getEstActif();

   
    //si l'entite est active on continue et on vérifie le parent (s'il existe)
    //sinon on renvoie $boolVerifEntite = false
    if ($boolVerifEntite) {


      if($objEntite->getEntiteId()){
        $boolVerifEntite = $this->verifieEntiteActiveRecursif($objEntite->getEntiteId());
        
        if($boolVerifEntite){
          return $boolVerifEntite = true;
        }else{
          return $boolVerifEntite = false;
        }

      }else{
        return $boolVerifEntite = true;
      }
      
    } else {
      return $boolVerifEntite = false ;
    }
    

  }

   /**
   * Retourne les entites actives
   *
   * @return DoctrineCollection
   * Auteurs: Actimage
   */
  public function retrieveEntitesActives($objRequeteDoctrine = null) {
    $baseAlias = 'e';

    if ($objRequeteDoctrine == null) {
      $objRequeteDoctrine = $this->createQuery($baseAlias);
    } else {
      $baseAlias = $objRequeteDoctrine->getRootAlias();
    }


    $objRequeteDoctrine->from('Entite ' . $baseAlias)
            ->andWhere( $baseAlias.'.est_actif = 1');
    
    return $objRequeteDoctrine;
  }

  /**
   *
   * Retoune toutes les entités d'un organisme
   * @param int $id
   * @return DoctrineCollection
   * @author Julien GAUTIER
   */
   public function retrieveEntitesByOrganismeMindefId($id) {
    return $this->createQuery('e')->where('e.organisme_mindef_id = ?', $id)
          ->orderBy("e.intitule");
  }
}