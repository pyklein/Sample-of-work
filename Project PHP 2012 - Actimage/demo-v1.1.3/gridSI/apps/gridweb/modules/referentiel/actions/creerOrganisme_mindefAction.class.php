<?php
/**
 * Creation d'un nouvel organisme MINDEF
 *
 * @author Actimage
 */
class creerOrganisme_mindefAction extends gridAction {

    public function execute($request) {
    
    $objOrganisme_Mindef = new Organisme_mindef();

    $this->objForm = new Organisme_mindefForm($objOrganisme_Mindef);
    if ($request->isMethod('post')) {
      $this->processForm( 'creer');
    }
  }
  
}
?>
