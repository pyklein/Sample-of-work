<?php

/**
 * Soutien form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class SoutienForm extends BaseSoutienForm
{
  public function configure()
  {
    $this->useFields(array('date_emission', 'reference', 'dossier_mip_id'));

    $this->widgetSchema['date_emission'] = new sfWidgetFormInputJQueryDate();
    $this->setValidator('date_emission',
                        new sfValidatorDateTime(array('date_format' => '~(?P<day>\d{2})/(?P<month>\d{2})/(?P<year>\d{4})~',
                                                  'with_time' => false,
                                                  'required' => false,
                                                  ),
                                             array('bad_format'=> libelle('msg_gestion_calendrier_bad_format'))
                                            )
                        );

    $this->widgetSchema->setLabels(array(
             'date_emission' => libelle('msg_gestion_calendrier_soutien_date_emission'),
             'reference' => libelle('msg_gestion_calendrier_soutien_reference')
    ));

    $this->disableLocalCSRFProtection();
    
     parent::configure();
     
  }
}
