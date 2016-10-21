<?php

/**
 * Budget form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BudgetForm extends BaseBudgetForm
{
  public function configure()
  {
    $this->useFields(array('budget_type_id','date_budget','montant','reference'));

    $this->widgetSchema['budget_type_id'] = new sfWidgetFormDoctrineChoice(array(
        'model' => $this->getRelatedModelName('Budget_type'),
        'add_empty' => false));

    $this->widgetSchema['date_budget'] = new sfWidgetFormInputJQueryDate();


    //validateurs
    $this->setValidator('date_budget', new gridValidatorDate(array('required' => true),array('required'=> libelle("msg_notification_champ_requis",array(libelle("msg_libelle_date"))))));
    $this->setValidator('montant',new gridValidatorFloat(
            array('required'=> true),
            array('required' => libelle("msg_notification_champ_requis",array(libelle("msg_libelle_montant_e"))),
                  'invalid'=> libelle("msg_form_error_champ_invalide"))));

    //Labels
    $this->widgetSchema->setLabels(array(
      'budget_type_id' => libelle("msg_libelle_type"),
      'date_budget'    => libelle("msg_libelle_date"),
      'montant'        => libelle("msg_libelle_montant_e"),
      'reference'      => libelle("msg_libelle_reference")
    ));

    $this->disableCSRFProtection();

    $this->widgetSchema->setNameFormat('budget_form[%s]');
    parent::configure();
  }
}
