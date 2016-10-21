<?php

class myUser extends gridUser
{
  private $security;


  public function getId(){
    if ($this->getUtilisateur()){
    return $this->getUtilisateur()->getId();
    } else {
      return null;
    }
  }

  /**
   * Permet de set les données utilisateurs apres une authentification
   *  -> sauvegarde de l'objet
   *  -> sauvegarde des droits
   * @param Utilisateur $objUtilisateur
   * @author CNoel
   */
  public function setUtilisateur(Utilisateur $objUtilisateur)
  {
    $this->setAttribute('utilisateur', $objUtilisateur);

    // On set les droits
    $this->setDroits($objUtilisateur);
  }

  /**
   * Permet de récupérer l'objet Utilisateur stocké en session
   * @author CNoel
   * @return Utilisateur
   */
  public function getUtilisateur()
  {
    return $this->getAttribute('utilisateur');
  }

  /**
   * Permet d'enregistrer les credentiels de l'Utilisateur
   * @param Utilisateur $objUtilisateur
   * @author Gabor JAGER
   */
  private function setDroits(Utilisateur $objUtilisateur)
  {
    $arrProfils = ProfilTable::getInstance()->getProfilsParUtilisateur($objUtilisateur->getId());

    if ($arrProfils != null && count($arrProfils) > 0)
    {
      // boucle sur les profils
      foreach($arrProfils as $objProfil)
      {
        $strCodeCredential = $objProfil->getCode();
        $objMetier = $objProfil->getMetier();

        if (!$objMetier->getEstAdministrateur())
        {
          $strCodeCredential .= "-".$objMetier->getIntitule();
        }

        // Set des droits de l'utilisateur
        $this->addCredential($strCodeCredential);
      }
    }
  }

  /**
   * Verifie si l'utilisateur a au moins un profil appartenant au metier
   * @param string $strIntituleMetier L'intitulé du metier. Utilise les constants de la classe MetierTable.
   * @return boolean
   * @author Gabor JAGER
   */
  public function hasMetier($strIntituleMetier)
  {
    $arrCredentials = $this->getCredentials();

    foreach ($arrCredentials as $strCredential)
    {
      if (stripos($strCredential, $strIntituleMetier))
      {
        return true;
      }
    }

    return false;
  }

  /**
   * Verifie si l'utilisateur est administrateur ou pas
   * @return boolean
   * @author Gabor JAGER
   */
  public function isAdministrateur()
  {
    $arrCredentials = $this->getCredentials();
    $strAdmin = "ADM";
    foreach ($arrCredentials as $strCredential)
    {
      if ($strCredential == $strAdmin)
      {
        return true;
      }
    }

    return false;
  }

  public function peutAcceder($module, $action)
  {
    require(sfContext::getInstance()->getConfigCache()->checkConfig(sfConfig::get('sf_app_module_dir').DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'security.yml', true)); 

    if (isset($this->security[strtolower($action)]['credentials']))
    {
      $credentials = $this->security[strtolower($action)]['credentials'];
    }
    else if (isset($this->security['all']['credentials']))
    {
      $credentials = $this->security['all']['credentials'];
    }
    else
    {
      $credentials = true;
    }
    return $this->hasCredential($credentials);
  }
}
