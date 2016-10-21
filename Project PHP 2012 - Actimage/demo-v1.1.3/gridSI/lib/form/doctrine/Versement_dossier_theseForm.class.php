<?php

/**
 * Versement_dossier_these form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Versement_dossier_theseForm extends BaseVersement_dossier_theseForm
{
  private $reserve;

  public function __construct($reserve, $object = null, $options = array(), $CSRFSecret = null) {
    $this->reserve = $reserve;
    parent::__construct($object, $options, $CSRFSecret);
  }



  public function configure()
  {
    $this->useFields(array('date_versement','montant_versement'));

    $this->widgetSchema['date_versement'] = new sfWidgetFormInputJQueryDate();
    $this->widgetSchema['date_versement']->setLabel(libelle("msg_libelle_date_versement"));
    $this->setValidator('date_versement', new gridValidatorDate(array('required' => false)));

    $this->widgetSchema['montant_versement']->setLabel(libelle("msg_libelle_montant_e"));
    $this->setValidator('montant_versement',new gridValidatorFloat(array('required'=>false), array('invalid'=> libelle("msg_form_error_champ_invalide"))));


    $this->validatorSchema->setPostValidator(
              new sfValidatorCallback(array('callback' => array($this, 'validationMontant')))
           );
    
    parent::configure();
  }



  //Vérifier que le montant soit inferieur ou égal à la reserve
  public function validationMontant($validator, $values)
  {

    if ($values['montant_versement'] <= 0 || $values['montant_versement'] > $this->reserve)
    {
       $error = new sfValidatorError($validator, libelle('msg_versement_dossier_erreur_montant_versement'));
       throw new sfValidatorErrorSchema($validator, array('montant_versement' => $error));
    }
    return $values;
  }
}
