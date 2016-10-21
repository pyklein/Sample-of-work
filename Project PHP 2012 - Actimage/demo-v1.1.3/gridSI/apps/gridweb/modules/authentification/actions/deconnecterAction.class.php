<?php

/**
 * Action de déconnexion
 * @author Gabor JAGER
 */
class deconnecterAction extends sfAction
{
  public function preExecute() {}

  public function execute($request)
  {
    // on desauthentifie l'utilisateur
    $this->getUser()->setAuthenticated(false);

    // Par sécurité on vide ses droits
    $this->getUser()->clearCredentials();

    // Par sécurité on efface les variables de sessions
    // (tri  / recherche / etc / uilisateurs / droits ...)
    $this->getUser()->getAttributeHolder()->clear();

    // on redirige page de login
    $this->redirect("@seconnecter");
  }

  public function postExecute() {}
}
