<?php

/**
 * Entite form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class EntiteForm extends BaseEntiteForm {

  public function configure() {
    $this->useFields(array(
        'entite_id',
        'organisme_mindef_id',
        'abreviation',
        'lieu',
        'ville_id',
        'intitule',
        'est_executant',
        'code_executant'
    ));

    //si il y a le paramètre entite dans l'URL alors on filtre les entité dans le selectBox "entite_id"
    //et on filtre la liste des organismes mindef
    if (sfContext::getInstance()->getRequest()->hasParameter('entite_id')) {
      $entiteId = sfContext::getInstance()->getRequest()->getParameter('entite_id');

      $this->widgetSchema['entite_id'] = new sfWidgetFormDoctrineChoiceParametered(array(
                  'model' => 'Entite',
                  'table_method' => array('method' => 'retrieveEntiteByEntiteIdOrId', 'parameters' => array($entiteId)),
                  'method' => 'getNomHierarchique',
                  'order_by' => array('intitule', 'asc'),
              ));

      // les organismes MINDEF pour le selectBox
      $this->widgetSchema['organisme_mindef_id']
              = new sfWidgetFormDoctrineChoiceParametered(array(
                  'model' => 'Organisme_mindef',
                  'table_method' => array('method' => 'retrieveOrgMindefByEntiteId', 'parameters' => array($entiteId)),
                  'method' => 'getAbreviation',
                  'order_by' => array('intitule', 'asc'),
              ));
    } else {


      $this->widgetSchema['entite_id'] = new sfWidgetFormDoctrineChoiceParametered(array(
                  'model' => 'Entite',
                  'add_empty' => libelle('msg_libelle_aucune'),
                  'table_method' => array('method' => 'retrieveEntiteFiltre', 'parameters' => array(null)),
                  'method' => 'getNomHierarchique',
                  'order_by' => array('intitule', 'asc'),
              ));

      $this->widgetSchema['organisme_mindef_id']->setOption('table_method', 'retrieveOrganismesMindefActif');
      $this->widgetSchema['organisme_mindef_id']->setOption('method', 'getAbreviation');
    }

    // on configure les libellés
    $this->setLibelles();

    // on configure les validateurs
    $this->setValidateurs();

    $this->disableLocalCSRFProtection();
    parent::configure();
  }

  //Configure les libellés
  private function setLibelles() {

    $this->widgetSchema->setLabels(array('intitule' => libelle('msg_entite_libelle_intitule'),
        'abreviation' => libelle('msg_entite_libelle_abreviation'),
        'lieu' => libelle('msg_entite_libelle_lieu'),
        'ville_id' => libelle('msg_entite_libelle_ville'),
        'organisme_mindef_id' => libelle('msg_entite_libelle_organisme_mindef'),
        'entite_id' => libelle('msg_entite_libelle_entite'),
        'est_executant' => libelle('msg_entite_libelle_est_executant'),
    ));
  }

  //Configure les validateurs
  private function setValidateurs() {

    // si c'est une nouvelle entite, on vérifie si elle existe déjà
    if ($this->isNew()) {

      $this->validatorSchema->setPostValidator(new sfValidatorAnd(array(
                  new sfValidatorDoctrineUnique(array('model' => 'Entite', 'column' => array('abreviation'), 'throw_global_error' => false), array('invalid' => libelle('msg_entite_creer_abreviation_existe'))),
                  new sfValidatorDoctrineUnique(array('model' => 'Entite', 'column' => array('intitule'), 'throw_global_error' => false), array('invalid' => libelle('msg_entite_creer_entite_existe'))),
                  new sfValidatorCallback(array('callback' => array($this, 'checkCodeExecutant'))),
                  new sfValidatorCallback(array('callback' => array($this, 'checkEntite')))
              )));

      $this->validatorSchema['intitule'] = new sfValidatorString(array('required' => 'true'), array('required' => libelle('msg_referentiel_intitule_requis')));

      $this->validatorSchema['abreviation'] = new sfValidatorString(array('required' => 'true'), array('required' => libelle('msg_referentiel_abreviation_requis')));
    } else {

      $this->validatorSchema->setPostValidator(new sfValidatorAnd(array(
                  new sfValidatorCallback(array('callback' => array($this, 'checkCodeExecutant'))),
                  new sfValidatorCallback(array('callback' => array($this, 'checkEntite')))
              )));

      $this->validatorSchema['intitule'] = new sfValidatorString(array('required' => 'true'), array('required' => libelle('msg_referentiel_intitule_requis')));

      $this->validatorSchema['abreviation'] = new sfValidatorString(array('required' => 'true'), array('required' => libelle('msg_referentiel_abreviation_requis')));
    }


    $this->validatorSchema['lieu'] = new sfValidatorString(array('required' => 'true'),
                    array('required' => libelle('msg_referentiel_lieu_requis')));

    $this->disableLocalCSRFProtection();
  }

  /**
   * Permet de vérifier que la chechbox "est_executant" est à true lorsqu'il y a un code executant
   * @param object $validator
   * @param string[] $values
   * @return string[]
   */
  public function checkCodeExecutant($validator, $values) {

    if ($values['code_executant'] != "" && $values['est_executant'] === false) {
      $error = new sfValidatorError($validator, libelle('msg_entite_creer_code_executant_erreur'));
      // throw an error bound to the val field
      throw new sfValidatorErrorSchema($validator, array('code_executant' => $error));
    }

    return $values;
  }

  /**
   * Vérifie si l'entite correspond à l'organisme MINDEF
   * @param object $validator
   * @param string[] $values
   * @return string[]
   */
  public function checkEntite($validator, $values) {

    // si il n'y a pas d'entité ID on ne check pas
    if ($values['entite_id'] != "") {
      $boolEstCompatibleAvecMindef = EntiteTable::getInstance()->estCompatibleEntiteAvecOrganismeMindef(
                      $values['entite_id'],
                      $values['organisme_mindef_id']
      );
      //si l'entité ID et l'organisme MINDEF ne correspondent pas, on affiche une erreur
      if (!$boolEstCompatibleAvecMindef) {
        $error = new sfValidatorError($validator, libelle('msg_entite_compatible_org_mindef_erreur'));
        // throw an error bound to the val field
        throw new sfValidatorErrorSchema($validator, array('entite_id' => $error));
      }
    }


    return $values;
  }

}
