<?php

/**
 * Formulaire pour la cloture et l'ouverture d'un dossier BPI
 *
 * @author Alexandre WETTA
 */
class Dossier_bpiCloreRouvrirForm extends BaseDossier_bpiForm {

  public function __construct($typeForm = null, $object = null, $options = array(), $CSRFSecret = null) {

    $this->typeForm = $typeForm;

    parent::__construct($object, $options, $CSRFSecret);
  }

  public function configure() {

    //on affiche le formulaire en fonction du $typeForm
    if ($this->typeForm == 'clore') {
      $this->useFields(array('date_cloture', 'commentaire_cloture'));

      $this->widgetSchema['date_cloture'] = new sfWidgetFormInputJQueryDate();
      $this->widgetSchema['commentaire_cloture'] = new sfWidgetFormTextareaCKEditor();

      $this->validatorSchema['date_cloture'] = new sfValidatorDate(array(
                'required' => true,
                'date_format' => '~(?P<day>\d{2})/(?P<month>\d{2})/(?P<year>\d{4})~'
                    ),
                    array('bad_format' => libelle('msg_dossier_bpi_date_invalide'),
                          'required' => libelle('msg_dossier_bpi_date_required'))
            );
      $this->validatorSchema['commentaire_cloture'] = new gridValidatorTextarea(array('required'=>false));


      $this->widgetSchema->setLabels(array(
        'date_cloture' => libelle('msg_libelle_date_cloture'),
        'commentaire_cloture' => libelle('msg_libelle_commentaire'),
      ));
      
      
    } else if ($this->typeForm == 'rouvrir') {
      $this->useFields(array('date_reouverture', 'commentaire_reouverture'));

      $this->widgetSchema['date_reouverture'] = new sfWidgetFormInputJQueryDate();
      $this->widgetSchema['commentaire_reouverture'] = new sfWidgetFormTextareaCKEditor();

      $this->validatorSchema['date_reouverture'] = new sfValidatorDate(array(
                'required' => true,
                'date_format' => '~(?P<day>\d{2})/(?P<month>\d{2})/(?P<year>\d{4})~'
                    ),
                    array('bad_format' => libelle('msg_dossier_bpi_date_invalide'),
                          'required' => libelle('msg_dossier_bpi_date_required'))
            );

      $this->validatorSchema['commentaire_reouverture'] = new gridValidatorTextarea(array('required'=>false));


      $this->widgetSchema->setLabels(array(
        'date_reouverture' => libelle('msg_libelle_date_reouverture'),
        'commentaire_reouverture' => libelle('msg_libelle_commentaire'),
      ));

    }



    $this->disableLocalCSRFProtection();
    parent::configure();
  }

}
?>
