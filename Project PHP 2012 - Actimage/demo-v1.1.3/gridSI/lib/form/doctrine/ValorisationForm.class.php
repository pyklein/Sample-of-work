<?php
sfContext::getInstance()->getConfiguration()->loadHelpers("Format");
/**
 * Valorisation form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ValorisationForm extends BaseValorisationForm {

  public function configure() {
    $this->useFields(array(
        'destinataire_demande_generalisation',
        'avantage_inconvenient',
        'fiche_internet',
        'retour_experience',
        'date_demande_generalisation'));

    $this->widgetSchema['date_demande_generalisation'] = new sfWidgetFormInputJQueryDate();

    $this->widgetSchema['retour_experience'] = new sfWidgetFormTextareaCKEditor();
    $this->widgetSchema['avantage_inconvenient'] = new sfWidgetFormTextareaCKEditor();

    $this->validatorSchema['date_demande_generalisation'] = new sfValidatorDate(array(
                'required' => false,
                'date_format' => '~(?P<day>\d{2})/(?P<month>\d{2})/(?P<year>\d{4})~'
                    ),
                    array('bad_format' => libelle('msg_valorisation_date_invalide'))
            );
    $this->validatorSchema['retour_experience'] = new gridValidatorTextarea(array('required'=> false));
    $this->validatorSchema['avantage_inconvenient'] = new gridValidatorTextarea(array('required'=> false));

    $this->widgetSchema->setLabels(array(
        'destinataire_demande_generalisation' => libelle('msg_valorisation_libelle_destinataire'),
        'avantage_inconvenient' => libelle('msg_valorisation_libelle_avantage'),
        'fiche_internet' => libelle('msg_valorisation_libelle_fiche_interne'),
        'retour_experience' => libelle('msg_valorisation_libelle_retour_experience'),
        'date_demande_generalisation' => libelle('msg_valorisation_libelle_date_demande')
    ));

    $this->disableCSRFProtection();

    parent::configure();
  }

}
