<?php
/**
 * Description of preCreerUtilisateursAction
 *
 * @author Simeon Petev
 */
class preCreerUtilisateursAction extends gridAction
{
  public function  preExecute()
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    parent::preExecute();

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }

  public function  execute($request)
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    $this->objForm = new UtilisateurPreCreerForm(null,array(),null,$this->getUser()->getUtilisateur()->getId());
    
    if ($request->isMethod('post'))
    {
      $this->objForm->bind($request->getParameter($this->objForm->getName()));

      if ($this->objForm->isValid())
      {
        $arrIdsProfilsGerablesParCurrUsr = $this->getUser()->getUtilisateur()->getIdsProfilsGerables();
        $arrTaintedVals = $request->getParameter($this->objForm->getName());
        $arrPostedProfils = $arrTaintedVals['profils_list'];

        $arrTaintedVals['profils_list'] = array_intersect($arrIdsProfilsGerablesParCurrUsr, $arrPostedProfils);

        //L'attribut de session guardant les informations d'etape 1
        $this->getUser()->setAttribute('nouveau_utilisateur_precreer', $arrTaintedVals);

        //L'attribut de verification apres redirections vers creerUtilisateurs
        $this->getUser()->setAttribute('nouveau_utilisateur_token', array('true'));

        $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN AVANT REDIRECTION; ");

        //Redirect vers creerUtilisateur
        $this->redirect(url_for('utilisateurs/creerUtilisateurs'));
      }

      $this->getUser()->setFlash('erreur', libelle('msg_utilisateur_creer_invalide'));
      $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ Formulaire invalide; ");
    }
    
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }

  public function  postExecute()
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    parent::postExecute();

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }
}
?>
