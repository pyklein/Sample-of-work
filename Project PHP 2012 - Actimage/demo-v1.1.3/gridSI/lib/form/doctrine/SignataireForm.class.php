<?php

/**
 * Signataire form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class SignataireForm extends BaseSignataireForm
{
  public function configure()
  {
    $this->useFields(array(
        'organisme_id',
        'service_id'
    ));

    $this->configureWidgets();
    
    $this->configureLibelles();

    $this->configureValidators();

    $this->disableCSRFProtection();

    parent::configure();
  }

  private function configureWidgets()
  {
    $this->widgetSchema['organisme_id'] = new gridWidgetFormOrganisme(array('model' => $this->getRelatedModelName('Organisme'), "popup" => true));
    $this->widgetSchema['service_id']   = new gridWidgetFormService(array("popup" => true));
  }

  private function configureLibelles()
  {
    $this->widgetSchema['organisme_id'] ->setLabel(libelle('msg_contrat_libelle_signataire_organisme'));
    $this->widgetSchema['service_id']   ->setLabel(libelle('msg_contrat_libelle_signataire_service'));
  }

  private function configureValidators()
  {
    $this->validatorSchema['organisme_id'] = new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Organisme'), 'required' => true),
                                                                           array('required'=> libelle('msg_contrat_signataire_organisme_obligatoir')));
    $this->validatorSchema['service_id'] = new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Service'), 'required' => false),
                                                                           array('invalid'=> libelle('msg_contrat_signataire_service_obligatoir')));
    $this->validatorSchema->setPostValidator(new sfValidatorCallback(array('callback' => array($this, 'validerDependences'))));
  }

  public function validerDependences($validator, $values)
  {
    $arrErreurs = array();

    //Valider l'organisme du service
    if (isset ($values['organisme_id']) &&
        isset ($values['service_id']) &&
        !ServiceTable::getInstance()->estCompatibleServiceAvecOrganisme($values['service_id'],$values['organisme_id']))
    {
      $error = new sfValidatorError($validator, libelle('msg_service_err_incompatible_organisme'));
      $this->putErreur($arrErreurs, 'service_id', $error);
    }

    // s'il y a des erreurs on balance l'exception
    if (count($arrErreurs) > 0)
    {
      throw new sfValidatorErrorSchema($validator, $arrErreurs);
    }

    return $values;
  }

  /**
   * Permet de rajouter un erreur aux erreur schema
   * @param array $arrErreurs tableauy des erreurs déjà detectés
   * @param string $strChamp nom du champ
   * @param sfValidatorError $objErreur
   * @author Gabor JAGER
   */
  private function putErreur(&$arrErreurs, $strChamp, $objErreur)
  {
    if (!isset($arrErreurs[$strChamp]))
    {
      $arrErreurs[$strChamp] = $objErreur;
    }

    else if (!is_array($arrErreurs[$strChamp]))
    {
      $arrErreurs[$strChamp] = array($arrErreurs[$strChamp], $objErreur);
    }

    else
    {
      $arrErreurs[$strChamp] = array_push($arrErreurs[$strChamp], $objErreur);
    }
  }
}
