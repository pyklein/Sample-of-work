<?php

/**
 * Contentieux form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ContentieuxForm extends BaseContentieuxForm {

  public function configure() {

    $this->useFields(array('est_desaccord', 'commentaire_desaccord',
        'date_demande_cnis', 'date_cnis', 'decision_cnis', 'date_accord'));

    //set widgets
    $this->widgetSchema['est_desaccord'] = new gridWidgetFormChoiceRadioAligne(array(
                'choices' => array('1' => libelle('msg_libelle_oui'),
                    '0' => libelle('msg_libelle_non')),
            ));
    $this->widgetSchema['commentaire_desaccord'] = new sfWidgetFormTextareaCKEditor();
    $this->widgetSchema['decision_cnis'] = new sfWidgetFormTextareaCKEditor();
    $this->widgetSchema['date_demande_cnis'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['date_cnis'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['date_accord'] = new sfWidgetFormInputJQueryDate();

    //set validateurs
    $this->validatorSchema['date_demande_cnis'] = new gridValidatorDate(array('required' => false));
    $this->validatorSchema['date_cnis'] = new gridValidatorDate(array('required' => false));
    $this->validatorSchema['date_accord'] = new gridValidatorDate(array('required' => false));
    $this->validatorSchema['commentaire_desaccord'] = new gridValidatorTextarea(array('required'=>FALSE));
    $this->validatorSchema['decision_cnis'] = new gridValidatorTextarea(array('required'=>FALSE));
    
    $this->validatorSchema->setPostValidator(new sfValidatorAnd(array(
                new sfValidatorCallback(array('callback' => array($this, 'checkInformationCnis'))),
                new sfValidatorCallback(array('callback' => array($this, 'checkDecisionCnis'))),
            )));


    //Labels
    $this->widgetSchema->setLabels(array(
        'est_desaccord' => libelle("msg_libelle_contentieux_est_desaccord"),
        'commentaire_desaccord' => libelle("msg_libelle_contentieux_commentaire_desaccord"),
        'date_demande_cnis' => libelle("msg_libelle_contentieux_date_demande_cnis"),
        'date_cnis' => libelle("msg_libelle_contentieux_date_cnis"),
        'decision_cnis' => libelle("msg_libelle_contentieux_decision_cnis"),
        'date_accord' => libelle("msg_libelle_contentieux_date_accord"),
    ));

    $this->disableLocalCSRFProtection();
    parent::configure();
  }

  /**
   * Permet de vérifier que les informations relatives à la CNIS ne soient prises en compte seulement si un désaccord est manifesté
   * @param object $validator
   * @param string[] $values
   * @return string[]
   * @author Alexandre WETTA
   */
  public function checkInformationCnis($validator, $values) {

    if ($values['date_demande_cnis'] != "" || $values['date_cnis'] != "" || $values['decision_cnis'] != "") {
      if (!$values['est_desaccord']) {
        $error = new sfValidatorError($validator, libelle('msg_contentieux_information_cnis_erreur', array(libelle('msg_libelle_oui'))));
        // throw an error bound to the val field
        throw new sfValidatorErrorSchema($validator, array('est_desaccord' => $error));
      }
    }
    return $values;
  }

   /**
   * Permet de vérifier que la décision de la CNIS n'est prise en compte que si une date CNIS est renseignée
   * @param object $validator
   * @param string[] $values
   * @return string[]
   * @author Alexandre WETTA
   */
  public function checkDecisionCnis($validator, $values) {

    //si le champ décision CNIS est renseigné mais pas celui de la date CNIS, on envoie une erreur
    if ($values['decision_cnis'] != "" && $values['date_cnis'] == "") {

        $error = new sfValidatorError($validator, libelle('msg_contentieux_decision_cnis_erreur',array(libelle('msg_libelle_contentieux_date_cnis'))));
        // throw an error bound to the val field
        throw new sfValidatorErrorSchema($validator, array('date_cnis' => $error));

    }
    return $values;
  }

}
