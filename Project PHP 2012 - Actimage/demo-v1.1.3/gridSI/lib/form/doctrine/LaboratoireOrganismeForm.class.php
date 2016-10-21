<?php

/**
 * Laboratoire form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class LaboratoireOrganismeForm extends BaseLaboratoireForm
{
  public function configure()
  {
     $this->useFields(array('intitule','intitule_ancien','abreviation','evaluation_aers'));

 
    $this->widgetSchema['evaluation_aers'] = new sfWidgetFormEvaluationAers();
    $this->widgetSchema['organisme_id'] = new sfWidgetFormInputHidden();

    $this->validatorSchema['organisme_id'] = new sfValidatorDoctrineChoice(array('model' => 'Organisme'));

    $this->validatorSchema['intitule'] = new sfValidatorString(array('required' => 'true'),
                    array('required' => libelle('msg_referentiel_intitule_requis')));

    $this->validatorSchema->setPostValidator(new sfValidatorDoctrineUnique(array(
        'model' => 'laboratoire','column' => array('intitule','organisme_id'),'throw_global_error' => true,'primary_key' => 'id'),
        array('invalid' => libelle('msg_laboratoire_unique_organisme'))));

        $this->widgetSchema->setLabels(array(
        'intitule' => libelle('msg_referentiel_libelle_intitule'),
        'abreviation' => libelle('msg_referentiel_libelle_abreviation'),
        'evaluation_aers' => libelle('msg_libelle_evaluation_aers'),
        'intitule_ancien' => libelle('msg_referentiel_libelle_intitule_ancien')));
    parent::configure();
  }
  
}
