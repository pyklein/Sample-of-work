<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Demande_partageForm
 *
 * @author William
 */
class Demande_partageForm extends BaseForm{

  public $typeDossier;

  public function  __construct($strTypeDossier = null, $options = array(), $CSRFSecret = null) {
    $this->typeDossier = $strTypeDossier;
    parent::__construct( $options, $CSRFSecret);
  }

  public function setup()
  {
    $this->setWidget( 'commentaire' ,new sfWidgetFormTextareaCKEditor());
    $this->setValidator('commentaire',new gridValidatorTextarea(array('required' => true),
            array('required' => libelle('msg_recherche_demande_commentaire_requis'))));
    $this->widgetSchema['commentaire']->setLabel(libelle('msg_recherche_commentaire_demande'));


    if ($this->typeDossier == "Dossier_mip") {
      $this->setWidget('dossier_lie' ,new sfWidgetFormDoctrineChoice(array(
          'model' => 'Dossier_bpi',
          'add_empty' => false
      )));
      $this->setValidator('dossier_lie',new sfValidatorDoctrineChoice(array(
          'model' => 'Dossier_bpi',
          'required' => true)));
      $this->widgetSchema['dossier_lie']->setLabel(libelle('msg_recherche_dossier_a_lier'));
    }
    if ($this->typeDossier == "Dossier_bpi") {
      $this->setWidget('dossier_lie' ,new sfWidgetFormDoctrineChoice(array(
          'model' => 'Dossier_mip',
          'add_empty' => false
      )));
      $this->setValidator('dossier_lie',new sfValidatorDoctrineChoice(array(
          'model' => 'Dossier_mip',
          'required' => true)));
      $this->widgetSchema['dossier_lie']->setLabel(libelle('msg_recherche_dossier_a_lier'));
    }

    $this->disableCSRFProtection();
    $this->widgetSchema->setNameFormat('demande_partage[%s]');
    parent::setup();
  }

  
}
?>
