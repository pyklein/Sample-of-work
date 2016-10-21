<?php

/**
 * Widget organisme MINDEF
 * @author Gabor JAGER
 */
class gridWidgetFormOrganismeMindef extends sfWidgetFormDoctrineChoice
{

  public function configure($options = array(), $attributes = array())
  {
    $this->addOption('popup', false);

    parent::configure($options, $attributes);
  }

  /**
   * Constructeur
   * @param array $options
   * @param array $attributes
   */
  public function  __construct($options = array(), $attributes = array())
  {
    $options['model'] = 'Organisme_mindef';
    if (!array_key_exists('query', $options)){
      $options['query'] = Organisme_mindefTable::getInstance()->retrieveOrganismesMindefActifPourSelectBox();
    }
    if (!array_key_exists('method', $options)){
      $options['method'] = 'getAbreviation';
    }
    if (!array_key_exists('add_empty', $options)){
      $options['add_empty'] = libelle('msg_libelle_aucun');
    }
    parent::__construct($options, $attributes);
  }

  public function  render($name, $value = null, $attributes = array(), $errors = array())
  {
    if ($this->getOption('popup'))
    {
      $attributes["class"] = isset($attributes["class"]) ? $attributes["class"]." popup" : "popup";
    }

    $strRetour = parent::render($name, $value, $attributes, $errors);
    
    // on rajoute le bouton vers le popup
    if ($this->getOption('popup'))
    {
      $strRetour .= link_to_grid_popup(' ', "referentiel/creerOrganisme_mindefPopup", array(
                                        "class" => "picto_court_popup bt_ajouter_popup",
                                        "title"=> libelle("msg_bouton_ajouter_organisme_mindef"),
                                        "id" => "ajouter_organisme_mindef",
                                        ), false);
    }

    return $strRetour;
  }
}
