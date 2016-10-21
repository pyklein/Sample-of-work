<?php

/**
 * Widget statut dossier MIP
 *
 * @author Simeon Petev
 */
class gridWidgetFormStatutDossierMip extends sfWidgetFormDoctrineChoiceParametered
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
    $options['model'] = 'Statut_dossier_mip';
    if (!array_key_exists('table_method', $options)){
      $options['table_method'] =  array('method' => 'retrieveStatutsParOrdre','parameters' => array(true));
    }
    if (!array_key_exists('method', $options)){
      $options['method'] = 'getIntitule';
    }
    if (!array_key_exists('add_empty', $options)){
      $options['add_empty'] = libelle('msg_libelle_aucune');
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
      $strRetour .= link_to_grid_popup(' ', "referentiel_mip/creerStatut_Dossier_mipPopup", array(
                                        "class" => "picto_court_popup bt_ajouter_popup",
                                        "title"=> libelle("msg_statut_dossier_mip_bouton_ajouter"),
                                        "id" => "ajouter_statut_dossier_mip",
                                        ), false);
    }

    return $strRetour;
  }
}
?>
