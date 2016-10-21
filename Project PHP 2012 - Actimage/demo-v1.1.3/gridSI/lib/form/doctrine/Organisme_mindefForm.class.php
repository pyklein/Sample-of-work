<?php

/**
 * Organisme_mindef form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Organisme_mindefForm extends BaseOrganisme_mindefForm
{
  public function configure()
  {
      
       $this->useFields(array('intitule','abreviation'));

       $this->widgetSchema->setLabels(array('intitule' => libelle('msg_organisme_mindef_libelle_intitule'),
        'abreviation' => libelle('msg_organisme_mindef_libelle_abreviation')));

       // si c'est un nouvel organisme, on vérifie s'il existe déjà
       if($this->isNew()){

            $this->validatorSchema->setPostValidator( new sfValidatorAnd(array(
              new sfValidatorDoctrineUnique(array('model' => 'Organisme_mindef', 'column' => array('abreviation'),'throw_global_error' => false),array('invalid' => libelle('msg_organisme_mindef_creer_abreviation_existe'))),
              new sfValidatorDoctrineUnique(array('model' => 'Organisme_mindef', 'column' => array('intitule'),'throw_global_error' => false),array('invalid' => libelle('msg_organisme_mindef_creer_intitule_existe')))
            )));

           $this->validatorSchema['intitule'] = new sfValidatorString(array('required' => 'true'), array('required' => libelle('msg_referentiel_intitule_requis')));

           $this->validatorSchema['abreviation'] = new sfValidatorString(array('required' => 'true'),array('required' => libelle('msg_referentiel_abreviation_requis'))) ;

       }else{
         
          $this->validatorSchema['intitule'] =  new sfValidatorString(array('required' => 'true'), array('required' => libelle('msg_referentiel_intitule_requis')));

          $this->validatorSchema['abreviation'] =  new sfValidatorString(array('required' => 'true'),array('required' => libelle('msg_referentiel_abreviation_requis')));

       }

       $this->disableLocalCSRFProtection();

    parent::configure();
  }

}
