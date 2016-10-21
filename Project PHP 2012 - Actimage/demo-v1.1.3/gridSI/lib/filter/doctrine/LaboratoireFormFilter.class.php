<?php

/**
 * Laboratoire filter form.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class LaboratoireFormFilter extends BaseLaboratoireFormFilter
{
  public function configure()
  {
    $this->useFields(array('organisme_id','service_id'));

    $this->configureWidgets();

    $this->configureLabelles();

    $this->configureValidators();

    $this->disableCSRFProtection();
  }

  private function configureWidgets()
  {
    $this->widgetSchema['organisme_id'] = new gridWidgetFormOrganisme(array('model' => $this->getRelatedModelName('Organisme')));
    $this->widgetSchema['service_id']   = new gridWidgetFormService();
  }

  private function configureLabelles()
  {
    $this->widgetSchema['organisme_id'] ->setLabel(libelle('msg_libelle_organisme'));
    $this->widgetSchema['service_id']   ->setLabel(libelle('msg_libelle_service'));
  }

  private function configureValidators()
  {
    $this->validatorSchema->setPostValidator(new sfValidatorCallback(array('callback' => array($this, 'validerDependences'))));
  }

  /**
   * Permet de valider si les dependences entre les differents valeurs saisies
   * @param object $validator
   * @param string[] $values
   * @return string[]
   * @author Gabor JAGER
   */
  public function validerDependences($validator, $values)
  {
    $arrErreurs = array();

    // valider le service
    if ($values['service_id'] != "" && $values['service_id'] != 0)
    {
      $objService = ServiceTable::getInstance()->getServiceActifById($values['service_id']);

      if ($objService == null)
      {
        $error = new sfValidatorError($validator, libelle('msg_form_error_champ_service'));
        $this->putErreur($arrErreurs, 'service_id', $error);
      }
      elseif (($objService->getOrganismeId() != $values['organisme_id']) && ($values['organisme_id'] != 0))
      {
        $error = new sfValidatorError($validator, libelle('msg_form_error_champ_service'));
        $this->putErreur($arrErreurs, 'service_id', $error);
      }
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
