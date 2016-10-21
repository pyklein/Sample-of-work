<?php


/**
 * Retourne un libelle d'affichage pour un composent, en se basant sur un cle
 * Les cles et leurs valeurs sont dans un ou plusieurs fichiers yml.
 * 
 * @param String $strCle - De la forme aaa_bbb_ccc ou:
 *                            aaa - est le nom du fichier contenant la cle et sa valeur
 *                            bbb - est le deuxieme niveau dans l'arborecence des cles
 *                            ccc - est le troisieme niveau dans l'arborecence des cles
 *                         Info: le premiere niveau (all), napparait pas dans le nom
 *                               On peut avoir moins que trois niveaux
 *                         EX: msg_bouton_confirmer
 * @param Array $arrValeurs - Un array de valeurs de type string et à inroduir dans
 *                            valeur recuperé du fichier yml, en remplaceant les
 *                            marqueurs de type {int}
 *                            Ex: {0}
 * @return String
 *
 * @author Simeon PETEV
 */
function libelle($strCle,$arrValeurs=array())
{
  $strRetour = "";

  $strRetour = sfConfig::get($strCle);

  $intCompteur=0;
  foreach ($arrValeurs as $value)
  {
    $strRempDansLibelle = "{".$intCompteur."}";

    $strRetour = str_replace($strRempDansLibelle, "<strong>".strip_tags($value)."</strong>", $strRetour);

    $intCompteur++;
  }

  if (empty($strRetour))
  {
    $strRetour = $strCle;
  }

  return $strRetour;
}

/**
 * Retourne un libelle d'affichage pour un composent, en se basant sur un cle
 * Les cles et leurs valeurs sont dans un ou plusieurs fichiers yml.
 * Identique à libelle hormis l'encadrement des valeurs paramétrées
 * Fonction utilisée principalement pour la génération de graphiques
 * 
 * @param String $strCle - De la forme aaa_bbb_ccc ou:
 *                            aaa - est le nom du fichier contenant la cle et sa valeur
 *                            bbb - est le deuxieme niveau dans l'arborecence des cles
 *                            ccc - est le troisieme niveau dans l'arborecence des cles
 *                         Info: le premiere niveau (all), napparait pas dans le nom
 *                               On peut avoir moins que trois niveaux
 *                         EX: msg_bouton_confirmer
 * @param Array $arrValeurs - Un array de valeurs de type string et à inroduir dans
 *                            valeur recuperé du fichier yml, en remplaceant les
 *                            marqueurs de type {int}
 *                            Ex: {0}
 * @return String
 *
 * @author Julien GAUTIER
 */
function libelle_graphiques($strCle,$arrValeurs=array()) {
  $strRetour = "";

  $strRetour = sfConfig::get($strCle);

  $intCompteur=0;
  foreach ($arrValeurs as $value)
  {
    $strRempDansLibelle = "{".$intCompteur."}";

    $strRetour = str_replace($strRempDansLibelle, $value, $strRetour);

    $intCompteur++;
  }

  if (empty($strRetour))
  {
    $strRetour = $strCle;
  }

  return $strRetour;

}

/**
 * Libelle helper surcouhce pour l'export RTF
 * @see libelle()
 * @author Gabor JAGER
 */
function libelle_rtf($strCle, $arrValeurs=array())
{
  return strip_tags(libelle($strCle, $arrValeurs));
}
