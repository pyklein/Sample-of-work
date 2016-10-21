<?php

/**
 * Permet de generer une balise img (avec un lien vers la photo originale)
 * @param string $strSrcFichier source de photo
 * @param string $strSrcFichierOrig source de photo originale
 * @return string balise d'image (avec le lien vers la photo originale)
 */
function photo_tag($strSrcFichier, $strSrcFichierOrig = "")
{
  $intUid = rand(100000, 999999);
  $html = "<img id=\"".$intUid."\" src=\"".$strSrcFichier."\" />";

  if ($strSrcFichierOrig != "")
  {
    $html = "<a href=\"".$strSrcFichierOrig."\" target=\"_blank\">".$html."</a>";
    $html .= "<script type=\"text/javascript\">
                   $(document).ready(function() {
                     $('#".$intUid."').closest('a').fancybox({
                       'transitionIn'   : 'elastic',
                       'transitionOut'  : 'elastic',
                       'speedIn'        : 600,
                       'speedOut'       : 200,
                       'overlayColor'   : '#fff',
                       'overlayOpacity' : 0.8
                     });
                   });
                 </script>";
  }
  
  return $html;
}

/**
 * Permet de créer un chemin à une photo
 * @param string $strSrcFichier URL de fichier (par action Symfony)
 * @param boolean $boolAbsolute si le chemin doit être absolu ou pas
 * @param boolean $booThumb s'i lfaut chercher le thumbnail de l'image passé ou pas
 * @param boolean $boolPdf si le chemin est utiliser pour PDF ou pour le web
 * @return string chemin de l'image
 * @author Gabor JAGER
 */
function photo_path($strSrcFichier, $boolAbsolute = true, $booThumb = false, $boolPdf = false)
{
  if (!$boolPdf)
  {
    return url_for($strSrcFichier, $boolAbsolute);
  }

  // on recupere uniquement les paramètres
  $arrParties = explode("?", $strSrcFichier);
  if (isset($arrParties[1]))
  {
    $arrParties = explode("&", $arrParties[1]);

    // on vérifie tous les paramètre
    foreach($arrParties as $strParametre)
    {
      $arrParametreValeurs = explode("=", $strParametre);

      // on recupere le nom du fichier
      if ($arrParametreValeurs[0] == "fichier")
      {
        $strNomFichier = $arrParametreValeurs[1];

        $utilFichier = new UtilFichier();
        $srvArbo     = new ServiceArborescence();

        $arrThumbs = sfConfig::get("app_photos_thumbnails");

        // on rajoute le postfix de thumbnail s'il le faut
        if ($booThumb && !preg_match('/'.$arrThumbs['postfix'].'/', $strNomFichier))
        {
          $strNomFichier = $utilFichier->getFilename($strNomFichier).".".$arrThumbs['postfix'].".".$utilFichier->getExtension($strNomFichier);
        }

        // on cherche le repertoire du fichier
        $strRepertoire = $utilFichier->findRepertoireFichier($strNomFichier, $srvArbo->getRepertoireRacine());
        if ($strRepertoire != null)
        {
          return $strRepertoire.$strNomFichier;
        }
      }
    }
  }

  // on renvoie l'image "nophoto"
  return sfConfig::get("sf_web_dir").DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR."interface".DIRECTORY_SEPARATOR."noimage.png";
}
