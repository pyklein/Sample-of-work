<?php

/**
 * Widget Entité, configuré par défaut pour Form et sans affichage des entités désactivés
 * @author Gabor JAGER
 */
class gridWidgetFormEntite extends sfWidgetFormDoctrineChoice {

  public function configure($options = array(), $attributes = array()) {
    $this->addOption('popup', false);
    $this->addOption('popupDeuxiemeFois', false);

    parent::configure($options, $attributes);
  }

  /**
   * Constructeur
   * @param array $options
   * @param array $attributes
   */
  public function __construct($options = array(), $attributes = array()) {
    $options['model'] = 'Entite';
    
    if (!array_key_exists('query', $options)) {
      $options['query'] = EntiteTable::getInstance()->getQueryEntitesTrieAscPourSelectBox();
    }
    
    if (!array_key_exists('method', $options)) {
      $options['method'] = 'getNomHierarchique';
    }
    if (!array_key_exists('add_empty', $options)) {
      $options['add_empty'] = libelle('msg_libelle_aucune');
    }
    parent::__construct($options, $attributes);
  }

  public function render($name, $value = null, $attributes = array(), $errors = array()) 
  {
    if ($this->getOption('popup'))
    {
      $attributes["class"] = isset($attributes["class"]) ? $attributes["class"]." popup" : "popup";
    }

    $strRetour = parent::render($name, $value, $attributes, $errors);

    // on rajoute le bouton vers le popup
    if ($this->getOption('popup') && !$this->getOption('popupDeuxiemeFois')) {
      $strRetour .= link_to_grid_popup(' ', "referentiel/creerEntitePopup", array(
                  "class" => "picto_court_popup bt_ajouter_popup",
                  "title" => libelle("msg_bouton_ajouter_entite"),
                  "id" => "ajouter_entite",
                      ), false);
    }

    //on change l'id s'il y a la popup une deuxieme fois sur le formulaire
    if ($this->getOption('popup') && $this->getOption('popupDeuxiemeFois')) {
      $strRetour .= link_to_grid_popup(' ', "referentiel/creerEntitePopup", array(
                  "class" => "picto_court_popup bt_ajouter_popup",
                  "title" => libelle("msg_bouton_ajouter_entite"),
                  "id" => "ajouter_entite_deuxieme_fois",
                      ), false);
    }

    return $strRetour;
  }

}
