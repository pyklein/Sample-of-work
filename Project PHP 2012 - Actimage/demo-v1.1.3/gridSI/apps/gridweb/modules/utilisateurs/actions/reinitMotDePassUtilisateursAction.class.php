<?php

/**
 * Réinitialisation de mot de passe et envoi de mail à l'utilisateur
 *
 * @author Jihad Sahebdin
 */
class reinitMotDePassUtilisateursAction extends sfAction
{
  public function preExecute()
  {
    if ($this->request->hasParameter('id'))
    {
      if (!$this->getUser()->getUtilisateur()->isPeutGererUtilisateurAvecId($this->request->getParameter('id')))
      {
        $this->getUser()->setFlash("erreur", libelle("msg_utilisateur_droit_password"));
        $this->redirect(url_for("utilisateurs/listerUtilisateurs"));
      }
    }
  }
  
  public function execute($request)
  {
    if (sfContext::hasInstance())
    {
      sfContext::getInstance()->getLogger()->debug('reinitMotDePassUtilisateurAction->execute() Start');
    }

    $objUtilMotDePasse = new UtilMotDePasse(sfConfig::get("app_mot_de_passe_longueur"), sfConfig::get("app_mot_de_passe_alphabet"));

    $strMotDePasseTemporaire = $objUtilMotDePasse->getMotDePasseAleatoire();
    $objUtilisateur = UtilisateurTable::getInstance()->findOneById($request->getParameter('id'));
    $objUtilisateur->setMotDePasse(sha1($strMotDePasseTemporaire));
    
    try
    {
      $objUtilisateur->save();
      //Envoi d'un mail à l'utilisateur contenant le mot de passe en clair
      $gestionnaireMail = new GestionnaireMail();
      $strContenuMail = $this->getPartial('email/contenuMailReinitialisationMotDePasseUtilisateur',array('utilisateur' => $objUtilisateur,'motdepasse' => $strMotDePasseTemporaire));
      $gestionnaireMail->envoyerMailReinitialisationMotDePasseUtilisateur($objUtilisateur, $strContenuMail, $this->getUser()->getUtilisateur());

      $this->getUser()->setFlash("succes", libelle('msg_utilisateur_reinit_mdp_succes',array($objUtilisateur->getNom())));
    }
    catch(Exception $ex)
    {
      $this->getUser()->setFlash("erreur", libelle('msg_utilisateur_reinit_mdp_echec',array($objUtilisateur->getNom(),$ex->getMessage())));
    }

    $this->redirect('utilisateurs/listerUtilisateurs');

    if (sfContext::hasInstance())
      sfContext::getInstance()->getLogger()->debug('reinitMotDePassUtilisateurAction->execute() End');
  }
}