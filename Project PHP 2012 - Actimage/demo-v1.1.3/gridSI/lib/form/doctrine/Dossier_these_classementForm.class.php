<?php

/**
 * Dossier_these classement form avec un champ 'classement' unique utiliser dans la validation des dossiers de theses
 *
 * @package    gridSI
 * @subpackage form
 * @author     Jihad
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Dossier_these_classementForm extends BaseDossier_theseForm
{
  public function configure()
  {
    
    $this->disableLocalCSRFProtection();
    

    $this->useFields(array('classement'));

    $this->widgetSchema['classement']->setLabel(libelle("msg_libelle_classement"));
    $this->validatorSchema['classement'] = new sfValidatorInteger(array('required' => false),array('invalid' => libelle("msg_dossier_these_champ_invalide",array(libelle("msg_libelle_classement")))));

    parent::configure();

  }
}
