<?php

/**
 * Evenement_mip filter form.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Evenement_mipFormFilter extends BaseEvenement_mipFormFilter {

  protected $intIdDossierMip;

  public function __construct($intIdDossier, $defaults = array(), $options = array(), $CSRFSecret = null) {
    $this->intIdDossierMip = $intIdDossier;
    parent::__construct($defaults, $options, $CSRFSecret);
  }

  public function configure() {


    $this->setWidgets(array(
        'created_by' => new sfWidgetFormDoctrineChoiceParametered(
                array('model' => 'Utilisateur',
                    'add_empty' => 'Tous',
                    'table_method' => array('method' => 'retrieveAuteursEvenementsDossierMip',
                        'parameters' => array($this->intIdDossierMip))
        )),
        'date' => new sfWidgetFormFilterDate(array(
            'from_date' => new sfWidgetFormInputJQueryDate(),
            'to_date' => new sfWidgetFormInputJQueryDate(),
            'with_empty' => false,
            'template' => "%from_date% <b>" . libelle("msg_remarque_et_le") . "</b> : %to_date%"
        )),
        'est_cloture' => new sfWidgetFormChoice(array(
            'choices' => array('' => libelle('msg_libelle_tous'),
                               1 => libelle("msg_evenement_etat_cloture"),
                               0 => libelle("msg_evenement_etat_non_cloture"),
                               )
           ))
    ));

    $this->setValidators(array(
        'date' => new sfValidatorDateRange(array(
            'from_date' => new gridValidatorDate(array('required' => false)),
            'to_date' => new gridValidatorDate(array('required' => false)),
            'required' => false
                ), array(
            'invalid' => libelle('msg_remarque_mip_date_incoherente')
        )),
        'created_by' => new sfValidatorDoctrineChoice(
                array(
                    'model' => 'Utilisateur',
                    'required' => false)
            ),
        'est_cloture' => new sfValidatorChoice(array('required' => false, 'choices' => array('',0,1)))));

    $this->widgetSchema->setLabels(array(
        'created_by' => libelle("msg_remarque_auteur"),
        'date' => libelle("msg_evenement_mip_libelle_date"),
        'est_cloture'=> libelle("msg_evenement_mip_libelle_cloture")
    ));

    $this->useFields(array('created_by', 'date','est_cloture'));

    $this->disableCSRFProtection();

    $this->widgetSchema->setNameFormat('evenement_mip_filters[%s]');
    parent::configure();
  }

  public function dobuildQuery(array $values) {
    //si filtre par date, ajout d'un jour à la date max (pour inclure date sup)
    if  (array_key_exists('date', $values) && $values['date']['to'] != null){
      $dateMax = $values['date'];
      $dateMax = new DateTime($dateMax['to']);
      $dateMax->modify('+1 day');
      $values['date']['to'] = $dateMax->format('Y-m-d');
    }
    $rootAlias = parent::dobuildQuery($values)->getRootAlias();
    return parent::dobuildQuery($values)->andWhere($rootAlias . '.Dossier_mip_id = ?', $this->intIdDossierMip);
  }
}
