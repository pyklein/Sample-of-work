<?php

/**
 * Session_valorisation_externe form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Session_valorisation_externeForm extends BaseSession_valorisation_externeForm
{
  private $intDossierId;

  public function __construct($intDossierId, $object = null, $options = array(), $CSRFSecret = null)
  {
    $this->intDossierId = $intDossierId;

    parent::__construct($object, $options, $CSRFSecret);
  }
  
  public function configure()
  {
    $this->useFields(array('organisme_id', 'statut_valorisation_externe_id', 'contrat_id', 'transaction_token'));

    // organisme
    $this->widgetSchema['organisme_id'] = new gridWidgetFormOrganisme(array("model" => $this->getRelatedModelName('Organisme'), "popup" => true));
    $this->widgetSchema['organisme_id']->setLabel(libelle("msg_libelle_organisme"));
    $this->validatorSchema['organisme_id']->setMessage('invalid', libelle('msg_form_error_champ_invalide'));
    $this->validatorSchema['organisme_id']->setMessage('required', libelle('msg_form_error_champ_obligatoire'));

    // statut valorisation externe
    $this->widgetSchema['statut_valorisation_externe_id']->setLabel(libelle("msg_libelle_statut"));
    $this->validatorSchema['statut_valorisation_externe_id']->setMessage('invalid', libelle('msg_form_error_champ_invalide'));
    $this->validatorSchema['statut_valorisation_externe_id']->setMessage('required', libelle('msg_form_error_champ_obligatoire'));

    // contrat
    $this->widgetSchema['contrat_id'] = new sfWidgetFormDoctrineChoiceParametered(array("model" => $this->getRelatedModelName('Contrat')));
    $this->widgetSchema['contrat_id']->addOption('query', ContratTable::getInstance()->buildQueryContratOrdreAscPourSelectbox($this->intDossierId));
    $this->widgetSchema['contrat_id']->addOption('method', 'getNumeroMb');
    $this->widgetSchema['contrat_id']->addOption('add_empty', libelle('msg_libelle_aucun'));
    $this->widgetSchema['contrat_id']->setLabel(libelle("msg_libelle_contrat_associe"));
    $this->validatorSchema['contrat_id']->setMessage('invalid', libelle('msg_form_error_champ_invalide'));

    // post validateur
    $this->validatorSchema->setPostValidator(new sfValidatorCallback(array('callback' => array($this, 'checkCallback'))));

    $this->disableCSRFProtection();
    
    parent::configure();
  }

  /**
   * Permet d'effectuer la post-validation :
   * Si l'organisme, le statut et le contrat triple existe déja
   * @param object $validator
   * @param string[] $values
   * @return string[]
   */
  public function checkCallback($validator, $values)
  {
    $objSession = Session_valorisation_externeTable::getInstance()->getValorisationsExternesSessionByOrganismeStatutContratToken($values['organisme_id'], $values['statut_valorisation_externe_id'], $values['contrat_id'], $values['transaction_token']);

    if ($objSession)
    {
      $error = new sfValidatorError($validator, libelle('msg_form_error_champ_deja_existe'));

      throw new sfValidatorErrorSchema($validator, array('organisme_id' => $error,
                                                         'statut_valorisation_externe_id' => $error,
                                                         'contrat_id' => $error));
    }

    return $values;
  }
}
