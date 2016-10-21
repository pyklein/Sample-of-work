<?php

/**
 * Echeance form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Actimage
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class EcheanceForm extends BaseEcheanceForm {

  public function configure() {

    $this->useFields(array('date_echeance_ea', 'date_echeance_cr', 'dossier_mip_id'));
    
    $this->widgetSchema['date_echeance_ea'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['date_echeance_cr'] = new sfWidgetFormInputJQueryDate();

    $this->setValidator('date_echeance_ea',
            new sfValidatorDateTime(array('date_format' => '~(?P<day>\d{2})/(?P<month>\d{2})/(?P<year>\d{4})~',
                'with_time' => false,
                'required' => false
                    ),
                    array('bad_format' => libelle('msg_gestion_calendrier_bad_format'))
            )
    );

    $this->setValidator('date_echeance_cr',
            new sfValidatorDateTime(array('date_format' => '~(?P<day>\d{2})/(?P<month>\d{2})/(?P<year>\d{4})~',
                'with_time' => false,
                'required' => false
                    ),
                    array('bad_format' => libelle('msg_gestion_calendrier_bad_format'))
            )
    );

    $this->widgetSchema->setLabels(array(
        'date_echeance_ea' => libelle('msg_gestion_calendrier_echeance_ea'),
        'date_echeance_cr' => libelle('msg_gestion_calendrier_echeance_cr')
    ));

    $this->disableLocalCSRFProtection();
    
     parent::configure();
     
  }

  public function  save($con = null) {
    parent::save($con);
  }

}
