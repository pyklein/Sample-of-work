<?php

/**
 * Statut_dossier_bpi form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Statut_dossier_bpiForm extends BaseStatut_dossier_bpiForm
{
  public function configure()
  {
    $this->useFields(array(
        'precedent_statut_dossier_bpi_id',
        'intitule',
        'abreviation'
    ));

    $this->widgetSchema['precedent_statut_dossier_bpi_id'] = new sfWidgetFormDoctrineChoiceParametered(array(
        'model' => 'Statut_dossier_bpi',
        'add_empty' => 'Mettre à la racine',
        'table_method' => array('method' => 'retrieveStatutsParOrdre','parameters' => array (true,$this->getObject()->getId()))
    ));

    $this->configurerValidateurs();
    $this->configurerLabels();
    $this->disableCSRFProtection();

    parent::configure();
  }

  private function configurerLabels()
  {
    $this->widgetSchema['intitule'] -> setLabel(libelle("msg_libelle_intitule"));
    $this->widgetSchema['abreviation'] -> setLabel(libelle("msg_libelle_abreviation"));
    $this->widgetSchema['precedent_statut_dossier_bpi_id']->setLabel(libelle("msg_libelle_precedent_statut_dossier_bpi"));

    $this->widgetSchema->moveField('precedent_statut_dossier_bpi_id',sfWidgetFormSchema::FIRST );
  }

  private function configurerValidateurs()
  {
    $this->setValidator('intitule',
            new sfValidatorString( array(
                'required' => true) ,
                 array('required' => libelle("msg_statut_champ_intitule_requis") ) ));
  }
}
