<?php

/**
 * Validateur de fichier implémentant la vérification du type de fichier autorisé par rapport à une liste
 * présente dans app.yml
 * L'option fichier_editable doit être mise à true pour le fichiers editable
 *
 * @author William
 */
class gridValidatorFile extends sfValidatorFile {

  public function __construct($options = array(), $messages = array()) {
    $this->addOption('fichier_editable');
    $this->addOption('fichier_autre');
    $this->addOption('fichier_tous');
    $this->addOption('fichier_rtf');
    $this->addOption('fichier_pdf');
    $this->addOption('fichier_images');
    $this->addOption('fichier_bureau');
    
    parent::__construct($options, $messages);
  }


  public function doClean($value) {
    //verification de la présece de l'extension dans la liste blanche
    if(array_key_exists('name', $value)){
      
      $strNomFichierComplet = $value['name'];
      $strExtensionFichier = substr(strrchr($strNomFichierComplet, '.'),1);

      //si le fichier est un fichier editable alors on selectionne 'app_extensions_editables'
      if ($this->getOption('fichier_editable'))
      {
        $arrExtensionsAutorisees = explode(",",  str_replace(' ', '', sfConfig::get("app_extensions_editables")));
      }
      else if ($this->getOption('fichier_autre'))
      {
        $arrExtensionsAutorisees = explode(",",  str_replace(' ', '', sfConfig::get("app_extensions_autres")));
      }
      else if ($this->getOption('fichier_bureau'))
      {
        $arrExtensionsAutorisees = explode(",",  str_replace(' ', '', sfConfig::get("app_extensions_bureau")));
      }
      else if ($this->getOption('fichier_tous'))
      {
        $arrExtensionsAutorisees = explode(",",  str_replace(' ', '', sfConfig::get("app_extensions_editables").", ".sfConfig::get("app_extensions_autres")));
      }
      else if ($this->getOption('fichier_rtf'))
      {
        $arrExtensionsAutorisees = explode(",",  str_replace(' ', '', sfConfig::get("app_extensions_rtf")));
      }
      else if ($this->getOption('fichier_pdf'))
      {
        $arrExtensionsAutorisees = explode(",",  str_replace(' ', '', sfConfig::get("app_extensions_pdf")));
      }
      else if ($this->getOption('fichier_images'))
      {
        $arrExtensionsAutorisees = explode(",",  str_replace(' ', '', sfConfig::get("app_extensions_images")));
      }
      
      $this->addMessage('type_invalide', libelle("msg_libelle_erreur_type_fichier", array(implode(", ", $arrExtensionsAutorisees))));

      if (!in_array($strExtensionFichier,$arrExtensionsAutorisees)){
        throw new sfValidatorError($this, 'type_invalide');
      }
    }
    return parent::doClean($value);
  }
  
}
