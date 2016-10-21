<?php

//sfContext::getInstance()->getConfiguration()->loadHelpers("Libelle");
/**
 * Notification form.
 * @author     Jihad Sahebdin
 */
class NotificationForm extends BaseNotificationForm {

  public function configure() {
    $this->useFields(array(
        'date_debut',
        'date_fin',
        'contenu',
        'metier_id'
    ));

    $choix = $this->getOption('intIdUtilisateur');

    $this->widgetSchema['date_debut'] = new sfWidgetFormInputJQueryDate();

    $this->widgetSchema['date_fin'] = new sfWidgetFormInputJQueryDate();

    $this->widgetSchema['contenu'] = new sfWidgetFormTextareaCKEditor();


    $this->configurerValidateurs();

    $this->configurerLabels();

    $this->disableCSRFProtection();

    $this->validatorSchema->setOption('allow_extra_fields', true);
    parent::configure();
  }

  private function configurerLabels() {
    $this->widgetSchema['metier_id'] = new sfWidgetFormChoice(array(
                'choices' => MetierTable::getInstance()->getMetiersParUtilisateur($this->getOption('intIdUtilisateur')),
                'expanded' => false,
            ));

    $this->widgetSchema['metier_id']->setLabel(libelle("msg_libelle_metier"));
    $this->widgetSchema['contenu']->setLabel(libelle("msg_libelle_contenu"));
    $this->widgetSchema['date_debut']->setLabel(libelle("msg_libelle_date_debut"));
    $this->widgetSchema['date_fin']->setLabel(libelle("msg_libelle_date_fin"));
  }

  private function configurerValidateurs() {
    $this->setValidators(array(
        'date_debut' => new sfValidatorDate(array(
            'required' => 'true',
            'date_format' => '~(?P<day>\d{2})/(?P<month>\d{2})/(?P<year>\d{4})~'
                ),
                array('required' => libelle('msg_notification_champ_requis', array(libelle('msg_libelle_date_debut'))),
                    'bad_format' => libelle('msg_notification_champ_invalide', array(libelle('msg_libelle_date_debut')))
        )),
        'date_fin' => new sfValidatorDate(array(
            'required' => 'true',
            'date_format' => '~(?P<day>\d{2})/(?P<month>\d{2})/(?P<year>\d{4})~'
                ),
                array('required' => libelle('msg_notification_champ_requis', array(libelle('msg_libelle_date_fin'))),
                    'bad_format' => libelle('msg_notification_champ_invalide', array(libelle('msg_libelle_date_fin')))
        )),
        'contenu' => new gridValidatorTextarea(array(
            'required' => true,
                ),
                array(
                    'required' => libelle('msg_notification_champ_requis', array(libelle('msg_libelle_contenu')))
        )),
        'id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
    ));

    //Validateur pour s'assurer que la date de fin d'une notification n'est pas inferieur à la date de début
    $this->validatorSchema->setPostValidator(
            new sfValidatorSchemaCompare('date_fin', sfValidatorSchemaCompare::GREATER_THAN_EQUAL, 'date_debut',
                    array(),
                    array('invalid' => libelle('msg_notification_date_debut_fin'))
            )
    );
  }

}
