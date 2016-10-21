<?php

/**
 * Commission form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CommissionForm extends BaseCommissionForm {

  public function configure() {
    $this->useFields(array('type_dossier_mris_id', 'est_selection', 'date_debut', 'date_fin', 'est_suivi', 'est_analyse', 'ordre_jour'));

    $this->setWidgets(array(
        'est_selection'        => new gridWidgetFormChoiceRadioAligne(array(
            'choices'     => array(
                0 => libelle("msg_commission_libelle_est_preselection"),
                1 => libelle("msg_commission_libelle_est_selection")),
        )),
        'type_dossier_mris_id' => new sfWidgetFormDoctrineChoice(array(
            'model'       => 'Type_dossier_mris',
            'add_empty'   => false
        )),
        'date_debut'           => new sfWidgetFormJQueryDateTime(),
        'date_fin'             => new sfWidgetFormJQueryDateTime(),
        'est_suivi'            => $this->widgetSchema['est_suivi'],
        'est_analyse'          => $this->widgetSchema['est_analyse'],
        'ordre_jour'           => new sfWidgetFormTextareaCKEditor()
    ));

    $this->setValidators(array(
        'est_selection'        => new sfValidatorBoolean(),
        'type_dossier_mris_id' => new sfValidatorDoctrineChoice(array(
            'model'       => 'Type_dossier_mris',
        )),
        'date_debut'           => new gridValidatorDateTime(),
        'date_fin'             => new gridValidatorDateTime(),
        'est_suivi'            => $this->validatorSchema['est_suivi'],
        'est_analyse'          => $this->validatorSchema['est_analyse'],
        'ordre_jour'           => new gridValidatorTextarea(array('required'=>FALSE)),
    ));

    $this->widgetSchema->setLabels(array(
        'est_selection'        => libelle("msg_commission_form_type_selection"),
        'type_dossier_mris_id' => libelle("msg_commission_form_type_dossier"),
        'date_debut'           => libelle("msg_commission_form_date_debut"),
        'date_fin'             => libelle("msg_commission_form_date_fin"),
        'est_suivi'            => libelle("msg_commission_form_est_suivi"),
        'est_analyse'          => libelle("msg_commission_form_est_analyse"),
        'ordre_jour'           => libelle("msg_commission_form_ordre_du_jour")
            ));
    $this->widgetSchema->setNameFormat('commission_forme[%s]');

    $this->validatorSchema->setPostValidator(
      new sfValidatorSchemaCompare('date_fin', sfValidatorSchemaCompare::GREATER_THAN_EQUAL , 'date_debut',
        array(),
        array('invalid' => libelle('msg_commission_dates_invalides'))
      ));

    $this->validatorSchema->setPostValidator(
              new sfValidatorCallback(array('callback' => array($this, 'validationType')))
      );

    $this->disableCSRFProtection();

    parent::configure();
  }

  //Vérifie qu'au moins un des deux champs "Suivi des dossiers" ou "Analyse des propositions" soit coché
  public function validationType($validator, $values)
  {
    if ($values['est_suivi'] == false && $values['est_analyse'] == false)
    {
       $error = new sfValidatorError($validator, libelle('msg_commission_choix_types'));
       throw new sfValidatorErrorSchema($validator, array('est_analyse' => $error));
    }
    return $values;
  }

}
