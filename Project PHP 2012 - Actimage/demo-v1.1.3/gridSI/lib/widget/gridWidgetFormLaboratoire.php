<?php

/**
 * Widget service
 *
 * @author Alexandre WETTA
 */
class gridWidgetFormLaboratoire extends sfWidgetFormDoctrineChoice {

  public function configure($options = array(), $attributes = array()) {
    $this->addOption('popup', false);

    parent::configure($options, $attributes);
  }

  public function __construct($options = array(), $attributes = array()) {

    $options['model'] = 'Laboratoire';

    if (!array_key_exists('query', $options)) {
      $options['query'] = LaboratoireTable::getInstance()->buildQueryLaboratoiresActifsOrdreAscPourSelectBox();
    }
    if (!array_key_exists('add_empty', $options)) {
      $options['add_empty'] = libelle('msg_libelle_aucun');
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
      $strRetour .= link_to_grid_popup(' ', "referentiel/creerLaboratoirePopup", array(
                  "class" => "picto_court_popup bt_ajouter_popup",
                  "title" => libelle("msg_bouton_ajouter_laboratoire"),
                  "id" => "ajouter_laboratoire",
                      ), false);
    }

    return $strRetour;
  }

}
?>
