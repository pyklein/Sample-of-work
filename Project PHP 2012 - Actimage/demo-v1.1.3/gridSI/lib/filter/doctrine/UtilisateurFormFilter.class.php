<?php

if (sfContext::hasInstance())
{
  sfContext::getInstance()->getConfiguration()->loadHelpers('Libelle');
} else
{
  $configuration = ProjectConfiguration::getApplicationConfiguration('gridweb', 'prod', true);
  $context = sfContext::createInstance($configuration);
  $configuration->loadHelpers('Libelle');
}

//sfContext::getInstance()->getConfiguration()->loadHelpers("Libelle");

/**
 * Utilisateur filter form.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class UtilisateurFormFilter extends BaseUtilisateurFormFilter
{
  /**
   * Surcharge la methode du parrent et personnalise
   *
   * @author Simeon PETEV
   */
  public function configure()
  {
    $this->useFields(array('nom',
                           'organisme_mindef_id',
                           'entite_id'));

    $this->configureWidgets();

    $this->configureLibelles();

    $this->configureValidateurs();

    $this->disableCSRFProtection();
  }


  private function configureWidgets()
  {
    $this->widgetSchema['organisme_mindef_id']  = new gridWidgetFormOrganismeMindef(array('model'=>$this->getRelatedModelName('Organisme_mindef')));
    $this->widgetSchema['entite_id']            = new gridWidgetFormEntite(array('model'=>$this->getRelatedModelName('Entite')));

    $this->setWidget('profil_id', new sfWidgetFormDoctrineChoice(array('model' => 'Profil',
                                                                        'order_by' => array('intitule','ASC'),
                                                                        'add_empty' => libelle("msg_libelle_tous"),
                                                                        'label' => libelle("msg_utilisateur_libelle_profil"),
                                                                        'query' =>  ProfilTable::getInstance()->getQueryTousOrdreASC()
                                                                       )
                                                                 )
                    );
  }

  private function configureLibelles()
  {
    $this->widgetSchema['nom']                  ->setLabel(libelle("msg_utilisateur_libelle_filtre_nom"));
    $this->widgetSchema['organisme_mindef_id']  ->setLabel(libelle("msg_libelle_org_mindef"));
    $this->widgetSchema['entite_id']            ->setLabel(libelle("msg_utilisateur_libelle_entite_affect"));
  }

  private function configureValidateurs()
  {
    $this->validatorSchema['profil_id'] =  new sfValidatorDoctrineChoice(array('required' => false,
                                                                          'model' => 'Profil',
                                                                          'column' => 'id'
                                                                         )
                                                                   );

    $this->validatorSchema->setPostValidator(new sfValidatorCallback(array('callback' => array($this, 'validerDependences'))));
  }

  public function validerDependences($validator, $values)
  {
    $arrErreurs = array();

    if ((isset($values['entite_id'])) &&
        (isset($values['organisme_mindef_id'])) &&
        (!EntiteTable::getInstance()->estCompatibleEntiteAvecOrganismeMindef($values['entite_id'],$values['organisme_mindef_id'])))
    {
      $error = new sfValidatorError($validator, libelle('msg_entite_err_incompatible_org_mindef'));
      $this->putErreur($arrErreurs, 'entite_id', $error);
    }

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
