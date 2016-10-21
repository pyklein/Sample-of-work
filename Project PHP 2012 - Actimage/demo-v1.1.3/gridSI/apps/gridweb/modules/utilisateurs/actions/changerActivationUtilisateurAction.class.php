<?php
sfContext::getInstance()->getConfiguration()->loadHelpers("Libelle");
sfContext::getInstance()->getConfiguration()->loadHelpers("Url");
/**
 * Activer/Desactiver un utilisateur
 * @author     Jihad Sahebdin
 *
 */
class changerActivationUtilisateurAction extends gridAction
{
  public function preExecute()
  {
    if ($this->request->hasParameter('id'))
    {
      if (!$this->getUser()->getUtilisateur()->isPeutGererUtilisateurAvecId($this->request->getParameter('id')))
      {
        $this->getUser()->setFlash("erreur", libelle("msg_utilisateur_droit_etat"));
        $this->redirect(url_for("utilisateurs/listerUtilisateurs"));
      }
    }
  }

  public function execute($request)
  {
    if (sfContext::hasInstance())
      sfContext::getInstance()->getLogger()->debug('changerActivationUtilisateur->execute() Start');

    if($request->hasParameter('innovateur')){
      $this->changerActivation($request->getParameter('id'), 'Utilisateur', null, null, 'rechercherInnovateurs');
    }else{
      $this->changerActivation($request->getParameter('id'),'Utilisateur');
    }

    if (sfContext::hasInstance())
      sfContext::getInstance()->getLogger()->debug('changerActivationUtilisateur->execute() End');
  }

  public function  postExecute()
  {
  }
}
