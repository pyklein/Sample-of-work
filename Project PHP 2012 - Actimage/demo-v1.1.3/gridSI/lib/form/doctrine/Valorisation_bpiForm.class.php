<?php

/**
 * Valorisation_bpi form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Valorisation_bpiForm extends BaseValorisation_bpiForm
{
  private $intDossierId;

  public function __construct($intDossierId, $object = null, $options = array(), $CSRFSecret = null)
  {
    $this->intDossierId = $intDossierId;

    parent::__construct($object, $options, $CSRFSecret);
  }
  
  public function configure()
  {
    $this->useFields(array('commentaire', 'est_evalue', 'dossier_bpi_id'));

    // commentaire
    $this->widgetSchema['commentaire'] = new sfWidgetFormTextareaCKEditor();
    $this->widgetSchema['commentaire']->setLabel(libelle("msg_libelle_commentaire"));
    $this->setValidator('commentaire',new gridValidatorTextarea(array('required' => false)));

    // evaluation brevet
    $this->widgetSchema['est_evalue'] = new gridWidgetFormChoiceRadioAligne(array(
                                              'choices' => array('1'=>libelle("msg_libelle_oui"),
                                                                 '0'=>libelle("msg_libelle_non")),
                                            ));
    $this->widgetSchema['est_evalue']->setLabel(libelle("msg_libelle_evaluation_force_brevet"));
    $this->validatorSchema['est_evalue']->setMessage('invalid', libelle('msg_form_error_champ_invalide'));
    $this->validatorSchema['est_evalue']->setMessage('required', libelle('msg_form_error_champ_obligatoire'));

    $this->disableCSRFProtection();

    parent::configure();
  }

  public function bind(array $taintedValues = null, array $taintedFiles = null)
  {
    $taintedValues["dossier_bpi_id"] = $this->intDossierId;
    
    parent::bind($taintedValues, $taintedFiles);
  }

  public function save($con = null)
  {
    parent::save($con);
  }
}
