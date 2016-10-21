<?php

/**
 * sfWidgetFormInputFileEditable extension en utilisant fancybox pour l'affichage de photo
 * @author Gabor JAGER
 */
class sfWidgetFormInputFileEditableJQuery extends sfWidgetFormInputFileEditable
{
  private $strId = "image";

  public function  __construct($options = array(), $attributes = array()) 
  {
    $this->addOption('avec_javascript', true);
    $this->addOption('extensions', null);

    $utilPhp = new ServiceFichier();
    $options["label"] .= "<br /><span class='aide'>".libelle("msg_libelle_taille_maximum", array($utilPhp->getMaxUploadSizeEnFormatHumain()))."</span>";

    if (isset($options["extensions"]) && $options["extensions"] != null)
    {
      $utilString = new UtilString();
      $options["label"] .= "<br /><span class='aide' title=\"".strip_tags(libelle("msg_libelle_fichiers_acceptes", array($options["extensions"])))."\">".libelle("msg_libelle_fichiers_acceptes", array(substr($options["extensions"], 0, 10).(strlen($options["extensions"]) > 10 ? "..." : "")))."</span>";
    }

    if (!isset($attributes["class"])){
      $attributes["class"] = "thumb";
    }
    parent::__construct($options, $attributes);
  }

  public function configure($options = array(), $attributes = array())
  {
    parent::configure($options, $attributes);
  }

  protected function getFileAsTag($attributes)
  {
    if ($this->getOption('avec_javascript'))
    {
      if (!isset($attributes["id"]))
      {
        $attributes["id"] = $this->generateId($this->strId);
      }

      $htmlImg = "<script type=\"text/javascript\">
                     $(document).ready(function() {
                       $('#".$attributes["id"]."').closest('a').fancybox({
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
    else
    {
      $htmlImg = "";
    }

    $htmlImg .= parent::getFileAsTag($attributes);

    return $htmlImg;
  }
}
