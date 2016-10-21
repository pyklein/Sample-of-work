<?php

/**
 * Permet de formater une date
 * @param string $strDate date en format SQL
 * @return string en format jj/mm/aaaa
 * @author Gabor JAGER
 */
function formatDate($strDate)
{

  //si c'est un date au format jj/mm/aaaa , la fonction renvoie jj/mm/aaaa
  if(preg_match('#^\d{2}/\d{2}/\d{4}$#', $strDate)) return $strDate ;

  //si c'est un date au format jj-mm-aaaa , la fonction renvoie jj-mm-aaaa
  if(preg_match('#^\d{2}-\d{2}-\d{4}$#', $strDate)) return $strDate ;
  
  return date('d/m/Y', strtotime($strDate));
}

/**
 * Permet d'extraire l'heure et les minutes dans un format HHhMM. Ex. 10h34
 *
 * @param Timestamp $strDate Le timestamp a fouiller
 * @return string L'heure et les minutes
 *
 * @author Simeon PETEV
 */
function formatHeure($strDate)
{
  return str_replace(':', 'h', date('H:i', strtotime($strDate)));
}

/**
 * Prend un PATH d'un fichier et construit le nom du thumbnal qui lui correspond
 *
 * @param string $strPathCompletImage PATH complet du fichier de size original
 * @return string PATH complet du thumbnail
 *
 * @author Simeon PETEV
 */
function nomImageThumbnail($strPathCompletImage)
{
  $utilFichier = new UtilFichier();

  $strRepertoire = $utilFichier->getParent($strPathCompletImage);
  $strFilename   = $utilFichier->getFilename($strPathCompletImage);
  $strExtension  = $utilFichier->getExtension($strPathCompletImage);

  $arrThumbnails = sfConfig::get("app_photos_thumbnails");

  $strPathCompletThumbnail = $strRepertoire.DIRECTORY_SEPARATOR.$strFilename.'.'.$arrThumbnails["postfix"].'.'.$strExtension;

  return $strPathCompletThumbnail;
}

/**
 * retourne un nombre formaté sous la forme Fr (ex: 1 250,50)
 * @param float $nombre
 * @return string
 * @author Alexandre WETTA
 */
function formatNombreFr($nombre) {
  return number_format($nombre, 2, ',', ' ');
}

/**
 * retourne un montant formaté sous la forme Fr (ex: 1 250,50 €)
 * @param float $nombre
 * @return string
 * @author Gabor JAGER
 */
function formatMontantFr($nombre) {
  return formatNombreFr($nombre)." €";
}
