<?php

/**
 * 'Wizard' pour la création de dossier MIP
 *
 * @author William
 */
class creerProjet_mipAction extends gridAction{
    public function  execute($request) {
    $this->objForm = new Dossier_mip_projetForm();
    if ($request->isMethod('post')){
      $this->objForm->bind($request->getParameter($this->objForm->getName()));
      if ($this->objForm->isValid()){
        $this->getUser()->setAttribute('statut_projet',$this->objForm->getValue('statut_projet_mip_id'));
        $this->redirect('dossier_mip/creerDossier_mip');
      }
    }
  }
}
?>
