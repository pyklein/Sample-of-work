<?php

/**
 * Statut_actionTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Statut_actionTable extends Doctrine_Table
{
  const A_MENER = "1";
  const MENER = "2";
    /**
     * Returns an instance of this class.
     *
     * @return object Statut_actionTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Statut_action');
    }
}