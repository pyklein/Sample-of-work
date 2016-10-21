<?php

/**
 * Permet de rajouter un lien vers un popup
 * @param string libellé
 * @param string action
 * @param array attributs
 * @param boolean si on recharge la page (avec jacascript) ou pas
 * @return string
 * @author Gabor JAGER
 */
function link_to_grid_popup() {

  if (sfContext::hasInstance())
  {
    sfContext::getInstance()->getResponse()->addJavaScript("jquery/jquery.fancybox-1.3.4.pack.js", 'last');
    sfContext::getInstance()->getResponse()->addJavaScript("jquery/jquery.easing-1.3.pack.js", 'last');
    sfContext::getInstance()->getResponse()->addJavaScript("jquery/jquery.mousewheel-3.0.4.pack.js", 'last');
    sfContext::getInstance()->getResponse()->addJavaScript("utilFancybox.js", 'last');
  }

  $arguments = func_get_args();
  $arguments[0] = str_replace(" ", "&nbsp;", $arguments[0]);
  $arguments[2]['target'] = '_blank';
  $boolReload = !isset($arguments[3]) ? true : $arguments[3];

  $html = call_user_func_array('link_to_grid', $arguments);

  $html .= "
<script type='text/javascript'>

  initFancybox('".$arguments[2]['id']."', ".($boolReload ? "true" : "false").");

</script>";

  return $html;
}

/**
 *  Enveloppe un link_to_grid dans des balises <li> si action autorisée, chaine vide (sans balises) sinon.
 * @return mixed html balise <li> ou ''.
 * @author William RICHARDS
 */
function link_to_grid_liste()
{
  $arguments = func_get_args();
  $html = call_user_func_array('link_to_grid',$arguments);
  if ( $html == ''){
    return '';
  }
  return '<li>'.$html.'</li>';
}
/**
 * Proxy pour link_to(), n'affiche rien si l'utilisateur n'a pas les credentials requis
 * @return html   balise <a>
 * @author William RICHARDS
 */
function link_to_grid()
{
  $objUtilisateur = sfContext::getInstance()->getUser();
  $arguments = func_get_args();

  // ajouter le tite automatiquement, si cela n'était pas renseigné
  if (!isset($arguments[2]["title"]))
  {
    $arguments[2]["title"] = $arguments[0];
  }

  if (strlen($arguments[1]) > 0)
  {
    $strActionUrl = $arguments[1];

    //récupération de l'action demandée
    $arrAction = preg_split('/[?&\/#]/', $strActionUrl);

    if ($objUtilisateur->peutAcceder($arrAction[0], $arrAction[1]))
    {
      return call_user_func_array('link_to',$arguments);
    }
  }
  else
  {
    return call_user_func_array('link_to',$arguments);
  }
}


/**
 * Permet de retourner à la page précedent. Utilise le HTTP_REFERER.
 * @return html balise 'a'
 */
function link_to_grid_retour($strLibelle, $arrAttributes = array())
{
  
  if (isset($_SERVER["HTTP_REFERER"]))
  {
    $arrRetour = explode($_SERVER["SCRIPT_NAME"], $_SERVER["HTTP_REFERER"]);
    $strRetour = substr($arrRetour[1], 1);

    $arrElements = explode("/", $arrRetour[1]);

    $strRetour = $arrElements[1]."/".$arrElements[2];
    for($i = 3; $i < count($arrElements); $i++)
    {
      $strRetour .= $i%2 == 0 ? "=" : ($i == 3 ? "?" : "&");
      $strRetour .= $arrElements[$i];
    }
  }
  else
  {
    $strRetour = "interface/index";
  }


  $arguments = array();
  $arguments[0] = $strLibelle;
  $arguments[1] = $strRetour;
  $arguments[2] = $arrAttributes;

  return call_user_func_array('link_to_grid', $arguments);
}

