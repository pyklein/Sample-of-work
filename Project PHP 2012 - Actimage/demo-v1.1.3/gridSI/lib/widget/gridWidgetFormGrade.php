<?php

/**
 * Widget grade
 * @author Gabor JAGER
 */
class gridWidgetFormGrade extends sfWidgetFormChoice {

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
    $options["choices"] = array_merge(array("" => libelle('msg_libelle_aucune')),
                    GradeTable::getInstance()->getArrAssocOrgMindef());

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
      $strRetour .= link_to_grid_popup(' ', "referentiel/creerGradePopup", array(
                                        "class" => "picto_court_popup bt_ajouter_popup",
                                        "title"=> libelle("msg_bouton_ajouter_grade"),
                                        "id" => "ajouter_grade",
                                        ), false);
    }

    return $strRetour;
  }


}
