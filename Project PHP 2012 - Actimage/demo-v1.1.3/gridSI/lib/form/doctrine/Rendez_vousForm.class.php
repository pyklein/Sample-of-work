<?php

/**
 * Rendez_vous form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Actimage
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Rendez_vousForm extends BaseRendez_vousForm {

  public function configure() {
//    unset(
//            $this['created_by'], $this['updated_by'],
//            $this['created_at'], $this['updated_at']
//    );

    $this->useFields(array('date_prise_rdv', 'date_rdv' ,'dossier_mip_id'));


    $this->widgetSchema['date_prise_rdv'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['date_rdv'] = new sfWidgetFormDate();
    $this->widgetSchema['date_rdv_date'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['date_rdv_heure'] = new sfWidgetFormInputJQueryTime(
            array('hourText'=> 'Heure',
                'minuteText'=> 'Minute',
                'separator' => ':')
            );

    
    //on verifie que le champ DateRdv est different de NULL et on set les différents champs
    if($this->getObject()->getDateRdv() != null){

      //on cherche les paramètres de la requête
      $arrParameters = sfContext::getInstance()->getRequest()->getParameterHolder()->getAll() ;

      //si le paramètre n'existe pas, on remplit le champ par la valeur de la date de l'objet RendezVous
      if(!isset($arrParameters['gestion_calendrier'])){
//        print_r($arrParameters['gestion_calendrier']['rendezVous'] );
        $this->widgetSchema['date_rdv_date']->setAttribute('value', formatDate($this->getObject()->getDateRdv()));
      
        //on récupère l'heure à partir de dateRdv
        //et on verifie que l'heure soit différente de 00:00
        list($date, $heure) = explode(' ', $this->getObject()->getDateRdv());
        $heure = substr($heure, 0, 5);
        if($heure != '00:00') $this->widgetSchema['date_rdv_heure']->setAttribute('value', $heure);
      }
      

    }
    


    $this->setValidator('date_prise_rdv',
            new sfValidatorDateTime(array('date_format' => '~(?P<day>\d{2})/(?P<month>\d{2})/(?P<year>\d{4})~',
                'with_time' => false,
                'required' => false,
                    ),
                    array('bad_format' => libelle('msg_gestion_calendrier_bad_format'))
            )
    );

    $this->setValidator('date_rdv_date',
            new sfValidatorDateTime(array('date_format' => '~(?P<day>\d{2})/(?P<month>\d{2})/(?P<year>\d{4})~',
                'with_time' => false,
                'required' => false,
                    ),
                    array('bad_format' => libelle('msg_gestion_calendrier_bad_format'))
            )
    );

    $this->setValidator('date_rdv_heure',
            new sfValidatorTime(array('time_format' => '#^\d{2}:\d{2}$#',
                'required' => false,
                    ),
                    array('bad_format' => libelle('msg_gestion_calendrier_bad_format_heure'))
            )
    );

      
    $this->widgetSchema->setLabels(array(
        'date_prise_rdv' => libelle('msg_gestion_calendrier_innovateur_prise_rdv'),
        'date_rdv_date' => libelle('msg_gestion_calendrier_innovateur_date_rdv_date'),
        'date_rdv_heure' => libelle('msg_gestion_calendrier_innovateur_date_rdv_heure'),
    ));

    $this->validatorSchema->setOption('allow_extra_fields', true);

    $this->disableLocalCSRFProtection();
    
    parent::configure();
    
  }

}
