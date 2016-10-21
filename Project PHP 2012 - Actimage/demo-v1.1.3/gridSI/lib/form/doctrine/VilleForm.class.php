<?php

/**
 * Ville form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     William Richards
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class VilleForm extends BaseVilleForm {

  public function configure() {
    $this->useFields(array('departement_id', 'nom', 'code_postal'));

    $this->widgetSchema['departement_id'] = new sfWidgetFormDoctrineChoiceParametered(array('model' => $this->getRelatedModelName('Departement'),
                'add_empty' => libelle("msg_libelle_aucun"),
                'table_method' => array('method' => 'retrieveDepartements', 'parameters' => array(null,true)),
                'order_by' => array('code_departemental', 'asc'),
                ));

    

    $this->validatorSchema['code_postal'] = new gridValidatorCodePostal(array('required' => 'true'),
            array('required'  => libelle('msg_ville_code_postal_requis'),
                  'invalid'   => libelle('msg_referentiel_code_postal_invalide')
                        ));
    $this->widgetSchema['code_postal'] = new sfWidgetFormInputCodePostal();

    $this->validatorSchema['departement_id'] = new sfValidatorDoctrineChoice(array('required' => 'true', 'model' => $this->getRelatedModelName('Departement')), array('required' => libelle('msg_ville_departement_requis')));

    $this->validatorSchema['nom'] = new sfValidatorString(array('required' => 'true'),
                    array('required' => libelle('msg_ville_nom_requis')));

    $this->validatorSchema->setPostValidator( new sfValidatorDoctrineUnique(
            array('column' => array('nom','departement_id'),'model' => 'ville','throw_global_error' => false,'primary_key' => 'id'),
            array('invalid' => libelle('msg_ville_nom_unique'))));

    if ($this->getObject()->getDepartementId() != false){
        $this->widgetSchema['departement_id'] = new sfWidgetFormReadOnly(array('content' => array('model' => 'Departement')));
    }

    $this->widgetSchema->setLabels(array(
        'code_postal' => libelle('msg_ville_libelle_code_postal'),
        'nom' => libelle('msg_ville_libelle_nom'),
        'departement_id' => libelle('msg_ville_libelle_departement'),
    ));

    $this->disableCSRFProtection();
    parent::configure();
  }

}
