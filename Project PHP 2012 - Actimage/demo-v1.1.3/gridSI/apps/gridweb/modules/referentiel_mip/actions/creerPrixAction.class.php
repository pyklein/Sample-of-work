<?php
/**
 * Création d'un prix
 *
 * @author Actimage
 */
class creerPrixAction extends gridAction {

    public function execute($request) {

    $objPrix = new Prix();

    // on active le prix par défaut.
    $objPrix->setEstActif(true);

    $this->objForm = new PrixForm($objPrix);
    if ($request->isMethod('post')) {
      $this->processForm( 'creer');
    }
  }
  
}
?>
