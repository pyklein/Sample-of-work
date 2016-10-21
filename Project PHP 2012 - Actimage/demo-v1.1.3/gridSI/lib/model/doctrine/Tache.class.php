<?php

/**
 * Tache
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
class Tache extends BaseTache
{
  /**
   * Permet de vérifier si la tâche est en execution ou pas
   * @return boolean true si la tâche est en cours d'execution (le PID est renseigné)
   * @author Gabor JAGER
   */
  public function isRunning()
  {
    if ($this->getPid() == null)
    {
      return false;
    }

    return true;
  }

}