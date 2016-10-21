<?php

/**
 * Action form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ActionForm extends BaseActionForm
{
  protected $inIdUtilisateur;

  public function __construct($intIdUtilisateur, $defaults = array(), $options = array(), $CSRFSecret = null) {
    $this->intIdUtilisateur = $intIdUtilisateur;
    parent::__construct($defaults, $options, $CSRFSecret);
  }
  
  public function configure()
  {
    $this->useFields(array('type_action_id','pilote_id','statut_action_id','date_echeance','date_action','description'));

    $this->widgetSchema['date_echeance'] = new sfWidgetFormInputJQueryDate();
    $this->setValidator('date_echeance', new gridValidatorDate(array('required' => true),array('required' => libelle("msg_action_champ_requis",array(libelle("msg_libelle_date_echeance_action"))))));

    $this->widgetSchema['date_action'] = new sfWidgetFormInputJQueryDate();
    $this->setValidator('date_action', new gridValidatorDate(array('required' => false)));

    $this->widgetSchema['description'] = new sfWidgetFormTextareaCKEditor();
    $this->setValidator('description',new gridValidatorTextarea(array('required' => true),array('required'=> libelle("msg_action_champ_requis",array(libelle("msg_libelle_description_action"))))));

    $this->widgetSchema['pilote_id'] = new sfWidgetFormDoctrineChoiceParametered(
                array('model' => 'Utilisateur',
                    'add_empty' => false,
                    'table_method' => array('method' => 'retrievePilotePotentielActionDossierBpi',
                    'parameters' => array($this->intIdUtilisateur))));
    
    $this->widgetSchema['type_action_id']->setLabel(libelle("msg_libelle_type_action"));
    $this->widgetSchema['pilote_id']->setLabel(libelle("msg_libelle_pilote_action"));
    $this->widgetSchema['statut_action_id']->setLabel(libelle("msg_libelle_statut_action"));
    $this->widgetSchema['date_echeance']->setLabel(libelle("msg_libelle_date_echeance_action"));
    $this->widgetSchema['date_action']->setLabel(libelle("msg_libelle_date_action"));
    $this->widgetSchema['description']->setLabel(libelle("msg_libelle_description_action"));

    $this->widgetSchema->setNameFormat('action_form[%s]');
    parent::configure();

  }
}
