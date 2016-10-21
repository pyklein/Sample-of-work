<?php

/**
 * Session_valorisation_externeTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Session_valorisation_externeTable extends Session_supportTable
{
  /**
   * Returns an instance of this class.
   *
   * @return object Session_valorisation_externeTable
   */
  public static function getInstance()
  {
    return Doctrine_Core::getTable('Session_valorisation_externe');
  }

  /**
   * Permet d'initialiser la table de session avec les valeurs déjà enregistrées
   * @param string $strToken
   * @param integer $intDossierId
   * @author Gabor JAGER
   */
  public function initDonnees($strToken, $intDossierId)
  {
    $arrValorisationsExternes = Valorisation_externeTable::getInstance()->getValorisationsExternesByDossierId($intDossierId);

    foreach($arrValorisationsExternes as $objValorisationExterne)
    {
      $objSession = new Session_valorisation_externe();
      $objSession->setTransactionToken($strToken);
      $objSession->setContratId($objValorisationExterne->getContratId());
      $objSession->setOrganismeId($objValorisationExterne->getOrganismeId());
      $objSession->setStatutValorisationExterneId($objValorisationExterne->getStatutValorisationExterneId());

      $objSession->save();
    }
  }

  /**
   * Permet de recuperer tous les valorisations externes
   * @param string $strToken
   * @return Doctrine_Collection
   * @author Gabor JAGER
   */
  public function getValorisationsExternesSessionByToken($strToken)
  {
    $objRequete = $this->createQuery('s')
                       ->leftJoin("s.Organisme o ON s.organisme_id = o.id")
                       ->where("s.transaction_token = ?", $strToken)
                       ->orderBy("o.intitule");

    return $objRequete->execute();
  }

  /**
   * Permet de recuperer tous les valorisations externes
   * @param string $intOrganismeId
   * @param string $intStatutId
   * @param string $intContratId
   * @param string $strToken
   * @return Session_valorisation_externe
   * @author Gabor JAGER
   */
  public function getValorisationsExternesSessionByOrganismeStatutContratToken($intOrganismeId, $intStatutId, $intContratId, $strToken)
  {
    $objRequete = $this->createQuery('s')
                       ->leftJoin("s.Organisme o ON s.organisme_id = o.id")
                       ->where("s.transaction_token = ?", $strToken)
                       ->andWhere("s.organisme_id = ?", $intOrganismeId)
                       ->andWhere("s.statut_valorisation_externe_id = ?", $intStatutId);

    if ($intContratId != "")
    {
      $objRequete->andWhere("s.contrat_id = ?", $intContratId);
    }
    else
    {
      $objRequete->andWhere("s.contrat_id IS NULL");
    }

    $objResultat = $objRequete->execute();

    if (count($objResultat) == 0)
    {
      return null;
    }

    return $objResultat[0];
  }
}