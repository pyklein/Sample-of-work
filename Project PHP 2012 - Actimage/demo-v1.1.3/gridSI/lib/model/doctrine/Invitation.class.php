<?php

/**
 * Invitation
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    gridSI
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
class Invitation extends BaseInvitation
{
  /**
   * Permet de décider si l'objet est un invitation service ou pas
   * @return boolean true si l'objet est un invitation service
   *                 false sinon
   * @author Gabor JAGER
   */
  public function estService()
  {
    if ($this->service_id != null)
    {
      return true;
    }

    return false;
  }
  
  /**
   * Permet de décider si l'objet est un invitation laboratoire ou pas
   * @return boolean true si l'objet est un invitation laboratoire
   *                 false sinon
   * @author Gabor JAGER
   */
  public function estLaboratoire()
  {
    if ($this->laboratoire_id != null)
    {
      return true;
    }

    return false;
  }

}