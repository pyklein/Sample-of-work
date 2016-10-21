<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LaboratoireDossierMris
 *
 * @author Simeon Petev
 */
class LaboratoireDossierMrisForm extends BaseLaboratoireForm
{
  public function configure() {

    $this->useFields(array('organisme_id', 'service_id', 'intitule', 'abreviation', 'evaluation_aers'));


    //widget
    $this->widgetSchema['service_id'] = new gridWidgetFormService(array('popup'=>true));
    $this->widgetSchema['organisme_id'] = new gridWidgetFormOrganisme(array('popup'=>true));
    $this->widgetSchema['evaluation_aers'] = new sfWidgetFormEvaluationAers();
    //validateurs
    $this->validatorSchema['intitule'] = new sfValidatorString(array('required' => 'true'),
                    array('required' => libelle('msg_referentiel_intitule_requis')));                   
    
    $this->validatorSchema->setPostValidator(new sfValidatorAnd(array(
                new sfValidatorDoctrineUnique(array(
                    'model' => 'laboratoire',
                    'column' => array('intitule', 'service_id'),
                    'throw_global_error' => false,
                    'primary_key' => 'id'),
                        array('invalid' => libelle('msg_laboratoire_unique_service')
                )),
                new sfValidatorDoctrineUnique(array(
                    'model' => 'laboratoire',
                    'column' => array('intitule', 'organisme_id'),
                    'throw_global_error' => false,
                    'primary_key' => 'id'),
                        array('invalid' => libelle('msg_laboratoire_unique_organisme')
                )),
                new sfValidatorCallback(array('callback' => array($this, 'checkServiceOrganisme'))),
            )));


    //libelle
    $this->widgetSchema->setLabels(array(
        'intitule' => libelle('msg_libelle_intitule'),
        'abreviation' => libelle('msg_libelle_abreviation'),
        'evaluation_aers' => libelle('msg_libelle_evaluation_aers'),
        'organisme_id' => libelle('msg_libelle_organisme'),
        'service_id' => libelle('msg_libelle_service'),
    ));

    $this->disableLocalCSRFProtection();
    parent::configure();
  }

  /**
   * Permet de vérifier que le service et l'organisme ne sont pas sélectionné en même temps
   * @param object $validator
   * @param string[] $values
   * @return string[]
   * @author Alexandre WETTA
   */
  public function checkServiceOrganisme($validator, $values) {

    if ($values['service_id'] != "")
    {
      $objService = ServiceTable::getInstance()->findOneById($values['service_id']);

      if ($values['organisme_id'] != "")
      {  
        if($objService->getOrganismeId() != $values['organisme_id'] )
        {
          if ($objService->getOrganismeId() == null || $objService->getOrganismeId() == "")
          {
            $error = new sfValidatorError($validator, libelle('msg_referentiel_service_aucun_organisme_erreur',array($objService->getIntitule())));
          } else
          {
            $error = new sfValidatorError($validator, libelle('msg_referentiel_service_appartenance_organisme_erreur',array($objService->getIntitule(),$objService->getOrganisme()->getIntitule())));
          }
          
          throw new sfValidatorErrorSchema($validator, array('organisme_id' => $error));
        }
      } else if ($objService->getOrganismeId() != null && $objService->getOrganismeId() != "")
      {
        $error = new sfValidatorError($validator, libelle('msg_referentiel_laboratoire_service_require_organisme',array($objService->getIntitule(),$objService->getOrganisme()->getIntitule())));
        
        throw new sfValidatorErrorSchema($validator, array('organisme_id' => $error));
      }
    } else if ($values['organisme_id'] == "")
    {
      $error = new sfValidatorError($validator, libelle('msg_referentiel_laboratoire_service_required'));

      throw new sfValidatorErrorSchema($validator, array('organisme_id' => $error, 'service_id' => $error));
    }

    return $values;
  }

  public function save($con = null) {
    if ($this->values['service_id'] != "" && $this->values['organisme_id'] != "") {
      $this->values['organisme_id'] = null;
    }
    parent::save($con);
  }

}
?>
