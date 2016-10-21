<?php

/**
 * LaboratoireTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class LaboratoireTable extends Doctrine_Table {

  /**
   * Returns an instance of this class.
   *
   * @return LaboratoireTable
   */
  public static function getInstance() {
    return Doctrine_Core::getTable('Laboratoire');
  }

  public function retrieveByOrganismeId($id, $boolStrict = false) {
    $objRequeteDoctrine = $this->retrieveLaboratoires($this->createQuery('s')->where('s.organisme_id = ?', $id));
    if ($boolStrict){
      $objRequeteDoctrine = $objRequeteDoctrine->andWhere('s.service_id is null');
    }
    return $objRequeteDoctrine;
  }

  public function retrieveByServiceId($id) {
    return $this->retrieveLaboratoires($this->createQuery('s')->where('s.service_id = ?', $id));
  }

  public function retrieveLaboratoires($objRequeteDoctrine = null) {
    if ($objRequeteDoctrine == null) {
      $objRequeteDoctrine = $this->createQuery('s');
    }
    return $objRequeteDoctrine->orderBy('intitule');
  }

  /**
   * Retourne les laboratoires qui n'ont pas de service ou d'organisme
   * @return Doctrine_query
   * @author Alexandre WETTA
   */
  public function retrieveLaboratoireOrphelin($objRequeteDoctrine = null) {
    if ($objRequeteDoctrine == null) {
      $objRequeteDoctrine = $this->createQuery();
    }

    $objRequeteDoctrine->andWhere('service_id IS NULL')
            ->andWhere('organisme_id IS NULL');

    return $objRequeteDoctrine->orderBy('intitule');
  }

  /**
   * Verifie si une laboratoire est compatible avec un organisme
   *
   * @param integer $idLaboratoire Id de la laboratoire vis-à-vis la base de données
   * @param integer $idOrganisme Id de l'organisme vis-à-vis la base de données
   * @return boolean
   *
   * @author Simeon PETEV
   */
  public function estCompatibleLaboratoireAvecOrganisme($idLaboratoire, $idOrganisme) {
    if (sfContext::hasInstance())
      sfContext::getInstance()->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    $objQuery = $this->getQueryObject()
                    ->where("id" . " = ?", $idLaboratoire)
                    ->andWhere("organisme_id" . " = ?", $idOrganisme);


    if (sfContext::hasInstance())
      sfContext::getInstance()->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");

    return ($objQuery->count() > 0) ? true : false;
  }

  /**
   * Query qui permet de recupere les laboratoires actifs pour un selectbox
   *
   * @return query Doctrine_Query
   *
   * @author Simeon PETEV
   */
  public function buildQueryLaboratoiresActifsOrdreAscPourSelectBox()
  {
    if (sfContext::hasInstance())
      sfContext::getInstance()->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    $arrIdsLabosActifs = array();
    $arrLaboActifs = $this->getQueryObject()->execute();

    foreach ($arrLaboActifs as $objLaboratoire)
    {
      if ($objLaboratoire->getEstActifRecursif())
      {
        $arrIdsLabosActifs[] = $objLaboratoire->getId();
      }
    }

    $objQuery = $this->getQueryObject();

    if (empty ($arrIdsLabosActifs))
    {
      $objQuery = $objQuery->where("id = 0");
    } else
    {
      $objQuery = $objQuery->whereIn("id",$arrIdsLabosActifs);
    }

    $objQuery = $objQuery->orderBy("intitule ASC");

    if (sfContext::hasInstance())
      sfContext::getInstance()->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");

    return $objQuery;
  }


  /**
   * Génère la requête utilisée par le paginateur de la liste des laboratoires disponibles dans l'onglet invitations d'une commission
   * @param string $strSessionToken transaction_token correspondant aux opérations en cours
   * @param string $intCommissionId ID de commission
   * @return Doctrine_query requête à passer au paginateur
   * @author Gabor JAGER
   */
  public function retrieveLaboratoiresDisponibles($strSessionToken, $intCommissionId)
  {

    $arrLaboratoireFiltre = array();

    // recuperer les IDs des laboratoires déja concernés
    $arrLaboratoiresConcernes = InvitationTable::getInstance()->getInvitationsLaboratoireByCommission($intCommissionId)->execute();
    foreach($arrLaboratoiresConcernes as $objInvitationConcernes)
    {
      $arrLaboratoireFiltre[$objInvitationConcernes->getLaboratoireId()] = $objInvitationConcernes->getLaboratoireId();
    }

    // on supprime les invitations "pas concernés" de la table de session
    $arrInvitationsPasConcernes = Session_invitation_commissionTable::getInstance()->getSessionsInvitationsPasConcernesByToken($strSessionToken);
    foreach ($arrInvitationsPasConcernes as $objSession)
    {
      $objInvitation = $objSession->getInvitation();
      if ($objInvitation->estLaboratoire()
              && isset($arrLaboratoireFiltre[$objInvitation->getLaboratoireId()]))
      {
        unset($arrLaboratoireFiltre[$objInvitation->getLaboratoireId()]);
      }
    }

    $objRequeteDoctrine = $this->createQuery('l')
                               ->where('l.est_actif = 1')
                               ->leftJoin('l.Session_invitation_commission i WITH i.laboratoire_id = l.id AND i.transaction_token = ?', $strSessionToken)
                               ->andWhere('i.est_concerne = 0 OR i.transaction_token IS NULL');

    if (count($arrLaboratoireFiltre) > 0)
    {
      $objRequeteDoctrine->andWhere('l.id NOT IN ('.implode(",", $arrLaboratoireFiltre).')');
    }

    return $objRequeteDoctrine->orderBy('l.intitule');
  }

  /**
   * Construit un query permettant de recupere les laboratoires actifs et correspondant
   * au filtre, mais les ids desquelles ne sont pas present dans l'array passé en
   * paramettre et ils les tri en ordre ascendans de l'intitulé
   *
   * @param object $objFiltreLabos Un filtre laboratoires
   * @param array $arrIdsExclus Les ids des laboratoires a exclure
   * @return Doctrine_Query
   *
   * @author Simeon PETEV
   */
  public function buildQueryLaboratoiresDisponiblesAvecFiltreSauf($objFiltreLabos=null,$arrIdsExclus=array())
  {
    if (sfContext::hasInstance())
      sfContext::getInstance()->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    $objQuery = $this->getInstance()->getQueryObject()
                                        ->where('est_actif = 1')
                                        ->orderBy('intitule ASC')
    ; 

    if ($objFiltreLabos)
    {
      if ($objFiltreLabos->isValid())
      {
        $arrValeursFiltre = $objFiltreLabos->getValues();
        
        if (count($arrIdsExclus) > 0)
        {
          $objQuery = $objQuery->whereNotIn('id',$arrIdsExclus);
        }

        if (isset($arrValeursFiltre['organisme_id']) && $arrValeursFiltre['organisme_id']['text'] != 0)
        {
          $objQuery = $objQuery->addWhere('organisme_id = ?',$arrValeursFiltre['organisme_id']['text']);
        }

        if (isset($arrValeursFiltre['service_id']) && $arrValeursFiltre['service_id']['text'] != 0)
        {
          $objQuery = $objQuery->addWhere('service_id = ?',$arrValeursFiltre['service_id']['text']);
        }
      } else if ($objFiltreLabos->isBound())
      {
        $objQuery = $objQuery->addWhere('id IS NULL');
      }
    }

    if (sfContext::hasInstance())
      sfContext::getInstance()->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");

    return $objQuery;
  }

  /**
   * Recupere les objets Doctrine correspondants aux ids
   *
   * @param array $arrIdsLabos Un array de ids valides de laboratoires
   * @return Doctrine_Collection d'objets laboratoire
   *
   * @author Simeon PETEV
   */
  public function retreveLaboratoiresAvecIds($arrIdsLabos=null)
  {
    if (sfContext::hasInstance())
      sfContext::getInstance()->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    $objQuery = $this->getInstance()->getQueryObject();

    if ($arrIdsLabos)
    {
      $objQuery = $objQuery->whereIn('id', $arrIdsLabos);
    } else
    {
      $objQuery = $objQuery->where('id IS NULL');
    }

    if (sfContext::hasInstance())
      sfContext::getInstance()->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");

    return $objQuery->execute();
  }
}
