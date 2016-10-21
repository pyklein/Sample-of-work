<?php

/**
 * Création d'un nouvel innovateur
 *
 * @author Alexandre WETTA
 */
class creerInnovateurAction extends gridAction{

  public function  preExecute() {
  }

  public function execute($request) {
    
    if($this->getRequest()->hasParameter('id')){
      $this->strDossierMipId = $request->getParameter('id');
    }
    else
      $this->strDossierMipId = NULL;

    $objUtilMotDePasse = new UtilMotDePasse(sfConfig::get("app_mot_de_passe_longueur"), sfConfig::get("app_mot_de_passe_alphabet"));
    $strMotDePasseTemporaire = $objUtilMotDePasse->getMotDePasseAleatoire();


    $objInnovateur = new Utilisateur();

    $objInnovateur->setEstActif(true);
    $objInnovateur->setMotDePasse(sha1($strMotDePasseTemporaire));

    $this->objForm = new InnovateurForm($objInnovateur);
    if ($request->isMethod('post')) {

      $arrValeursPostees = $this->getRequest()->getParameter($this->objForm->getName());

      $arrValeursLDAP=null;
      
      //On essaye de recuperer les informations LDAP
      try {
        $ldapService = new ServiceLdap();

        $arrValeursLDAP = $ldapService->recupereInformations($arrValeursPostees['email']);
      } catch (Exception $exc) {
        $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ Erreur - Echec connection LDAP; ");
      }

      if ($arrValeursLDAP && count($arrValeursLDAP) > 0)
      {
        $objInnovateur->mettreAJourInformations($arrValeursLDAP);
        $objInnovateur->setEstUtilisateurLdap(true);

        $this->objForm = new InnovateurForm($objInnovateur);

        $arrValeursPostees['civilite_id']           = $objInnovateur->getCiviliteId();
        $arrValeursPostees['nom']                   = $objInnovateur->getNom();
        $arrValeursPostees['prenom']                = $objInnovateur->getPrenom();
        $arrValeursPostees['organisme_mindef_id']   = $objInnovateur->getCiviliteId();
        $arrValeursPostees['entite_id']             = $objInnovateur->getNom();

        $this->getRequest()->offsetUnset($this->objForm->getName());
        $this->getRequest()->setParameter($this->objForm->getName(),$arrValeursPostees);
      }

      if ($this->getRequest()->isXmlHttpRequest())
      {
        $boolResultat = $this->processForm('creer', null, false, true);
        if ($boolResultat)
        {
          die();
        }
      }
      else
      {
        $this->processForm('creer');
      }

    }
  }
}
?>
