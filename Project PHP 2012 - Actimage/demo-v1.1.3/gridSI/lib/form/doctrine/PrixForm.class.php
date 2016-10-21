<?php

/**
 * Prix form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Actimage
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PrixForm extends BasePrixForm
{
  public function configure()
  {

    $this->useFields(array(
       'intitule'
    ));

    $this->widgetSchema->setLabels(array('intitule' => libelle('msg_libelle_intitule')));

    // si c'est un nouveau prix, on vérifie s'il existe déjà
       if($this->isNew()){

            $this->validatorSchema->setPostValidator( new sfValidatorAnd(array(
              new sfValidatorDoctrineUnique(array('model' => 'Prix', 'column' => array('intitule'),'throw_global_error' => false),array('invalid' => libelle('msg_prix_creer_intitule_existe'))),
            )));

           $this->validatorSchema['intitule'] = new sfValidatorString(array('required' => 'true'), array('required' => libelle('msg_referentiel_intitule_requis')));


       }else{

           $this->validatorSchema['intitule'] = new sfValidatorString(array('required' => 'true'), array('required' => libelle('msg_referentiel_intitule_requis')));

       }

       $this->disableLocalCSRFProtection();
  }
}
