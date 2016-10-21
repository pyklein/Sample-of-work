<?php

/**
 * Commission filter form.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CommissionFormFilter extends BaseCommissionFormFilter
{
  public function configure()
  {
    $this->setWidgets(array(
        'annee' => new sfWidgetFormDoctrineChoice(array(
            'model'        => 'Commission',
            'table_method' => 'getAnneesCommission',
            'method'       => 'getAnnee',
            'add_empty' => libelle('msg_libelle_toutes'))),
        'est_selection' => new sfWidgetFormChoice(array(
            'choices' => array(
                ''=> libelle("msg_libelle_toutes"),
                0 => libelle("msg_commission_libelle_est_preselection"),
                1 => libelle("msg_commission_libelle_est_selection"))
        )),
        'type_dossier_mris_id' => new sfWidgetFormDoctrineChoice(array(
            'model'        => 'Type_dossier_mris',
            'add_empty'    => libelle('msg_libelle_tous')
        ))
        ));

    $this->validatorSchema['annee'] = new sfValidatorPass();
    $this->widgetSchema->setNameFormat('commission_filters[%s]');

    $this->widgetSchema->setLabels(array(
       'annee' => libelle("msg_libelle_annee"),
       'est_selection'  =>libelle("msg_commission_type_commission_filtre"),
       'type_dossier_mris_id' => libelle('msg_libelle_type_dossier_mris')
    ));

    $this->useFields(array('annee','est_selection','type_dossier_mris_id'));
    $this->disableCSRFProtection();
  }

  public function  getFields() {
    $fields = parent::getFields();
    $fields['annee'] = 'Date';
    return $fields;
  }

   protected function addAnneeColumnQuery($query, $fiel, $value) {
    CommissionTable::getInstance()->appliquerFiltreAnnee($query, $value);
  }
}
