<?php

/**
 * Modification d'un organisme MINDEF
 *
 * @author Actimage
 */
class modifierOrganisme_mindefAction extends gridAction {

  public function execute($request) {

    //on verifie qu'il y a bien un ID dans l'URL
    if (!$request->hasParameter('id')) {
      $this->redirect("@non_autorise");
    }

    $objOrganismeMindef = Organisme_mindefTable::getInstance()->findOneById($request->getParameter('id'));

    // si l'id de l'organisme MINDEF n'existe pas, on redirige
    if ($objOrganismeMindef == false) {
      $this->redirect("@non_autorise");
    }


    $this->objForm = new Organisme_mindefForm($objOrganismeMindef);
    if ($request->isMethod('post')) {
      $this->processForm('modifier');
    }
  }

}
?>
