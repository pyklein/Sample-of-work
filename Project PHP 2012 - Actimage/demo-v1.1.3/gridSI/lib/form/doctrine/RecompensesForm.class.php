<?php

/**
 * Recompenses form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Alexandre WETTA
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class RecompensesForm extends BaseRecompensesForm
{

  public function  __construct($partInventiveId, $object = null, $options = array(), $CSRFSecret = null) {

    $this->partInventiveId = $partInventiveId ;
    
    parent::__construct($object, $options, $CSRFSecret);
  }


  public function configure()
  {

    $this->useFields(array('date_versement_20', 'date_versement_80' , 'date_decision_recompense'));

    //recherche de Exploitation Interne
    $objExpInterne = Exploitation_interneTable::getInstance()->findOneByPartInventiveId($this->partInventiveId);
    if($objExpInterne == null){
      $objExpInterne = new Exploitation_interne();
      $objExpInterne->setPartInventiveId($this->partInventiveId);
    }
    
    $formExpInterne = new Exploitation_interneForm($objExpInterne);
    $this->embedForm('Exploitation_interne', $formExpInterne);

    //set widget
    $this->widgetSchema['date_versement_20'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['date_versement_80'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['date_decision_recompense'] = new sfWidgetFormInputJQueryDate();

    //validateurs
    $this->validatorSchema['date_versement_20'] = new gridValidatorDate(array('required' => false));
    $this->validatorSchema['date_versement_80'] = new gridValidatorDate(array('required' => false));
    $this->validatorSchema['date_decision_recompense'] = new gridValidatorDate(array('required' => false));

    //set des libellés
     $this->widgetSchema->setLabels(array(
      'date_versement_20'        => libelle('msg_libelle_recompenses_date_versement_20'),
      'date_versement_80'        => libelle('msg_libelle_recompenses_date_versement_80'),
      'date_decision_recompense' => libelle('msg_libelle_recompenses_date_decision_recompense'),
    ));



    $this->disableLocalCSRFProtection();
    parent::configure();
  }
}
