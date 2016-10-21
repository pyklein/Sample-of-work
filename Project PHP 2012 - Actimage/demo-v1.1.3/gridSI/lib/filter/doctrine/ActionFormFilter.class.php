<?php

/**
 * Action filter form.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ActionFormFilter extends BaseActionFormFilter
{
  protected $intIdDossierBpi;

  public function __construct($intIdDossier, $defaults = array(), $options = array(), $CSRFSecret = null) {
    $this->intIdDossierBpi = $intIdDossier;
    parent::__construct($defaults, $options, $CSRFSecret);
  }
  
  public function configure()
  {
    $this->widgetSchema['type_action_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Type_action'), 'add_empty' => 'Tous'));

    $this->widgetSchema['statut_action_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Statut_action'), 'add_empty' => 'Tous'));

    $this->widgetSchema['pilote_id'] = new sfWidgetFormDoctrineChoiceParametered(
                array('model' => 'Utilisateur',
                    'add_empty' => 'Tous',
                    'table_method' => array('method' => 'retrievePiloteActionDossierBpi',
                    'parameters' => array($this->intIdDossierBpi))));

    
    $this->useFields(array('type_action_id','statut_action_id','pilote_id'));

    $this->widgetSchema->setLabels(array(
        'type_action_id' => libelle("msg_libelle_type_action"),
        'statut_action_id' => libelle("msg_libelle_statut_action"),
        'pilote_id'=> libelle("msg_libelle_pilote_action")
    ));
  }
}
