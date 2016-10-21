<?php

/**
 * Avis_etatmajor form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Avis_etatmajorForm extends BaseAvis_etatmajorForm {

  public function configure() {


    $this->useFields(array('date_demande','reference_demande', 'date_reception', 'date_envoi', 'reference' , 'est_favorable' ,'recommandation' ,'dossier_mip_id'));

    $this->widgetSchema['date_demande'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['date_reception'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['date_envoi'] = new sfWidgetFormInputJQueryDate();

    $this->widgetSchema['recommandation'] = new sfWidgetFormTextarea();

    $this->setValidator('date_demande',
            new sfValidatorDateTime(array('date_format' => '~(?P<day>\d{2})/(?P<month>\d{2})/(?P<year>\d{4})~',
                'with_time' => false,
                'required' => false,
                    ),
                    array('bad_format' => libelle('msg_gestion_calendrier_bad_format'))
            )
    );

    $this->setValidator('date_reception',
            new sfValidatorDateTime(array('date_format' => '~(?P<day>\d{2})/(?P<month>\d{2})/(?P<year>\d{4})~',
                'with_time' => false,
                'required' => false,
                    ),
                    array('bad_format' => libelle('msg_gestion_calendrier_bad_format'))
            )
    );

    $this->setValidator('date_envoi',
            new sfValidatorDateTime(array('date_format' => '~(?P<day>\d{2})/(?P<month>\d{2})/(?P<year>\d{4})~',
                'with_time' => false,
                'required' => false,
                    ),
                    array('bad_format' => libelle('msg_gestion_calendrier_bad_format'))
            )
    );

    
    $this->setValidator('recommandation', new gridValidatorTextarea(array('required'=>FALSE)));

    $this->widgetSchema['est_favorable'] = new gridWidgetFormChoiceRadioAligne(
                    array(
                        'choices' => array(
                            '1' => libelle('msg_gestion_calendrier_avis_em_favorable'),
                            '0' => libelle('msg_gestion_calendrier_avis_em_defavorable')),
                    )
    );

    $this->widgetSchema->setLabels(array(
        'date_demande' => libelle('msg_gestion_calendrier_avis_em_date_demande'),
        'reference_demande' => libelle('msg_gestion_calendrier_avis_em_ref_demande'),
        'date_reception' => libelle('msg_gestion_calendrier_avis_em_date_reception_avis'),
        'date_envoi' => libelle('msg_gestion_calendrier_avis_em_date_envoi_avis'),
        'reference' => libelle('msg_gestion_calendrier_avis_em_ref_avis'),
        'est_favorable' => libelle('msg_gestion_calendrier_avis_em_est_favorable'),
        'recommandation' => libelle('msg_gestion_calendrier_avis_em_recommandation')
    ));

    $this->disableLocalCSRFProtection();

    parent::configure();
  }

  public function save($con = null) {
    parent::save($con);
  }

}
