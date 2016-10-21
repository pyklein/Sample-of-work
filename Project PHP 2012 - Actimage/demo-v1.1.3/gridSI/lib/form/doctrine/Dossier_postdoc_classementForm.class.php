<?php

/**
 * Dossier_postdoc classement form avec un champ 'classement' unique utiliser dans la validation des dossiers de stages postdoctoraux
 *
 * @package    gridSI
 * @subpackage form
 * @author     Jihad
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Dossier_postdoc_classementForm extends BaseDossier_postdocForm
{
  public function configure()
  {
    $this->disableLocalCSRFProtection();
    
    $this->useFields(array('classement'));

    $this->widgetSchema['classement']->setLabel(libelle("msg_libelle_classement"));
    $this->validatorSchema['classement'] = new sfValidatorInteger(array('required' => false),array('invalid' => libelle("msg_dossier_postdoc_champ_invalide",array(libelle("msg_libelle_classement")))));
    parent::configure();
  }
}
