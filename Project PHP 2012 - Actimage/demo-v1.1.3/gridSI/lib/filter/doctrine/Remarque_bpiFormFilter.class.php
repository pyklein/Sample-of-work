<?php

/**
 * Remarque_bpi filter form.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Remarque_bpiFormFilter extends BaseRemarque_bpiFormFilter {

  protected $intDossierBpiId;

  public function __construct($intIdDossier, $defaults = array(), $options = array(), $CSRFSecret = null) {
    $this->intDossierBpiId = $intIdDossier;
    parent::__construct($defaults, $options, $CSRFSecret);
  }

  public function configure() {

    $this->useFields(array('created_by', 'created_at'));

    $this->setWidgets(array(
        'created_by' => new sfWidgetFormDoctrineChoiceParametered(
                array('model' => 'Utilisateur',
                    'add_empty' => libelle('msg_libelle_tous'),
                    'table_method' => array('method' => 'retrieveAuteursRemarquesDossierBpi',
                        'parameters' => array($this->intDossierBpiId))
        )),
        'created_at' => new sfWidgetFormFilterDate(array(
            'from_date' => new sfWidgetFormInputJQueryDate(),
            'to_date' => new sfWidgetFormInputJQueryDate(),
            'with_empty' => false,
            'template' => "%from_date% <b>" . libelle("msg_remarque_et_le") . "</b> : %to_date%"
        ))
    ));

    $this->setValidators(array(
        'created_at' => new sfValidatorDateRange(array(
            'from_date' => new gridValidatorDate(array('required' => false)),
            'to_date' => new gridValidatorDate(array('required' => false)),
            'required' => false
                ),
                array('invalid' => libelle('msg_remarque_bpi_date_incoherente'))
        ),
        'created_by' => new sfValidatorDoctrineChoice(
                array(
                    'model' => 'Utilisateur',
                    'required' => false)
        )
    ));


    $this->widgetSchema->setLabels(array(
        'created_by' => libelle("msg_remarque_auteur"),
        'created_at' => libelle("msg_remarque_bpi_libelle_cree")
    ));

    $this->disableCSRFProtection();

    $this->widgetSchema->setNameFormat('remarque_bpi_filters[%s]');
    parent::configure();
  }

  public function dobuildQuery(array $values) {
    //si filtre par date, ajout d'un jour à la date max (pour inclure date sup)
    if (array_key_exists('created_at', $values)) {
      if ($values['created_at'] != null) {
        $dateMax = $values['created_at'];
        $dateMax = new DateTime($dateMax['to']);
        $dateMax->modify('+1 day');
        $values['created_at']['to'] = $dateMax->format('Y-m-d');
      }
    }
    $rootAlias = parent::dobuildQuery($values)->getRootAlias();
    return parent::dobuildQuery($values)->andWhere($rootAlias . '.Dossier_bpi_id = ?', $this->intDossierBpiId);
  }

}
