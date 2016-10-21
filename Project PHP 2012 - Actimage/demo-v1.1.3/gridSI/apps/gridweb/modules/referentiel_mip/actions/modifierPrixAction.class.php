<?php

/**
 * Modification d'un prix
 *
 * @author Actimage
 */
class modifierPrixAction extends gridAction {

  public function execute($request) {

    //on verifie qu'il y a bien un ID dans l'URL
    if (!$request->hasParameter('id')) {
      $this->redirect("@non_autorise");
    }
    
    $objPrix = PrixTable::getInstance()->findOneById($request->getParameter('id'));

    // si l'id du prix n'existe pas, on redirige
    if ($objPrix == null) {
      $this->redirect("@non_autorise");
    }

    $this->objForm = new PrixForm($objPrix);
    if ($request->isMethod('post')) {
      $this->processForm('modifier');
    }
  }

}
?>
