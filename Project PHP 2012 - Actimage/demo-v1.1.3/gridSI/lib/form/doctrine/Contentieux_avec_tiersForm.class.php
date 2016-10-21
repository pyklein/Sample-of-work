<?php

/**
 * Contentieux_avec_tiers form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Antonin KALK
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Contentieux_avec_tiersForm extends BaseContentieux_avec_tiersForm
{
    public function configure() {

    $this->useFields(array('organisme_id', 'est_desaccord', 'commentaire_desaccord',
      'date_accord'));

    //set widgets
    $this->widgetSchema['organisme_id'] = new gridWidgetFormOrganisme(array('popup' => true));
    $this->widgetSchema['est_desaccord'] = new gridWidgetFormChoiceRadioAligne(array(
                'choices' => array('1' => libelle('msg_libelle_oui'),
                    '0' => libelle('msg_libelle_non')),
            ));
    $this->widgetSchema['commentaire_desaccord'] = new sfWidgetFormTextareaCKEditor();
    $this->widgetSchema['date_accord'] = new sfWidgetFormInputJQueryDate();

    $this->validatorSchema['date_accord'] = new gridValidatorDate(array('required' => false));
    $this->validatorSchema['commentaire_desaccord'] = new gridValidatorTextarea(array('required'=>FALSE));
        
    //Labels
    $this->widgetSchema->setLabels(array(
        'organisme_id' => libelle('msg_libelle_organisme'),
        'est_desaccord' => libelle("msg_libelle_contentieux_est_desaccord"),
        'commentaire_desaccord' => libelle("msg_libelle_contentieux_commentaire_desaccord"),
        'date_accord' => libelle("msg_libelle_contentieux_date_accord"),
    ));
    
    $this->disableLocalCSRFProtection();
    parent::configure();
  }
}
