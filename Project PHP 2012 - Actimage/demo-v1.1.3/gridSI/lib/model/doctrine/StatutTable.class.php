<?php

/**
 * StatutTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class StatutTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object StatutTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Statut');
    }

  public function buildQueryStatutOrdreAscIntitule()
  {
    return $this->getInstance()->getQueryObject()->orderBy('intitule ASC');
  }
}