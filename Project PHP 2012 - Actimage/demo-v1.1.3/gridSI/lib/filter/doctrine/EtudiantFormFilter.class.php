<?php

/**
 * Etudiant filter form.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class EtudiantFormFilter extends BaseEtudiantFormFilter
{
  public function configure()
  {
    $this->useFields(array('nom'));

    $this->configureLabelles();

    $this->disableCSRFProtection();
  }

  private function configureLabelles()
  {
    $this->widgetSchema['nom']->setLabel(libelle('msg_libelle_nom_prenom_email'));
  }

  public function  buildQuery(array $values)
  {
    return EtudiantTable::getInstance()->buildQueryAvecFiltre($this);
  }
}
