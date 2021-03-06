<?php

/**
 * Commission_intervenantTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Commission_intervenantTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object Commission_intervenantTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Commission_intervenant');
    }

    /**
   *  Retourne l'enregistrement concernant l'implication d'un participant donnée pour une commission donnée
   * @param string $strInnovateurId   Identifiant de l'innovateur
   * @param string $strDossierId      Identifiant du dossier MIP
   * @return Doctrine_collection      Résultats de la requête (0 ou 1 enregistrement si base cohérente)
   */
  public function getByCommissionAndParticipant($strParticipantId, $strCommissionId) {
    return $this->createQuery('i')->where('i.commission_id = ?', $strCommissionId)->andWhere('i.intervenant_id = ?', $strParticipantId)->execute();
  }

  /**
   *  Enregistre de manière effective les informations recoltées dans la table support Session_participant_mindef_commissionTable vers Commission_utilisateurTable
   * @param string $strTransactionToken       transaction_token des opérations à sauvegarder
   * @param string $strCommissionId           identifiant de la commission traintée
   * @param Utilisateur $objUtilisateur       utilisateur effectuant les opérations
   */
  public function enregistrerModificationSession($strTransactionToken, $strCommissionId, Utilisateur $objUtilisateur) {
    $objEtatSession = Session_participant_exterieurs_commissionTable::getInstance()->retrieveEtatSession($strTransactionToken);

    $connection = $this->getConnection();
    $connection->beginTransaction();
    //L'enregistrement de ces informations se fait en une seule transaction
    try {
      foreach ($objEtatSession as $objEnregistrement) {
        $strParticipantId = $objEnregistrement->getIntervenantId();
        $objParticipantCommission = $this->getByCommissionAndParticipant($strParticipantId, $strCommissionId);

        //cas : Innovateur non concerné au début des opérations d'affectations
        if ($objParticipantCommission->count() == 0) {
          //cas : Innovateur concerné après les opérations (on ne fait rien si non concerné)
          if ($objEnregistrement->getEstConcerne() == 1) {
            $objNouveauParticipantCommission = new Commission_intervenant();
            $objNouveauParticipantCommission->setCommissionId($strCommissionId);
            $objNouveauParticipantCommission->setIntervenantId($strParticipantId);

            $objNouveauParticipantCommission->save();
          }
          //cas : Innovateur concerné au début des opérations
        } else {
          //cas : Innovateur non concerné après les opérations -> suppression de l'enregistrement innovateur_dossier_mip
          if (!$objEnregistrement->getEstConcerne()) {
            $objParticipantCommission[0]->delete();
          } 
        }
        //nettoyage de la table support
        $objEnregistrement->delete();
      }
      $connection->commit();
    } catch (Exception $ex) {
      $connection->rollBack();
      throw $ex;
    }
  }
}