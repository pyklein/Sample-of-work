<?php

/**
 * Classe de l'aide en ligne
 * @author Gabor JAGER
 */
class Aide
{
  /**
   *
   * @var boolean
   */
  private $boolAide = false;

  /**
   * Constructeur
   */
  public function __construct()
  {
    $strAideParametre = sfContext::getInstance()->getRequest()->getParameter("aide", null);

    // on change l'aide
    if ($strAideParametre != null)
    {
      // on active l'aide en ligne
      if ($strAideParametre == "1")
      {
        sfContext::getInstance()->getUser()->setAttribute("aide", 1);
      }

      // on désactive l'aide en ligne
      else
      {
        sfContext::getInstance()->getUser()->setAttribute("aide", null);
      }
    }

    $this->boolAide = sfContext::getInstance()->getUser()->getAttribute("aide", null);
  }

  /**
   * Permet de décider s'il faut affichier l'aide en ligne ou pas
   * @return boolean
   */
  public function hasAide()
  {
    return $this->boolAide;
  }

  /**
   * Permet de recuperer l'URL de changement de l'état de l'aide en ligne
   * @return string
   */
  public function getAideUrl()
  {
    $strUrl = preg_replace("/(\\?|&)aide=./", "", $_SERVER["REQUEST_URI"]);
    if (strpos($strUrl, "&"))
    {
      $strUrl = substr_replace($strUrl, "?", strpos($strUrl, "&"), 1);
    }
    $strUrl .= (strpos($strUrl, "?") ? "&" : "?")."aide=".($this->hasAide() ? "0" : "1");
    return $strUrl;
  }


  /**
   *  Retourne le html correspondant au contenu du fichier d'aide correspondant à l'action en cours.
   * @return html si réussi, false sinon
   */
  public function getAide()
  {
    $utilFichier = new UtilFichier();
    try{
      $strContenuAide = $utilFichier->getFichierContenu(sfContext::getInstance()->getModuleDirectory()."/../../templates/aide.php");
      $strAidePourAction = $this->trouveAidePourAction($strContenuAide);
      if (trim(str_replace(array("\n", "\r", "&nbsp;"), " ", strip_tags($strAidePourAction))) != "") {
        return $this->remplacePictogrammes($strAidePourAction);
      } else return false;
    } catch (Exception $ex){
      return false;
    }
  }


  /**
   *  Cherche le contenu brut du fichier d'aide correspondant à l'action en cours
   * @param string $strContenuAide contenu entier brut du fichier d'aide.
   * @return string partie de $strContenuAide.
   */
  protected  function trouveAidePourAction($strContenuAide){
    $ModuleAction = "%".sfContext::getInstance()->getModuleName().sfContext::getInstance()->getActionName()."%";
    $arrResultat = explode($ModuleAction, $strContenuAide);
    if (count($arrResultat) == 3){//3 resultats: avant, contenu, après
      return $arrResultat[1];
    } else {
      return false;
    }
  }

  /**
   *  Remplace les %PICTO_XXXX% par des balises html <span> avec la classe correspondante au picto
   * @param string $strAide contenu brut du fichier d'aide correspondant à l'action en cours
   * @return string  $strAide avec les balises html pour les pictogrammes
   */
  protected  function remplacePictogrammes($strAide){
    preg_match_all("/%PICTO_[[:alnum:]_]*%/", $strAide, $balisesPicto);
    foreach ($balisesPicto[0] as $balise){
      try{
      $classePicto = substr($balise, 7);
      $classePicto = trim($classePicto,"%");
      $strAide = str_replace($balise, "<span class=\"picto_court bt_".$classePicto."\"></span>", $strAide);
      }catch(Exception $ex) {
        continue;
      }
    }
    return $strAide;
  }
}
