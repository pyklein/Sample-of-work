<?php

/**
 * Cofinance_theseTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Cofinance_theseTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object Cofinance_theseTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Cofinance_these');
    }

         /**
   *  Retourne l'enregistrement concernant l'implication d'un participant donnée pour une commission donnée
   * @param string $strInventeurId    Identifiant de l'inventeur
   * @param string $strDossierId      Identifiant du dossier BPI
   * @return Doctrine_collection      Résultats de la requête (0 ou 1 enregistrement si base cohérente)
   */
  public function getByDossierAndOrganisme($strOrganismeId, $strDossierId) {
    return $this->createQuery('i')->where('i.dossier_these_id = ?', $strDossierId)->andWhere('i.organisme_id = ?', $strOrganismeId)->execute();
  }
    /**
   *  Enregistre de manière effective les informations recoltées dans la table support Session_participant_mindef_commissionTable vers Commission_utilisateurTable
   * @param string $strTransactionToken       transaction_token des opérations à sauvegarder
   * @param string $strDossierId              identifiant du dossier de these traité
   * @param Utilisateur $objUtilisateur       utilisateur effectuant les opérations
   */
  public function enregistrerModificationSession($strTransactionToken, $strDossierId, Utilisateur $objUtilisateur) {
    $objEtatSession = Session_cofinance_theseTable::getInstance()->retrieveEtatSession($strTransactionToken);
    $connection = $this->getConnection();
    $connection->beginTransaction();
    //L'enregistrement de ces informations se fait en une seule transaction
    try {
      foreach ($objEtatSession as $objEnregistrement) {
        $strOrganismeId = $objEnregistrement->getOrganismeId();
        $objOrganismePartCofinance = $this->getByDossierAndOrganisme($strOrganismeId, $strDossierId);

        //cas : Organisme non concerné au début des opérations d'affectations
        if ($objOrganismePartCofinance->count() == 0) {
          //cas : Organisme concerné après les opérations (on ne fait rien si non concerné)
          if ($objEnregistrement->getPartCofinance() > 0) {
            $objNouveauOrganismePartCofinance = new Cofinance_these();
            $objNouveauOrganismePartCofinance->setDossierTheseId($strDossierId);
            $objNouveauOrganismePartCofinance->setOrganismeId($strOrganismeId);

            $objNouveauOrganismePartCofinance->setPartCofinance($objEnregistrement->getPartCofinance());
            $objNouveauOrganismePartCofinance->save();
          }
          //cas : Organisme concerné au début des opérations
        } else {
          //cas : Organisme non concerné après les opérations -> suppression de l'enregistrement innovateur_dossier_mip
          if ($objEnregistrement->getPartCofinance() == 0) {
            $objOrganismePartCofinance[0]->delete();
          } else { //cas modification de la part cofinance
            $objOrganismePartCofinance[0]->setPartCofinance($objEnregistrement->getPartCofinance());
            $objOrganismePartCofinance[0]->save();
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