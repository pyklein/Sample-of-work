<?php

/**
 * Type_contentieuxTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Type_contentieuxTable extends Doctrine_Table
{
    const INVENTION = "1";
    const DROITS = "2";
    const EXPLOITATION_INTERNE = "3";
    /**
     * Returns an instance of this class.
     *
     * @return object Type_contentieuxTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Type_contentieux');
    }
}