<?php

/**
 * Avis_mris form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Avis_mrisForm extends BaseAvis_mrisForm
{
  private $arrAnee;

  public function __construct($arrAnnee, $object = null, $options = array(), $CSRFSecret = null) {
    $this->arrAnee = $arrAnnee;

    parent::__construct($object, $options, $CSRFSecret);
  }


  public function configure()
  {
    $this->useFields(array('est_satisfaisant'));

    $this->widgetSchema['est_satisfaisant'] = new gridWidgetFormChoiceRadioAligne(array(
                            'choices'  => array('1' => 'Satisfaisant',
                                '0' => 'Non satisfaisant'),
                          ));
    $this->widgetSchema['est_satisfaisant']->setLabel(libelle("msg_libelle_avis_prononce"));

    $this->validatorSchema->setPostValidator(
              new sfValidatorCallback(array('callback' => array($this, 'validationAnnee')))
           );

    $this->disableCSRFProtection();
    parent::configure();
  }
  
  public function validationAnnee($validator, $values)
  {
    if ( in_array(date('Y', time()),$this->arrAnee,true) )
    {
       $error = new sfValidatorError($validator, libelle('msg_avis_mris_erreur_annee'));
       throw new sfValidatorErrorSchema($validator, array('est_satisfaisant' => $error));
    }
    return $values;
  }

}
