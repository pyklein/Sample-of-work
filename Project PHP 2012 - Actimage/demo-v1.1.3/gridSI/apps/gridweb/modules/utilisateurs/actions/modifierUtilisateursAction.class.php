<?php
sfContext::getInstance()->getConfiguration()->loadHelpers("Format");
/**
 * Description of modifierUtilisateurs
 *
 * @author Simeon Petev
 */
class modifierUtilisateursAction extends gridAction
{
  public function preExecute()
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    if ($this->request->hasParameter('id'))
    {
      if (!$this->getUser()->getUtilisateur()->isPeutGererUtilisateurAvecId($this->request->getParameter('id')))
      {
        $this->getUser()->setFlash("erreur", libelle("msg_utilisateur_droit_modifier"));

        $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN AVANT REDIRECTION; ");

        $this->redirect(url_for("utilisateurs/listerUtilisateurs"));
      }

      //si on vient de la page recherche des innovateurs
      if($this->request->hasParameter('innovateur')){
        $this->getUser()->setAttribute('page_innovateur', true);
      }
    }

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }

  public function execute($request)
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    //$objUtilisateur = Doctrine_Core::getTable('Utilisateur')->find(array($request->getParameter('id')));

    $objUtilisateur = UtilisateurTable::getInstance()->getUnAvecId($request->getParameter('id'));

    if (($objUtilisateur == null) || (strlen($objUtilisateur->getId() == 0)))
    {
      $this->getUser()->setFlash("erreur", libelle("msg_utilisateur_modifier_exist_erreur"));
      $this->redirect(url_for("utilisateurs/listerUtilisateurs"));
    }

    $this->objForm = new UtilisateurForm($objUtilisateur,array(),null,$request);

    //On construit le verificateur de profil MRIS
    $this->isProfilCorMRIS = false;
    if ($objUtilisateur->hasProfil(ProfilTable::COR_MRIS))
    {
      $this->isProfilCorMRIS = true;
    }

    //On construit le verificateur de profil MIP
    $this->isProfilMIP = false;
    $arrIdsProfilsMIP = $objUtilisateur->getProfilsIds();ProfilTable::getInstance()->getIdsProfilsDuMetierIntitule('MIP');

    if (count(array_intersect($arrIdsProfilsMIP, $objUtilisateur->getProfilsIds()))>0)
    {
      $this->isProfilMIP=true;
    }

    // on recharge le formulaire avec les villes (version sans Javascript)
    if ($request->isMethod('post') && $request->hasParameter("chargerVilles"))
    {
      $this->objForm->bind($request->getParameter($this->objForm->getName()), $request->getFiles($this->objForm->getName()));
    }

    // submit de formulaire
    else if ($request->isMethod('post') || $request->isMethod('put'))
    {
      $this->arrFiles = $request->getFiles("utilisateur");
      $arrTainedValues = $this->getRequest()->getParameter($this->objForm->getName());
      $arrTainedValues['profils_list'] = $objUtilisateur->getProfilsIds();
      $this->getRequest()->setParameter($this->objForm->getName(), $arrTainedValues);
      
      if ($this->processForm('modifier',null,false))
      {
        $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN AVANT REDIRECTION; ");

        if ($this->getUser()->getAttribute('page_innovateur')) {
           $this->getUser()->setAttribute('page_innovateur', false);
          $this->redirect(url_for('utilisateurs/rechercherInnovateurs'));
        } else {
          $this->redirect(url_for('utilisateurs/listerUtilisateurs'));
        }
      }

    }

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");
  }

  public function  postExecute()
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    parent::postExecute();

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }
}

?>
