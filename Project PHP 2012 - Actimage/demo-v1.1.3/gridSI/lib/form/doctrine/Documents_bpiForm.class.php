<?php

/**
 * Documents_bpi form: Pour l'ajout et la modification d'un document référencé
 *
 * @package    gridSI
 * @subpackage form
 * @author     Jihad Sahebdin
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Documents_bpiForm extends BaseDocuments_bpiForm
{
  public function configure()
  {
    $this->useFields(array('fichier','titre', 'statut_dossier_bpi_id', 'est_invisible'));

    $this->configurerValidateurs();
    $this->configurerLabels();


    parent::configure();
  }

  private function configurerLabels()
  {
    $this->widgetSchema['fichier'] = new sfWidgetFormInput(array(),array('size' => '50',));
    $this->widgetSchema['titre'] = new sfWidgetFormInput(array(),array('size' => '50',));

    $this->widgetSchema['statut_dossier_bpi_id'] = new sfWidgetFormDoctrineChoice(array(
        'model'=>$this->getRelatedModelName('Statut_dossier_bpi'),
        'add_empty' => false,
    ));
    $this->widgetSchema['fichier'] -> setLabel(libelle("msg_libelle_fichier"));
    $this->widgetSchema['statut_dossier_bpi_id'] -> setLabel(libelle("msg_libelle_statut_associe"));
    $this->widgetSchema['est_invisible'] -> setLabel(libelle("msg_libelle_invisible"));
  }

  private function configurerValidateurs()
  {
    $this->validatorSchema['fichier'] = new sfValidatorString(
            array('required' => true),
            array('required'=> libelle("msg_libelle_fichier_requis")));


  }

}
