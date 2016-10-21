<?php

/**
 * Grade form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class GradeForm extends BaseGradeForm
{
  public function configure()
  {
    $this->useFields(array('intitule','abreviation','organisme_mindef_id'));

    $this->widgetSchema['organisme_mindef_id'] = new gridWidgetFormOrganismeMindef(array("popup" => true));

    $this->validatorSchema['organisme_mindef_id'] = new sfValidatorDoctrineChoice(
            array('required' => 'true', 'model' => $this->getRelatedModelName('Organisme_mindef')),
            array('required' => libelle('msg_form_error_champ_obligatoire')));

    $this->validatorSchema['intitule'] = new sfValidatorString(array('required' => 'true'),
                    array('required' => libelle('msg_referentiel_intitule_requis')));
    $this->validatorSchema['abreviation'] = new sfValidatorString(array('required' => 'true'),
                    array('required' => libelle('msg_referentiel_abreviation_requis')));

    $this->validatorSchema->setPostValidator(new sfValidatorDoctrineUnique(array(
        'model' => 'grade','column' => array('intitule','organisme_mindef_id'),'throw_global_error' => true,'primary_key' => 'id'),
        array('invalid' => libelle('msg_grade_unique'))));

    if ($this->getObject()->getOrganismeMindefId() != false){
      $this->widgetSchema['organisme_mindef_id'] = new sfWidgetFormReadOnly(array('content' => array('model' => 'Organisme_mindef')));
    }


    $this->widgetSchema->setLabels(array(
        'intitule' => libelle('msg_grade_libelle_intitule'),
        'abreviation' => libelle('msg_grade_libelle_abreviation'),
        'organisme_mindef_id' => libelle('msg_grade_libelle_org_mindef')));

    parent::configure();
  }
}
