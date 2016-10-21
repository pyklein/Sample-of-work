<?php

/**
 * Point_contact form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     William Richards
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Point_contactForm extends BasePoint_contactForm
{
  public function configure()
  {
    $this->useFields(array('email','telephone','fax', 'ville_id', 'adresse', 'adresse2', 'adresse3', 'code_postal','complement_adresse','adresse_etrangere','pays_id'));
    
    $this->widgetSchema['code_postal'] = new gridWidgetFormCodePostal();
    $this->widgetSchema['code_postal']->setWidgetFormVille('point_contact_ville_id');

    $this->widgetSchema['email'] = new sfWidgetFormInputEmail();
    $this->widgetSchema['email2'] = new sfWidgetFormInputEmail();
    $this->widgetSchema['telephone'] = new sfWidgetFormInputTelephone();
    $this->widgetSchema['fax'] = new sfWidgetFormInputTelephone();

    $this->widgetSchema['ville_id'] = new gridWidgetFormVille(array('popup'=>true));
    if (!$this->getObject()->isNew())
    {
      $this->widgetSchema['ville_id']->setOption('query', VilleTable::getInstance()->buildQueryVilleActifsOrdreAscPourSelectBox($this->getObject()->getCodePostal()));
    }

    $this->widgetSchema['pays_id']  ->setOption('query', PaysTable::getInstance()->buildQueryPaysOrdreAscNom());
    $this->widgetSchema['pays_id']  ->setOption('add_empty', libelle('msg_libelle_aucun'));


    $this->validatorSchema['email'] = new sfValidatorAnd(array($this->validatorSchema['email'],new sfValidatorEmail()));
    $this->validatorSchema['email2'] = new sfValidatorAnd(array($this->validatorSchema['email2'],new sfValidatorEmail()));
    $this->validatorSchema['telephone'] = new gridValidatorTelephone();
    $this->validatorSchema['fax'] = new gridValidatorTelephone();

    $this->validatorSchema['code_postal'] = new gridValidatorCodePostal(array('required' => 'true'));
    $this->validatorSchema['email']->setOption('required', false);
    $this->validatorSchema['email2']->setOption('required', false);
    $this->validatorSchema['telephone']->setOption('required', false);
    $this->validatorSchema['fax']->setOption('required', false);
    $this->validatorSchema['code_postal']->setOption('required', false);

    $this->setLabels();
    $this->setMessagesErreur();
    $this->disableLocalCSRFProtection();
    parent::configure();
  }

  public function setMessagesErreur()
  {
    $this->getValidator('email')->setMessage('invalid' , libelle("msg_referentiel_email_invalide"));
    $this->getValidator('email2')->setMessage('invalid' , libelle("msg_referentiel_email_invalide"));
    $this->getValidator('telephone')->setMessage('invalid' , libelle("msg_referentiel_telephone_invalide"));
    $this->getValidator('fax')->setMessage('invalid' , libelle("msg_referentiel_fax_invalide"));
    $this->getValidator('ville_id')->setMessages(array(
        'invalid' => libelle("msg_referentiel_ville_id_invalide"))
    );
    $this->getValidator('code_postal')->setMessage('invalid' , libelle("msg_referentiel_code_postal_invalide"));
  }

  public function setLabels()
  {
    $this->widgetSchema->setLabels(array(
        'email'         => libelle("msg_libelle_email"),
        'email2'         => libelle("msg_libelle_email2"),
        'telephone'     => libelle("msg_libelle_telephone"),
        'fax'           => libelle("msg_libelle_fax"),
        'ville_id'      => libelle("msg_libelle_ville"),
        'adresse'       => libelle("msg_libelle_adresse"),
        'adresse2'      => libelle("msg_libelle_adresse2"),
        'adresse3'      => libelle("msg_libelle_adresse3"),
        'code_postal'   => libelle("msg_libelle_code_postal"),
        'complement_adresse' => libelle("msg_libelle_complement_adresse"),
        'pays_id'       => libelle('msg_libelle_pays_etranger'),
        'adresse_etrangere'  => libelle('msg_libelle_adresse_etrangere')
    ));
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
