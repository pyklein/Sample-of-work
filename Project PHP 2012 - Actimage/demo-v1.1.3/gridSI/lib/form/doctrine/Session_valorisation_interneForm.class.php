<?php

/**
 * Session_valorisation_interne form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Session_valorisation_interneForm extends BaseSession_valorisation_interneForm
{
  private $intDossierId;

  public function __construct($intDossierId, $object = null, $options = array(), $CSRFSecret = null)
  {
    $this->intDossierId = $intDossierId;

    parent::__construct($object, $options, $CSRFSecret);
  }

  public function configure()
  {
    $this->useFields(array('organisme_mindef_id', 'date_debut_exploitation', 'transaction_token'));

    // organisme
    $this->widgetSchema['organisme_mindef_id'] = new gridWidgetFormOrganismeMindef(array("model" => $this->getRelatedModelName('OrganismeMindef'), "popup" => true));
    $this->widgetSchema['organisme_mindef_id']->setLabel(libelle("msg_libelle_org_mindef"));
    $this->validatorSchema['organisme_mindef_id']->setMessage('invalid', libelle('msg_form_error_champ_invalide'));
    $this->validatorSchema['organisme_mindef_id']->setMessage('required', libelle('msg_form_error_champ_obligatoire'));
    
    $this->widgetSchema['date_debut_exploitation'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['date_debut_exploitation']->setLabel(libelle("msg_libelle_date_debut_exploitation"));
    $this->validatorSchema['date_debut_exploitation'] = new gridValidatorDate(array('required' => false));
    $this->validatorSchema['date_debut_exploitation']->setMessage('invalid', libelle('msg_form_error_champ_invalide'));
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
    $objSession = Session_valorisation_interneTable::getInstance()->getValorisationsInternesSessionByOrganismeDateToken($values['organisme_mindef_id'], $values['date_debut_exploitation'], $values['transaction_token']);

    if ($objSession)
    {
      $error = new sfValidatorError($validator, libelle('msg_form_error_champ_deja_existe'));

      throw new sfValidatorErrorSchema($validator, array('organisme_mindef_id' => $error,
                                                         'date_debut_exploitation' => $error));
    }

    return $values;
  }
}
