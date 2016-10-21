<?php

/**
 * Formulaire pour la gestion du profil de l'utilisateur connecté
 *
 * @author Alexandre WETTA, William RICHARDS
 */
class GestionUtilisateurProfilForm extends UtilisateurForm {

 
  /**
   * Contructeur
   * @param string $typeForm Option pour les cas spéciaux
   * @param Objet $object
   * @param Option $options
   * @param CSRFSecret $CSRFSecret
   * @param Request $objRequest
   */
  public function __construct($typeForm = null, $object = null, $options = array(), $CSRFSecret = null, $objRequest = null) {

    //variable utilisé pour l'affichage des innovateurs
    if ($typeForm == 'innovateurLectureSeule') {
      $this->typeForm = $typeForm;
    }else{
       $this->typeForm = null ;
    }
   
    parent::__construct($object, $options, $CSRFSecret, $objRequest);
  }

  public function configure() {
    $objUtilArbo = new ServiceArborescence();
    parent::configure();

    if ($this->typeForm == 'innovateurLectureSeule') {

      $this->widgetSchema['photographie'] = new sfWidgetFormInputFileEditableJQuery(array(
                  'label' => libelle("msg_utilisateur_libelle_photo"),
                  'with_delete' => true,
                  'delete_label' => libelle('msg_utilisateur_libelle_supp_fichier'),
                  'file_src' => url_for("utilisateurs/chargerThumbnailProfilMip?fichier=" . $this->getObject()->getPhotographie() . "&path=" . bin2hex($objUtilArbo->getRepertoirePhotosUtilisateurs())),
                  'is_image' => true,
                  'extensions' => sfConfig::get("app_extensions_images"),
                  'edit_mode' => !$this->isNew() && (strlen($this->getObject()->getPhotographie()) > 0),
                  'template' => "%input% <br>
                      %delete_label% : %delete% <br>
                      <label></label>&nbsp;&nbsp;&nbsp;
                      <a id=\"img_photographie\" href=\"" .  url_for("interface/telechargerPhoto?fichier=" . $this->getObject()->getPhotographie() . "&path=" . bin2hex($objUtilArbo->getRepertoirePhotosUtilisateurs())) .   "\" target=\"_blank\">%file%</a>
                      ",
              ));
      
      
    } else {

      $this->widgetSchema['photographie'] = new sfWidgetFormInputFileEditableJQuery(array(
                  'label' => libelle("msg_utilisateur_libelle_photo"),
                  'with_delete' => true,
                  'delete_label' => libelle('msg_utilisateur_libelle_supp_fichier'),
                  'file_src' => url_for("utilisateurs/chargerThumbnailEditerProfilUtilisateur?fichier=" . $this->getObject()->getPhotographie() . "&path=" . bin2hex($objUtilArbo->getRepertoirePhotosUtilisateurs()). "&id=" . $this->getObject()->getId()),
                  'is_image' => true,
                  'extensions' => sfConfig::get("app_extensions_images"),
                  'edit_mode' => !$this->isNew() && (strlen($this->getObject()->getPhotographie()) > 0),
                  'template' => "%input% <br>
                      %delete_label% : %delete% <br>
                      <label></label>&nbsp;&nbsp;&nbsp;
                      <a id=\"img_photographie\" href=\"" . url_for("interface/telechargerPhoto?fichier=" . $this->getObject()->getPhotographie() . "&path=" . bin2hex($objUtilArbo->getRepertoirePhotosUtilisateurs())) .  "\" target=\"_blank\">%file%</a>
                      ",
              ));
    }

  }

}
?>
