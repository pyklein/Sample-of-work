<?php

sfContext::getInstance()->getConfiguration()->loadHelpers("Libelle");

/**
 * Departement form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class DepartementForm extends BaseDepartementForm {

  public function configure() {
    $this->setWidgets(array(
        'nom' => new sfWidgetFormInputText(array('label' => libelle('msg_departement_libelle_nom'))),
        'code_departemental' => new sfWidgetFormInputText(array('label' => libelle('msg_departement_libelle_code_departemental')
            )),
        'id' => new sfWidgetFormInputHidden(),
        'region_id' => new sfWidgetFormDoctrineChoice(array(
                'model' => $this->getRelatedModelName('Region'),
                'method' => 'getIntitule',
                'order_by' => array('intitule', 'ASC'),
                'label' => libelle('msg_departement_libelle_region'),
                'add_empty' => libelle('msg_libelle_aucun')))
    ));

    $this->setValidators(array(
        'nom' => new sfValidatorString(array('required' => 'true'),
                array('required' => libelle('msg_departement_nom_requis'))),
        'code_departemental' => new sfValidatorRegex(array('required' => 'true',
            'pattern' => '/9?[0-9][0-9a-bA-B]/'),
                array('required' => libelle('msg_departement_code_requis'),
                    'invalid' => libelle('msg_departement_code_invalide'))),
        'id' => new sfValidatorDoctrineChoice(array(
            'model' => 'Departement',
            'multiple' => false
            )),
         'region_id' => new sfValidatorDoctrineChoice(array(
            'model' => 'Region',
            'required' => true,
            'multiple' => false),
              array('required' => libelle('msg_departement_region_requise')))
        ));

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->widgetSchema['code_departemental']->setAttribute('maxlength',3);

    $this->widgetSchema->setNameFormat('departement_forms[%s]');

    $this->validatorSchema->setPostValidator(new sfValidatorDoctrineUnique(array(
        'model' => 'Departement','column' => 'code_departemental','throw_global_error' => true,'primary_key' => 'id'),
        array('invalid' => libelle('msg_departement_unique'))));

    $this->disableCSRFProtection();
    parent::configure();

  }

}
