<?php

/**
 * Entite
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
class Entite extends BaseEntite
{


  /**
   *
   * @param array $arrEntiteNomActif - array de type:
   *                                  array("entite" => $objEntite,
   *                                        "nom"    => $intituleEntite,
   *                                        "getInnactifAussi" => $estActifEntite
   *                                        )
   *                                  où les clés de l'array sont constantes string
   *                                  qu'on vient d'indiquer ("entite", "nom", "getInnactifAussi")
   * @return string Nom anteologique de l'entite sous la forme:
   *                 /intituleEntiteParent1/.../intituleEntiteParentDirect/intituleEntite
   *
   * @author Simeon PETEV
   */
  public function getConstruitRecursivementNomPourSelectBox($arrEntiteNomActif)
  {
    $this->logDebug(" [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    if ((!$arrEntiteNomActif["entite"]->getEstActif()) && ($arrEntiteNomActif["getInnactifAussi"] == false))
    {
      $arrEntiteNomActif["nom"] = "";

      $this->logDebug(" [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");

      return $arrEntiteNomActif;

    }
    else if ($arrEntiteNomActif["entite"]->getEntite()->getId() != null)
    {
      $arrEntiteNomActif["nom"] = $arrEntiteNomActif["entite"]->getEntite()->getAbreviation()."/".$arrEntiteNomActif["nom"];
      $arrEntiteNomActif["entite"] = $arrEntiteNomActif["entite"]->getEntite();

      $this->logDebug(" [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");

      return $this->getConstruitRecursivementNomPourSelectBox($arrEntiteNomActif);

    }
    else
    {
      $arrEntiteNomActif["nom"] = "/".$arrEntiteNomActif["nom"];

      $this->logDebug(" [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");

      return $arrEntiteNomActif;
    }
  }


  /**
   * Permet de récuperer tous les parents (dans l'ordre) de l'entité
   * @return Entite[]
   * @author Gabor JAGER
   */
  public function getParentsEntites()
  {
    if (sfContext::hasInstance())
    {
      sfContext::getInstance()->getLogger()->debug('Entite->getParentsEntites() Start');
    }

    if ($this->getParents() == "")
    {
      return array();
    }
    
    $arrParentIds = explode(";", $this->getParents());
    $arrParents = EntiteTable::getInstance()->getEntites($arrParentIds);

    $arrRetour = array();
    foreach ($arrParentIds as $intParentId)
    {
      $arrRetour[] = $arrParents[$intParentId];
    }

    if (sfContext::hasInstance())
    {
      sfContext::getInstance()->getLogger()->debug('Entite->getParentsEntites() End');
    }

    return $arrRetour;
  }


  /**
   * Retourne le nom hierarchique de l'entité
   *
   * @param boolean $estSansOrganismeMondef - Indique si on veut un nom hierarchique
   *                                          sans l'organisme mindef associé
   * @return string Nom dans le hyerarchie - abreviationOrganismeMinDef/intituleEntiteParent1/.../intituleEntiteParentDirect/intituleEntite
   *
   * @author Simeon PETEV
   */
  public function getNomHierarchique($estSansOrganismeMondef=false)
  {
    $this->logDebug(" [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    $strResultat = "";

    $arrParents = $this->getParentsEntites();
    foreach($arrParents as $objEntite)
    {
      $strResultat = (($objEntite->getAbreviation()) ? $objEntite->getAbreviation().(($strResultat!="") ? "/" : "") : "").$strResultat;
    }

    if (!$estSansOrganismeMondef)
    {
      $strOrgMinDefNom = Organisme_mindefTable::getInstance()->getOrganismeMindefAvecCetId($this->getOrganismeMindefId())->getAbreviation();
      $strResultat = $strOrgMinDefNom.($strResultat == "" ? "" : "/").$strResultat;
    }

    if (sfContext::hasInstance())
    {
      sfContext::getInstance()->getLogger()->debug('Entite->getNomHierarchique() Fin');
    }

    $this->logDebug(" [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
    
    return $strResultat.($strResultat == "" ? "" : "/").$this->getAbreviation();
  }

  /**
   * Recupere le nom hierarchique de l'entité plus l'organisme d'affectation plus
   * le code executant (s'il y en a)
   *
   * @return string Nom dans le hyerarchie - abreviationOrganismeMinDef/intituleEntiteParent1/.../intituleEntiteParentDirect/intituleEntite (code_executant)
   *
   * @author Simeon PETEV
   */
  public function getNomHierarchiqueCompletPlusCode()
  {
    $this->logDebug(" [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    $strResultat = $this->getNomHierarchique();

    $strResultat = $strResultat.' (';

    if ($this->getCodeExecutant())
    {
      $strResultat = $strResultat.$this->getCodeExecutant();
    }

    $strResultat = $strResultat.')';

    $this->logDebug(" [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");

    return $strResultat;
  }

  /**
   * Recupere les IDs des entites dans le sous-arbre
   *
   * ATTENTION: Toujours appeler la fonction avec un array vide
   *
   * @param boolean $boolInactifAussi Indique s'il faut recupere les IDs des entite/sous-arbres desactivés
   * @param array $arrResultatsActuels Recupere les resultat intermediaures. Doit etre
   *                                    toujours vide lors de l'appele extern
   * @return array
   *
   * @author Simeon PETEV
   */
  public function getIdsSousEntites($boolInactifAussi,$arrResultatsActuels=array())
  {
    $this->logDebug(" [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    if ($boolInactifAussi || $this->getEstActif())
    {
      $arrResultatsActuels[] = $this->getId();

      $arrEnfants = $this->getSousEntites();

      foreach ($arrEnfants as $objEnfant)
      {
        $arrResultatsActuels = $objEnfant->getIdsSousEntites($boolInactifAussi,$arrResultatsActuels);
      }
    }

    $this->logDebug(" [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");

    return $arrResultatsActuels;
  }

  /**
   * Surcharge de fonction "save" pour calculer automatiquement le champ support de "parents"
   * @param Doctrine_Connection $conn
   */
  public function save(Doctrine_Connection $conn = null)
  {
    if (!sfContext::hasInstance()){ 
      parent::save($conn);
    }
    $this->setParents(EntiteTable::getInstance()->calculerParents($this->getEntiteId()));
    $this->setParentsArbo(EntiteTable::getInstance()->calculerParents($this->getEntiteId(), "desc"));

    parent::save($conn);
  }

  /**
   * Surcharge la methode par defaut pour retourner l'intidulé
   *
   * @return String
   *
   * @author Simeon PETEV
   */
  public function  __toString()
  {
    return $this->getIntitule();
  }

}