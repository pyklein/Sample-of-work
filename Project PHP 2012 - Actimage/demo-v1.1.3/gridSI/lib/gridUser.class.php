<?php

class gridUser extends sfBasicSecurityUser
{
  /**
   * Permet de stocker en session des attributs liés à une action
   * La variable sera enregistré en session avec le nom /nomModule/nomAction/cle
   * @param string $strCle
   * @param string $strValeur
   * @author Gabor JAGER
   */
  public function setAttributeAction($strCle, $strValeur)
  {
    $strCle = '/'.sfContext::getInstance()->getModuleName().'/'.sfContext::getInstance()->getActionName().'/'.$strCle;

    $this->setAttribute($strCle, $strValeur);
  }

  /**
   * Permet de  récupérer de session des attributs liés à une action
   * @param string $strCle
   * @return string valeur récupéré
   * @author Gabor JAGER
   */
  public function getAttributeAction($strCle, $default = null, $strModuleAction = "")
  {
    if ($strModuleAction == "")
    {
      $strModuleAction = sfContext::getInstance()->getModuleName().'/'.sfContext::getInstance()->getActionName();
    }
    $strCle = '/'.$strModuleAction.'/'.$strCle;

    return $this->getAttribute($strCle, $default);
  }

  /**
   * Permet de verifier la présence en session des attributs liés à une action
   * @param string $strCle
   * @param string $strModuleAction
   * @return bool présence de l'attribut
   * @author William RICHARDS
   */
  public function hasAttributeAction($strCle, $strModuleAction = "")
  {
    if ($strModuleAction == "")
    {
      $strModuleAction = sfContext::getInstance()->getModuleName().'/'.sfContext::getInstance()->getActionName();
    }
    $strCle = '/'.$strModuleAction.'/'.$strCle;

    return $this->hasAttribute($strCle);
  }
}
