<?php

/**
 * Creation d'un nouveau pilote/utilisateur avec un popup
 *
 * @author Jihad SAHEBDIN
 */
class creerPilotePopupAction extends gridAction {

  public function execute($request) 
  {
    $objUtilMotDePasse = new UtilMotDePasse(sfConfig::get("app_mot_de_passe_longueur"), sfConfig::get("app_mot_de_passe_alphabet"));
    $strMotDePasseTemporaire = $objUtilMotDePasse->getMotDePasseAleatoire();

    $objPilote = new Utilisateur();
    $objPilote->setEstActif(true);
    $objPilote->setMotDePasse(sha1($strMotDePasseTemporaire));
    
    $this->objForm = new Utilisateur_PopupForm($objPilote);

	$arrValeursLDAP = array();
	
    if ($request->isMethod('post')) {
      
      $arrValeursPostees = $this->getRequest()->getParameter($this->objForm->getName());

      //On essay de recupere les informations LDAP
      try {
        $ldapService = new ServiceLdap();

        $arrValeursLDAP = $ldapService->recupereInformations($arrValeursPostees['email']);
      } catch (Exception $exc) {
        $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ Erreur - Echec connection LDAP; ");
      }

      if (count($arrValeursLDAP) > 0)
      {
        $objPilote->mettreAJourInformations($arrValeursLDAP);
        $objPilote->setEstUtilisateurLdap(true);

        $this->objForm = new Utilisateur_PopupForm($objPilote);

        $arrValeursPostees['civilite_id'] = $objPilote->getCiviliteId();
        $arrValeursPostees['nom']         = $objPilote->getNom();
        $arrValeursPostees['prenom']      = $objPilote->getPrenom();

        $this->getRequest()->offsetUnset($this->objForm->getName());
        $this->getRequest()->setParameter($this->objForm->getName(),$arrValeursPostees);
      }

      if ($this->getRequest()->isXmlHttpRequest()) {
        $boolResultat = $this->processForm('creer', null, false, false);
        
        if ($boolResultat)
        {
          $arrRetour = array();
          $arrRetour["select"] = array("valeur" => $objPilote->getId(), "libelle" => $objPilote->getNom()." ".$objPilote->getPrenom());
          
          $this->getResponse()->setHttpHeader('Content-Type','application/json');
          return $this->renderText(json_encode($arrRetour));
        }
      } else {
        $this->processForm('creer');
      }
    }
  }

}
?>
