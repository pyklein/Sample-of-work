<?php

/**
 * Etudiant form.
 * Onglet Informations générales
 * @package    gridSI
 * @subpackage form
 * @author     Jihad Sahebdin
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class EtudiantForm extends BaseEtudiantForm
{
  public function configure()
  {
    $this->useFields(array('civilite_id','nom','nom_jeunefille','prenom','date_naissance','lieu_naissance','email','email2','adresse','adresse2','adresse3','code_postal','ville_id','complement_adresse','telephone_fixe','telephone_mobile','pays_id','nationalite_id', 'adresse_etrangere'));

    $this->configurerValidateurs();
    $this->configurerLabels();

    $this->disableCSRFProtection();
    parent::configure();
  }

  private function configurerLabels()
  {
    $this->widgetSchema['civilite_id'] = new sfWidgetFormDoctrineChoice(
            array('model' => $this->getRelatedModelName('Civilite'),
                  'order_by' => array('id','desc'),
                  'add_empty' => false,
                  'expanded' => true),
            array('class' => 'radio_liste_horizontale')
            );

    $this->widgetSchema['date_naissance'] = new sfWidgetFormInputJQueryDate();

    $this->widgetSchema['email'] = new sfWidgetFormInputEmail();
    $this->widgetSchema['email2'] = new sfWidgetFormInputEmail();

    $this->widgetSchema['code_postal'] = new gridWidgetFormCodePostal();
    $this->widgetSchema['code_postal']->setWidgetFormVille('etudiant_ville_id');
    $this->widgetSchema['ville_id'] = new gridWidgetFormVille(array('model' => $this->getRelatedModelName('Ville'), 'popup'=>true));
    if (!$this->getObject()->isNew())
    {
      $this->widgetSchema['ville_id']->setOption('query', VilleTable::getInstance()->buildQueryVilleActifsOrdreAscPourSelectBox($this->getObject()->getCodePostal()));
    }

    $this->widgetSchema['telephone_fixe'] = new sfWidgetFormInputTelephone();
    $this->widgetSchema['telephone_mobile'] = new sfWidgetFormInputTelephone();
    
    $this->widgetSchema['civilite_id']->setLabel(libelle("msg_libelle_etudiant_civilite"));
    $this->widgetSchema['nom']->setLabel(libelle("msg_libelle_etudiant_nom"));
    $this->widgetSchema['nom_jeunefille']->setLabel(libelle("msg_libelle_etudiant_nom_jeunefille"));
    $this->widgetSchema['prenom']->setLabel(libelle("msg_libelle_etudiant_prenom"));
    $this->widgetSchema['date_naissance']->setLabel(libelle("msg_libelle_etudiant_date_naissance"));
    $this->widgetSchema['lieu_naissance']->setLabel(libelle("msg_libelle_etudiant_lieu_naissance"));
    $this->widgetSchema['email']->setLabel(libelle("msg_libelle_etudiant_email"));
    $this->widgetSchema['email2']->setLabel(libelle("msg_libelle_etudiant_email2"));
    $this->widgetSchema['adresse']->setLabel(libelle("msg_libelle_adresse"));
    $this->widgetSchema['adresse2']->setLabel(libelle("msg_libelle_adresse2"));
    $this->widgetSchema['adresse3']->setLabel(libelle("msg_libelle_adresse3"));
    $this->widgetSchema['complement_adresse']->setLabel(libelle("msg_libelle_etudiant_complement_adresse"));
    $this->widgetSchema['telephone_fixe']->setLabel(libelle("msg_libelle_etudiant_telephone_fixe"));
    $this->widgetSchema['telephone_mobile']->setLabel(libelle("msg_libelle_etudiant_telephone_mobile"));
    $this->widgetSchema['pays_id']  ->setOption('query', PaysTable::getInstance()->buildQueryPaysOrdreAscNom());
    $this->widgetSchema['pays_id']  ->setOption('add_empty', libelle('msg_libelle_aucun'));
    $this->widgetSchema['pays_id']  ->setLabel(libelle('msg_libelle_pays_etranger'));
    $this->widgetSchema['nationalite_id']  ->setOption('query', PaysTable::getInstance()->buildQueryPaysOrdreAscNom());
    $this->widgetSchema['nationalite_id']  ->setOption('add_empty', libelle('msg_libelle_aucune'));
    $this->widgetSchema['nationalite_id']  ->setLabel(libelle('msg_libelle_nationalite'));
    $this->widgetSchema['adresse_etrangere']->setLabel(libelle('msg_libelle_adresse_etrangere'));

  }

  private function configurerValidateurs()
  {
    $this->validatorSchema['civilite_id'] = new sfValidatorDoctrineChoice(
            array('model' => $this->getRelatedModelName('Civilite'),
                  'required'=>true),
            array('required'=> libelle('msg_etudiant_champ_requis',array(libelle('msg_libelle_etudiant_civilite')))));

    $this->validatorSchema['nom'] = new sfValidatorString(array('required'=>true),
            array('required'=> libelle('msg_etudiant_champ_requis',array(libelle('msg_libelle_etudiant_nom')))));

    $this->validatorSchema['prenom'] = new sfValidatorString(array('required'=>true),
            array('required'=> libelle('msg_etudiant_champ_requis',array(libelle('msg_libelle_etudiant_prenom')))));
    
    $this->validatorSchema['date_naissance'] = new gridValidatorDate(array(
                    'required' => false,
                    ));

    $this->validatorSchema['email'] = new sfValidatorEmail(array('required'=>false),
            array('invalid' => libelle('msg_etudiant_champ_invalide',array(libelle('msg_libelle_etudiant_email')))
                ));
    
     $this->validatorSchema['email2'] = new sfValidatorEmail(array('required'=>false),
            array('invalid' => libelle('msg_etudiant_champ_invalide',array(libelle('msg_libelle_etudiant_email')))
                ));
    
    $this->validatorSchema['code_postal'] = new gridValidatorCodePostal(array('required' => false),
            array('required'  => libelle('msg_ville_code_postal_requis'),
                  'invalid'   => libelle('msg_referentiel_code_postal_invalide')
                        ));

    $this->validatorSchema['ville_id']= new sfValidatorDoctrineChoice(array(
        'model' => $this->getRelatedModelName('Ville'),
        'required' => false));

    $this->validatorSchema['telephone_fixe'] = new gridValidatorTelephone(array('required'=>false),
            array('invalid' => libelle('msg_etudiant_telephone_invalide')));
    
    $this->validatorSchema['telephone_mobile'] = new gridValidatorTelephone(array('required'=>false),
            array('invalid' => libelle('msg_etudiant_telephone_invalide')));

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
