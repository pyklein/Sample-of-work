<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Dossier_mip_projetForm
 *
 * @author William
 */
class Dossier_mip_projetForm extends BaseDossier_mipForm{
    public function  configure() {

      $this->useFields(array('statut_projet_mip_id'));

      $this->setWidget('statut_projet_mip_id', new sfWidgetFormDoctrineChoice(array(
          'model' => 'Statut_projet_mip',
          'table_method' => 'retrieveStatutPourCreation')));
      $this->setValidator('statut_projet_mip_id', new sfValidatorDoctrineChoice(
              array(
          'model' => 'Statut_projet_mip',
          'query' => Statut_projet_mipTable::getInstance()->retrieveStatutPourCreation()))
              );



      $this->widgetSchema->setLabel('statut_projet_mip_id',libelle('msg_dossier_mip_wizard_statut'));
      $this->disableCSRFProtection();
      parent::configure();
  }
}
?>
