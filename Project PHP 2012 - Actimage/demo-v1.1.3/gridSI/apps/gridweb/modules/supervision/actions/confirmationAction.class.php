<?php

/**
 * message de confirmation de réinitialisation des connexions
 * @author Julien GAUTIER
 */

class confirmationAction extends sfAction
{
  public function execute($request)
  {

    if (!sfContext::getInstance()->getUser()->isAdministrateur()) {
        $this->redirect("@non_autorise");
    }

    //Réinitialisation du compteur confirmée, réinitialisation puis retour à la supervision
    if ($request->isMethod('post')) {
      ConnexionTable::getInstance()->reinitCompteur();
      $this->redirect('supervision/index');
    }
  }
}

