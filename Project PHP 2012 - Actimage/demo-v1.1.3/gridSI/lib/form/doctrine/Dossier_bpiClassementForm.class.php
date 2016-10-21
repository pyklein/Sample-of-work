<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Dossier_bpiClassementForm
 *
 * @author William
 */
class Dossier_bpiClassementForm extends BaseDossier_bpiForm {

  public $arrInventeurs;
  public $arrForms;

  public function __construct($arrInventeurs = null, $object = null, $options = array(), $CSRFSecret = null) {
    $this->arrInventeurs = $arrInventeurs;
    $this->arrForms = array();
    parent::__construct($object, $options, $CSRFSecret);
  }

  public function configure() {
    $this->useFields(array('est_brevetable', 'commentaire_classement', 'date_classement', 'date_classement_cnis'));

    $this->widgetSchema['est_brevetable'] = new gridWidgetFormChoiceRadioAligne(array(
                'choices' => array('1' => libelle('msg_libelle_oui'),
                    '0' => libelle('msg_libelle_non')),
            ));
    $this->widgetSchema['commentaire_classement'] = new sfWidgetFormTextareaCKEditor();
    $this->widgetSchema['date_classement'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['date_classement_cnis'] = new sfWidgetFormInputJQueryDate();

    $this->validatorSchema['date_classement'] = new gridValidatorDate(array('required' => false));
    $this->validatorSchema['date_classement_cnis'] = new gridValidatorDate(array('required' => false));
    $this->validatorSchema['est_brevetable']->setOption('required', true);
    $this->validatorSchema['commentaire_classement'] = new gridValidatorTextarea(array('required'=> false) );

    $this->widgetSchema->setLabels(array(
        'commentaire_classement' => libelle('msg_classement_commentaire'),
        'est_brevetable' => libelle('msg_classement_est_brevetable'),
        'date_classement' => libelle('msg_libelle_date_classement'),
        'date_classement_cnis' => libelle('msg_libelle_date_classement_cnis')
    ));

    //Création des enregistrement dans la table intermédiaire si innexistants
    foreach ($this->arrInventeurs as $objInventeur) {
      if (!$objClassementInvention = Classement_invention_inventeurTable::getInstance()->findOneByConcerneIdAndDossierId($objInventeur->getId(),$this->getObject()->getId())) {
        Classement_invention_inventeurTable::getInstance()->CreateClassementInventeur($objInventeur->getId(), $this->getObject()->getId());
      }
    }

    $this->embedRelation('Classement_invention_inventeur');

    $this->widgetSchema->setNameFormat('dossier_bpi_classement_form[%s]');

    if (!$this->getObject()->getEstBrevetable()) {
      $this->useFields(array('est_brevetable'));
    }

    $this->disableCSRFProtection();
    parent::configure();
  }


}

?>
