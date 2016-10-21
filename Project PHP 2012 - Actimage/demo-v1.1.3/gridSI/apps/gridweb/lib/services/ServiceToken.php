<?php

/**
 * Class permet de gérer les tokens d'utilisateur
 * @author William, Gabor JAGER
 */
class ServiceToken
{
  /**
   * Utilisateur connecté
   * @var myUser
   */
  private $objUser;

  /**
   * Constructeur
   */
  public function  __construct()
  {
    $this->objUser = sfContext::getInstance()->getUser();
  }

  /**
   * Permet de generer un transaction token et l'enregistrer en session de l'utilisateur (avec le clé)
   * @param string $strCle clé de token
   * @param string $strId identifiant
   * @return string transaction token
   * @throws Exception si l'utilisateur n'est pas connecté
   */
  public function creerToken($strCle, $strId = "")
  {
    $this->checkUtilisateur();
    
    // création nouveau token
    $strToken = "u".$this->objUser->getUtilisateur()->getId().$strId."r".rand(1000, 9999);
    $this->objUser->setAttribute($strCle, $strToken);

    return $strToken;
  }

  /**
   * Permet de nettoyer le token
   * @param string $strCle clé de token
   * @throws Exception si l'utilisateur n'est pas connecté
   */
  public function nettoyerToken($strCle)
  {
    $this->checkUtilisateur();
    $this->objUser->setAttribute($strCle, '');
  }

  /**
   * Permet de recuperer le token à partir de la session
   * @param string $strCle clé de token
   * @return string transaction token stocké dans la session (s'il existe dans la session)
   *                sinon string vide
   * @throws Exception si l'utilisateur n'est pas connecté
   */
  public function getToken($strCle)
  {
    $this->checkUtilisateur();
    return $this->objUser->getAttribute($strCle, '');
  }

  /**
   * Permet de décider si le token existe déja ou pas
   * @param string $strCle clé de token
   * @return boolean true si le token existe
   *                 false sinon
   * @throws Exception si l'utilisateur n'est pas connecté
   */
  public function hasToken($strCle)
  {
    $this->checkUtilisateur();
    return $this->objUser->hasAttribute($strCle);
  }

  /**
   * Permet de vérifier si l'utilisateur est bien connecté ou pas
   * @throws Exception si l'utilisateur n'est pas connecté
   */
  private function checkUtilisateur()
  {
    if (!$this->objUser)
    {
      throw new Exception("L'utilisateur n'est pas connecté.");
    }
  }
}
