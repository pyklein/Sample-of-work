<?php

/**
 * Redevance form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class RedevanceForm extends BaseRedevanceForm {

  public function __construct($dossierId, $object = null, $options = array(), $CSRFSecret = null) {

    $this->dossierId = $dossierId;

    parent::__construct($object, $options, $CSRFSecret);
  }

  public function configure() {

    $this->useFields(array('type_redevance_id', 'organisme_id', 'montant', 'contrat_id', 'date_versement'));

    $this->widgetSchema['type_redevance_id'] = new sfWidgetFormDoctrineChoice(array(
                'model' => $this->getRelatedModelName('Type_redevance'),
                'add_empty' => false,
                'method' => 'getIntitule'
            ));


    $this->widgetSchema['organisme_id'] = new sfWidgetFormDoctrineChoice(array(
                'model' => $this->getRelatedModelName('Organisme'),
                'table_method' => 'buildQueryOrganismesActifsOrdreAscPourSelectbox',
                'method' => 'getIntitule',
                'add_empty' => false,
                    )
    );

        $this->widgetSchema['contrat_id'] = new gridWidgetFormContrat(array(
                'table_method' => array('method' => 'retrieveQueryContratParDossierPourSelectbox', 'parameters' => array($this->dossierId)),
                    )
    );

    $this->widgetSchema['date_versement'] = new sfWidgetFormInputJQueryDate();


    //validateurs
    $this->validatorSchema['date_versement'] = new gridValidatorDate(array('required' => false));


    $this->validatorSchema['montant'] = new sfValidatorRegex(array('pattern' => '/^[0-9]+\.?[0-9]{0,2}$/', 'required' => false),
                    array('invalid' => libelle('msg_libelle_montant_invalide'))
    );

    $this->validatorSchema->setPostValidator(
            new sfValidatorCallback(array('callback' => array($this, 'checkTypeContrat')))
    );



    //Labels
    $this->widgetSchema->setLabels(array(
        'type_redevance_id' => libelle("msg_libelle_type_redevance"),
        'organisme_id' => libelle("msg_libelle_organisme_concerne"),
        'montant' => libelle("msg_libelle_montant"),
        'contrat_id' => libelle("msg_libelle_contrat_correspondant"),
        'date_versement' => libelle("msg_libelle_date_versement"),
    ));
    $this->widgetSchema->setNameFormat('redevance_form[%s]');

    $this->disableLocalCSRFProtection();
    parent::configure();
  }

  /**
   * Permet de vérifier que le type du contrat et de la redevance correspondent
   * @param object $validator
   * @param string[] $values
   * @return string[]
   */
  public function checkTypeContrat($validator, $values) {

    if ($values['contrat_id'] != "") {

      //on cherche le type de contrat du contrat selectionné
      $arrContratTypeContrat = Contrat_type_contratTable::getInstance()->findByContratId($values['contrat_id']);

      foreach ($arrContratTypeContrat as $objContratTypeContrat) {
        if ($values['type_redevance_id'] == Type_redevanceTable::CESSION && $objContratTypeContrat->getTypeContratId() == Type_contratTable::Cession) {
          return $values;
        }

        if ($values['type_redevance_id'] == Type_redevanceTable::LICENSE && $objContratTypeContrat->getTypeContratId() == Type_contratTable::Licence) {
          return $values;
        }
      }

      $error = new sfValidatorError($validator, libelle('msg_redevance_type_contrat_erreur'));

      throw new sfValidatorErrorSchema($validator, array('contrat_id' => $error));
    }

    return $values;
  }

}
