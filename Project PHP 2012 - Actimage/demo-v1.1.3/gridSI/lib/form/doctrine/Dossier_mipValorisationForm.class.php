<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Dossier_mipValorisationForm
 *
 * @author William
 */
class Dossier_mipValorisationForm extends BaseDossier_mipForm{

    public function  configure() {

      $this->useFields(array());
      $this->embedRelation('Valorisation');

      $this->widgetSchema->setNameFormat('dossier_mip_valorisation_forms[%s]');
      parent::configure();
  }
}
?>
