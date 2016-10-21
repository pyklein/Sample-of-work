<?php

/**
 * Contact_se form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Contact_seForm extends BaseContact_seForm {

  public function configure() {
    $this->useFields(array(
        'entite_id',
        'email',
        'email2',
        'telephone',
        'fax',
        'code_postal',
        'ville_id',
        'adresse',
        'adresse2',
        'adresse3',        
        'nom',
        'prenom',
        'complement_adresse',
        'information_libre',

    ));

    $this->configureWidgets();

    $this->configureLibelles();

    $this->configureValidators();

    $this->disableCSRFProtection();

    parent::configure();
  }

  private function configureWidgets() {
    $this->widgetSchema['entite_id'] = new gridWidgetFormEntite(array('model' => $this->getRelatedModelName('Entite')));
    $this->widgetSchema['email'] = new sfWidgetFormInputEmail();
    $this->widgetSchema['email2'] = new sfWidgetFormInputEmail();
    $this->widgetSchema['telephone'] = new sfWidgetFormInputTelephone();
    $this->widgetSchema['fax'] = new sfWidgetFormInputTelephone();

    $this->widgetSchema['code_postal'] = new gridWidgetFormCodePostal();
    $this->widgetSchema['code_postal']->setWidgetFormVille('contact_se_ville_id');
    
    $this->widgetSchema['ville_id'] = new gridWidgetFormVille(array('model' => $this->getRelatedModelName('Ville')));
    if (!$this->getObject()->isNew())
    {
      $this->widgetSchema['ville_id']->setOption('query', VilleTable::getInstance()->buildQueryVilleActifsOrdreAscPourSelectBox($this->getObject()->getCodePostal()));
    }
  }

  private function configureLibelles() {
    $this->widgetSchema['nom']->setLabel(libelle('msg_libelle_nom'));
    $this->widgetSchema['prenom']->setLabel(libelle('msg_libelle_prenom'));
    $this->widgetSchema['email']->setLabel(libelle('msg_libelle_email'));
    $this->widgetSchema['email2']->setLabel(libelle('msg_libelle_email2'));
    $this->widgetSchema['telephone']->setLabel(libelle('msg_libelle_telephone'));
    $this->widgetSchema['fax']->setLabel(libelle('msg_libelle_fax'));
    $this->widgetSchema['adresse']->setLabel(libelle('msg_libelle_adresse'));
    $this->widgetSchema['adresse2']->setLabel(libelle('msg_libelle_adresse2'));
    $this->widgetSchema['adresse3']->setLabel(libelle('msg_libelle_adresse3'));
    $this->widgetSchema['code_postal']->setLabel(libelle('msg_libelle_code_postal'));
    $this->widgetSchema['complement_adresse']->setLabel(libelle('msg_libelle_complement_adresse'));
    $this->widgetSchema['information_libre']->setLabel(libelle('msg_contact_se_libelle_info_libre'));
    $this->widgetSchema['ville_id']->setLabel(libelle('msg_libelle_ville'));
    $this->widgetSchema['entite_id']->setLabel(libelle('msg_libelle_entite_affectation'));
  }

  private function configureValidators() {
    $this->validatorSchema['email'] = new sfValidatorEmail(array('required' => false), array('invalid' => libelle("msg_contact_se_valid_email_invalid")));
    $this->validatorSchema['email2'] = new sfValidatorEmail(array('required' => false), array('invalid' => libelle("msg_contact_se_valid_email_invalid")));
    $this->validatorSchema['telephone'] = new gridValidatorTelephone(array('required' => false), array('invalid' => libelle('msg_referentiel_telephone_invalide')));
    $this->validatorSchema['fax'] = new gridValidatorTelephone(array('required' => false), array('invalid' => libelle('msg_referentiel_fax_invalide')));
    $this->validatorSchema['code_postal'] = new gridValidatorCodePostal(array('required' => false), array('invalid' => libelle('msg_ville_code_postal_invalide')));
    $this->validatorSchema['entite_id'] = new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Entite')), array('required' => libelle('msg_contact_se_valid_entite_required')));
  }

  public function bind(array $taintedValues = null, array $taintedFiles = null)
  {
    if (strlen($taintedValues["code_postal"]) >= 2)
    {
      $this->widgetSchema['ville_id']->setOption('query', VilleTable::getInstance()->buildQueryVilleActifsOrdreAscPourSelectBox($taintedValues["code_postal"]));
    }

    parent::bind($taintedValues, $taintedFiles);
  }

}
