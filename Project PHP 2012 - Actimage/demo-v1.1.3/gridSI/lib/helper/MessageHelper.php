<?php

/**
 * Permet d'afficher les messages de succes de d'erreur
 * @return string
 * @author Gabor JAGER
 */
function message()
{
  $strRetour = "";

  // objet user
  $objUser = sfContext::getInstance()->getUser();

  if (!$objUser)
  {
      return $strRetour;
  }

  // message d'erreur
  if ($objUser->getFlash('erreur'))
  {
    if (is_array($objUser->getFlash('erreur')))
    {
      foreach($objUser->getFlash('erreur') as $strMessage)
      {
        $strRetour .= '<div class="erreurMessage">'.$strMessage.'</div>';
      }
    }
    else
    {
      $strRetour .= '<div class="erreurMessage">'.$objUser->getFlash('erreur').'</div>';
    }
  }

  // message de succes
  if ($objUser->getFlash('succes'))
  {
    if (is_array($objUser->getFlash('succes')))
    {
      foreach($objUser->getFlash('succes') as $strMessage)
      {
        $strRetour .= '<div class="succesMessage">'.$strMessage.'</div>';
      }
    }
    else
    {
      $strRetour .= '<div class="succesMessage">'.$objUser->getFlash('succes').'</div>';
    }
  }

  // message de succes
  if ($objUser->getFlash('warning'))
  {
    if (is_array($objUser->getFlash('warning')))
    {
      foreach($objUser->getFlash('warning') as $strMessage)
      {
        $strRetour .= '<div class="warningMessage">'.$strMessage.'</div>';
      }
    }
    else
    {
      $strRetour .= '<div class="warningMessage">'.$objUser->getFlash('warning').'</div>';
    }
  }

  if (strlen($strRetour) > 0)
  {
      $strRetour .= "<br>";
  }

  $objUser->setFlash('erreur', '');
  $objUser->setFlash('succes', '');
  $objUser->setFlash('warning', '');

  return $strRetour;
}
