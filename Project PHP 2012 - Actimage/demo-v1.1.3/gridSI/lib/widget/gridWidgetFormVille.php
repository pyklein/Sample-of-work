<?php

/**
 * Widget ville
 * @author Gabor JAGER
 */
class gridWidgetFormVille extends sfWidgetFormDoctrineChoice {

  public function configure($options = array(), $attributes = array()) {
    $this->addOption('popup', false);

    parent::configure($options, $attributes);
  }

  /**
   * Constructeur
   * @param array $options
   * @param array $attributes
   */
  public function __construct($options = array(), $attributes = array()) {
    $options['model'] = 'Ville';
    if (!array_key_exists('query', $options)) {
      $options['query'] = VilleTable::getInstance()->buildQueryVilleActifsOrdreAscPourSelectBox();
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
    if ($this->getOption('popup')) {
      $strRetour .= link_to_grid_popup(' ', "referentiel/creerVillePopup", array(
                  "class" => "picto_court_popup bt_ajouter_popup",
                  "title" => libelle("msg_bouton_ajouter_ville"),
                  "id" => "ajouter_ville",
                      ), false);
    }

    return $strRetour;
  }

}
