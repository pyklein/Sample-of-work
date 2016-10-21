<?php

/**
 * Remise_documents form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Actimage
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Remise_documentsForm extends BaseRemise_documentsForm
{
  public function configure()
  {


    $this->useFields(array('date_reception_ea', 'reference_ea', 'date_envoi_ar_ea', 'reference_ar_ea',
        'mode_transmission_ea', 'date_reception_cr', 'reference_cr', 'date_envoi_ar_cr', 'reference_ar_cr',
        'mode_transmission_cr', 'date_reception_video', 'reference_video', 'date_envoi_ar_video', 'reference_ar_video',
        'mode_transmission_video', 'dossier_mip_id'
        ));

    $this->widgetSchema['date_reception_ea'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['date_envoi_ar_ea'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['date_reception_cr'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['date_envoi_ar_cr'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['date_reception_video'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['date_envoi_ar_video'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['mode_transmission_ea'] = new sfWidgetFormDoctrineChoice(array(
        'model' => $this->getRelatedModelName('ModeTransmissionEA'),
        'add_empty' => libelle('msg_libelle_aucun')))
            ;
    $this->widgetSchema['mode_transmission_cr'] = new sfWidgetFormDoctrineChoice(array(
        'model' => $this->getRelatedModelName('ModeTransmissionCR'),
        'add_empty' => libelle('msg_libelle_aucun')))
            ;
    $this->widgetSchema['mode_transmission_video'] = new sfWidgetFormDoctrineChoice(array(
        'model' => $this->getRelatedModelName('ModeTransmissionVideo'),
        'add_empty' => libelle('msg_libelle_aucun')))
            ;

     $this->setValidator('date_reception_ea',
                        new sfValidatorDateTime(array('date_format' => '~(?P<day>\d{2})/(?P<month>\d{2})/(?P<year>\d{4})~',
                                                  'with_time' => false,
                                                  'required' => false,
                                                  ),
                                             array('bad_format'=> libelle('msg_gestion_calendrier_bad_format'))
                                            )
                        );

      $this->setValidator('date_envoi_ar_ea',
                        new sfValidatorDateTime(array('date_format' => '~(?P<day>\d{2})/(?P<month>\d{2})/(?P<year>\d{4})~',
                                                  'with_time' => false,
                                                  'required' => false,
                                                  ),
                                             array('bad_format'=> libelle('msg_gestion_calendrier_bad_format'))
                                            )
                        );
       $this->setValidator('date_reception_cr',
                        new sfValidatorDateTime(array('date_format' => '~(?P<day>\d{2})/(?P<month>\d{2})/(?P<year>\d{4})~',
                                                  'with_time' => false,
                                                  'required' => false,
                                                  ),
                                             array('bad_format'=> libelle('msg_gestion_calendrier_bad_format'))
                                            )
                        );
        $this->setValidator('date_envoi_ar_cr',
                        new sfValidatorDateTime(array('date_format' => '~(?P<day>\d{2})/(?P<month>\d{2})/(?P<year>\d{4})~',
                                                  'with_time' => false,
                                                  'required' => false,
                                                  ),
                                             array('bad_format'=> libelle('msg_gestion_calendrier_bad_format'))
                                            )
                        );
         $this->setValidator('date_reception_video',
                        new sfValidatorDateTime(array('date_format' => '~(?P<day>\d{2})/(?P<month>\d{2})/(?P<year>\d{4})~',
                                                  'with_time' => false,
                                                  'required' => false,
                                                  ),
                                             array('bad_format'=> libelle('msg_gestion_calendrier_bad_format'))
                                            )
                        );
          $this->setValidator('date_envoi_ar_video',
                        new sfValidatorDateTime(array('date_format' => '~(?P<day>\d{2})/(?P<month>\d{2})/(?P<year>\d{4})~',
                                                  'with_time' => false,
                                                  'required' => false,
                                                  ),
                                             array('bad_format'=> libelle('msg_gestion_calendrier_bad_format'))
                                            )
                        );

    $this->widgetSchema->setLabels(array(
          'date_reception_ea' => libelle('msg_gestion_calendrier_remise_docs_date_reception'),
          'mode_transmission_ea' => libelle('msg_gestion_calendrier_remise_docs_mode_transmission'),
          'reference_ea' => libelle('msg_gestion_calendrier_remise_docs_reference'),
          'date_envoi_ar_ea' => libelle('msg_gestion_calendrier_remise_docs_date_envoi_ar'),
          'reference_ar_ea' => libelle('msg_gestion_calendrier_remise_docs_reference_ar'),
          'date_reception_cr' => libelle('msg_gestion_calendrier_remise_docs_date_reception'),
          'mode_transmission_cr' => libelle('msg_gestion_calendrier_remise_docs_mode_transmission'),
          'reference_cr' => libelle('msg_gestion_calendrier_remise_docs_reference'),
          'date_envoi_ar_cr' => libelle('msg_gestion_calendrier_remise_docs_date_envoi_ar'),
          'reference_ar_cr' => libelle('msg_gestion_calendrier_remise_docs_reference_ar'),
          'date_reception_video' => libelle('msg_gestion_calendrier_remise_docs_date_reception'),
          'mode_transmission_video' => libelle('msg_gestion_calendrier_remise_docs_mode_transmission'),
          'reference_video' => libelle('msg_gestion_calendrier_remise_docs_reference'),
          'date_envoi_ar_video' => libelle('msg_gestion_calendrier_remise_docs_date_envoi_ar'),
          'reference_ar_video' => libelle('msg_gestion_calendrier_remise_docs_reference_ar')
     ));
    
    $this->disableLocalCSRFProtection();

    parent::configure();

  }
}
