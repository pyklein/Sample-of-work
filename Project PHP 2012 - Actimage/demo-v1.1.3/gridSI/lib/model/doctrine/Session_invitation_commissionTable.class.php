<?php

/**
 * Session_invitation_commissionTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Session_invitation_commissionTable extends Session_supportTable
{
  /**
   * Returns an instance of this class.
   *
   * @return object Session_invitation_commissionTable
   */
  public static function getInstance()
  {
    return Doctrine_Core::getTable('Session_invitation_commission');
  }


  /**
   * Récupère les informations de la table de support pour une session et un laboratoire donné
   * @param string $strLaboratoireId Id de laboratoire
   * @param string $strToken Transaction_token de la session
   * @return Doctrine_collection les informations recherchées (Un seul enregistrement à priori)
   * @author Gabor JAGER
   */
  public function getSessionByLaboratoireIdAndToken($strLaboratoireId, $strToken)
  {
    $objRequete = $this->createQuery('s')
                       ->where('s.laboratoire_id = ?', $strLaboratoireId)
                       ->andWhere('s.transaction_token = ?', $strToken);

    return $objRequete->execute();
  }

  /**
   * Récupère les informations de la table de support pour une session et un service donné
   * @param string $strServiceId Id de service
   * @param string $strToken Transaction_token de la session
   * @return Doctrine_collection les informations recherchées (Un seul enregistrement à priori)
   * @author Gabor JAGER
   */
  public function getSessionByServiceIdAndToken($strServiceId, $strToken)
  {
    $objRequete = $this->createQuery('s')
                       ->where('s.service_id = ?', $strServiceId)
                       ->andWhere('s.transaction_token = ?', $strToken);

    return $objRequete->execute();
  }

  /**
   * Récupère les informations de la table de support pour une session et un invitation donné
   * @param string $strInvitationId Id d'invitation
   * @param string $strToken Transaction_token de la session
   * @return Doctrine_collection les informations recherchées (Un seul enregistrement à priori)
   * @author Gabor JAGER
   */
  public function getSessionByInvitationIdAndToken($strInvitationId, $strToken)
  {
    $objRequete = $this->createQuery('s')
                       ->where('s.invitation_id = ?', $strInvitationId)
                       ->andWhere('s.transaction_token = ?', $strToken);

    return $objRequete->execute();
  }

  /**
   * Récupère les informations de la table de support pour une session
   * @param string $strToken Transaction_token de la session
   * @return Doctrine_collection les informations recherchées
   * @author Gabor JAGER
   */
  public function getSessionsInvitationsPasConcernesByToken($strToken)
  {
    $objRequete = $this->createQuery('s')
                       ->where('s.est_concerne = 0')
                       ->andWhere('s.invitation_id IS NOT NULL')
                       ->andWhere('s.transaction_token = ?', $strToken);

    return $objRequete->execute();
  }

  /**
   * Récupère les informations de la table de support pour une session
   * @param string $strToken Transaction_token de la session
   * @return Doctrine_collection les informations recherchées
   * @author Gabor JAGER
   */
  public function getSessionsServicesConcernesByToken($strToken)
  {
    $objRequete = $this->createQuery('s')
                       ->where('s.est_concerne = 1')
                       ->andWhere('s.service_id IS NOT NULL')
                       ->andWhere('s.transaction_token = ?', $strToken);

    return $objRequete->execute();
  }
}
