<?php

/**
 * Description of ajoutUtilisateurs
 *
 * @author Simeon Petev
 */
class creerUtilisateursAction extends gridAction
{

  public function  preExecute()
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");
    
    //On supprime l'information eventuelement stoqué dans la session
    if ($this->getRequest()->isMethod('get') && ($this->getUser()->hasAttribute('nouveau_utilisateur_precreer')) && (!$this->getUser()->hasAttribute('nouveau_utilisateur_token')))
    {
      $this->getUser()->offsetUnset('nouveau_utilisateur_precreer');

      $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN AVANT REDIRECTION; ");

      $this->redirect(url_for("utilisateurs/preCreerUtilisateurs"));
    }

    parent::preExecute();

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }

  public function execute($request)
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    $this->objForm = new UtilisateurForm(null,array(),null,$request);
    $objPreCreeForm = new UtilisateurPreCreerForm();

    if ($this->getUser()->hasAttribute('nouveau_utilisateur_precreer'))
    {
//      $objPreCreeForm->bind($this->getUser()->getAttribute('nouveau_utilisateur_precreer'),array());
//      $arrValuesPreCree = $objPreCreeForm->getValues();
      $arrValuesPreCree = $this->getUser()->getAttribute('nouveau_utilisateur_precreer');

      //On construit le verificateur de profil MRIS
      $this->isProfilCorMRIS = false;
      $intIdProfilCorMRIS = ProfilTable::getInstance()->getUnAvecCodeMetier('COR','MRIS')->getId();

      if (in_array($intIdProfilCorMRIS, $arrValuesPreCree['profils_list']))
      {
        $this->isProfilCorMRIS = true;
      }

      //On construit le verificateur de profil MIP
      $this->isProfilMIP = false;
      $arrIdsProfilsMIP = ProfilTable::getInstance()->getIdsProfilsDuMetierIntitule('MIP');

      if (count(array_intersect($arrIdsProfilsMIP, $arrValuesPreCree['profils_list']))>0)
      {
        $this->isProfilMIP=true;
      }

      $arrValeursLDAP = array();

      //On essay de recupere les informations LDAP
      try {
        $ldapService = new ServiceLdap();

        $arrValeursLDAP = $ldapService->recupereInformations($arrValuesPreCree['email']);
      } catch (Exception $exc) {
        $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ Erreur - Echec connection LDAP; ");
      }

      $objUtilisateur = new Utilisateur();
      $objUtilisateur->setEmail($arrValuesPreCree['email']);
      
      if (count($arrValeursLDAP) > 0)
      {
        $objUtilisateur->mettreAJourInformations($arrValeursLDAP);
        $objUtilisateur->setEstUtilisateurLdap(true);
      }

      $this->objForm = new UtilisateurForm($objUtilisateur,array(),null,$request);
      $this->getUser()->offsetUnset('nouveau_utilisateur_token');
    }

    // on recharge le formulaire avec les villes (version sans Javascript)
    if ($request->isMethod('post') && $request->hasParameter("chargerVilles"))
    {
      $this->objForm->bind($request->getParameter($this->objForm->getName()), $request->getFiles($this->objForm->getName()));
    }

    // submit de formulaire
    else if ($request->isMethod('post') || $request->isMethod('put'))
    {
      //On recupere les valeurs postées a l'etape precedent et stockees en session
      $arrAttributs = $this->getUser()->getAttribute('nouveau_utilisateur_precreer');
      
      $objUtilisateur = new Utilisateur();

      $objUtilisateur->setMotDePasse("A_REMPLACER");
      $objUtilisateur->setPhotographieOrig("A_REMPLACER");

      //On attribut l'email posté à l'etape precedent
      $objUtilisateur->setEmail($arrAttributs['email']);

      //On recupere les valeur postés maintenant
      $arrValeursPostees = $this->getRequest()->getParameter($this->objForm->getName());

      //On remet dedans les valeurs postés à l'etape precedent
      $arrValeursPostees['profils_list'] = $arrAttributs['profils_list'];
      $arrValeursPostees['email'] = $arrAttributs['email'];

      //On recupere les valeurs LDAP
      if (count($arrValeursLDAP) > 0)
      {
        $arrCorespondancesLDAP = UtilisateurTable::recupereCorrespondances($arrValeursLDAP);
        $objUtilisateur->mettreAJourInformations($arrValeursLDAP);
        $objUtilisateur->setEstUtilisateurLdap(true);
      }

      $this->objForm = new UtilisateurForm($objUtilisateur);
      $this->arrFiles = $request->getFiles("utilisateur");

      //On met les bon valeurs en paramettre pour le processForm
      $this->getRequest()->offsetUnset($this->objForm->getName());
      $this->getRequest()->setParameter($this->objForm->getName(), $arrValeursPostees);

      //proces form 
      if ($this->processForm('creer', '', false))
      {
        $this->redirect(url_for('utilisateurs/listerUtilisateurs'));
      }
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
