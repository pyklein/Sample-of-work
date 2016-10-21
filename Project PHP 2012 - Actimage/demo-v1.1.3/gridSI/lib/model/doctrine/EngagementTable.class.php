<?php

/**
 * EngagementTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class EngagementTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object EngagementTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Engagement');
    }

  /**
   * Creer un query permettant de recupere les engagements par ordre decendant
   * de la date
   *
   * @param $intDossierId Id du dossier
   * @return Doctrine_Query
   *
   * @author Simeon PETEV
   */
  public function buildQueryEngagementsOrdreDescDate($intDossierId=0)
  {
    if (sfContext::hasInstance())
        sfContext::getInstance()->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    $objQuery = $this->getInstance()->getQueryObject()
                                        ->where('dossier_mip_id = ?',$intDossierId)
                                        ->orderBy('date_engagement DESC')
    ;

    if (sfContext::hasInstance())
        sfContext::getInstance()->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");

    return $objQuery;
  }

  /**
   * Recupere les engagements par ordre decendant de la date
   *
   * @return Doctrine_Collection
   *
   * @author Simeon PETEV
   */
  public function retreveEngagementsOrdreDescDate($intDossierId=0)
  {
    if (sfContext::hasInstance())
        sfContext::getInstance()->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    $arrFinancements = $this->buildQueryEngagementsOrdreDescDate($intDossierId)->execute();

    if (sfContext::hasInstance())
        sfContext::getInstance()->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");

    return $arrFinancements;
  }
}