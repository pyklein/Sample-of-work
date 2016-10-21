<?php

/**
 * Evenement_mip form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Evenement_mipForm extends BaseEvenement_mipForm
{
  public function configure()
  {
    $this->useFields(array('evenement','est_cloture','date'));
    $this->setWidgets(array(
        'date' => new sfWidgetFormInputJQueryDate(),
        'est_cloture'=> new sfWidgetFormChoice(array(
                                'choices' => array(false => libelle("msg_evenement_etat_non_cloture"),
                                                   true  => libelle("msg_evenement_etat_cloture")))),
        'evenement' => new sfWidgetFormTextareaCKEditor()
        
    ));

    $this->widgetSchema->setLabels(array(
        'evenement' => libelle("msg_libelle_contenu_evenement"),
        'date' => libelle("msg_libelle_date"),
        'est_cloture' => libelle("msg_evenement_mip_libelle_cloture")));

    $this->setValidators(array(
        'evenement'   => new gridValidatorTextarea(array('required' => true),array('required' => libelle("msg_evenement_contenu_requis"))),
        'est_cloture' => new sfValidatorBoolean(),
        'date'        => new gridValidatorDate(array('required' => true),array('required' => libelle("msg_evenement_date_requise")))
    ));
    $this->widgetSchema->setNameFormat('evenement_mip[%s]');

    
    $this->disableLocalCSRFProtection();

    parent::configure();
  }
}
