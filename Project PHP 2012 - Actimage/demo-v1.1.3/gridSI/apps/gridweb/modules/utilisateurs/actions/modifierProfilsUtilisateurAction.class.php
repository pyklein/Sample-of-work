<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of modifierProfilsUtilisateurs
 *
 * @author Jihad Sahebdin
 */
class modifierProfilsUtilisateurAction extends gridAction
{
  public function preExecute()
  {
    if ($this->request->hasParameter('id'))
    {
      if (!$this->getUser()->getUtilisateur()->isPeutGererUtilisateurAvecId($this->request->getParameter('id')))
      {
        $this->getUser()->setFlash("erreur", libelle("msg_utilisateur_droit_profil"));
        $this->redirect(url_for("utilisateurs/listerUtilisateurs"));
      }
    }
  }
  
  public function  execute($request)
  {
    if (sfContext::hasInstance())
      sfContext::getInstance()->getLogger()->debug('modifierProfilsUtilisateurAction->execute() Start');

    $this->objUtilisateur = UtilisateurTable::getInstance()->findOneById($request->getParameter('id'));

    $this->objForm = new ProfilsUtilisateurForm($this->objUtilisateur,array(),null,  $this->getUser()->getUtilisateur()->getId());

    $boolAProfilCorMRISAvant = $this->objUtilisateur->hasProfil(ProfilTable::COR_MRIS);

    if ($request->isMethod('post')) {
      if ($this->processForm('modifier','',false))
      {
        $this->objUtilisateur = UtilisateurTable::getInstance()->findOneById($request->getParameter('id'));
        $boolAProfilCorMRISApres = $this->objUtilisateur->hasProfil(ProfilTable::COR_MRIS);

        if ($boolAProfilCorMRISApres && (!$boolAProfilCorMRISAvant))
        {
          //On doit rediriger vers le formulaire pour remplir les deomaires scientifiques
          $this->getUser()->setFlash("warning", libelle('msg_utilisateur_modification_domaine_sci'));
          $this->redirect(url_for('utilisateurs/modifierUtilisateurs?id='.$request->getParameter('id')));
        } else if ((!$boolAProfilCorMRISApres) && $boolAProfilCorMRISAvant)
        {
          //on doit netoyer la table des domaines scientifiques
          $arrDomainesScintifiques = $this->objUtilisateur->getDomainesScientifiques();

          foreach ($arrDomainesScintifiques as $cle => $objDomaine)
          {
            $this->objUtilisateur->getDomainesScientifiques()->remove($cle);
          }

          $this->objUtilisateur->save();
        }

        $this->getUser()->setFlash("succes", libelle("msg_utilisateur_modifier_succes", array($this->objUtilisateur), true));
        $this->redirect(url_for('utilisateurs/listerUtilisateurs'));
      }
    }



    if (sfContext::hasInstance())
      sfContext::getInstance()->getLogger()->debug('modifierProfilsUtilisateurAction->execute() End');
  }
}

