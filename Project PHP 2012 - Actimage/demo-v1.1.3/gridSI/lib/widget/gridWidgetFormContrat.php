<?php

/**
 * Widget pour les contrats
 *
 * @author Alexandre WETTA
 */
class gridWidgetFormContrat extends sfWidgetFormDoctrineChoiceParametered {

  public function __construct($options = array(), $attributes = array()) {

    $options['model'] = 'Contrat';
    $options['method'] = 'afficheContratEtStatut';

    if (!array_key_exists('add_empty', $options)) {
      $options['add_empty'] = libelle('msg_libelle_aucun');
    }


    parent::__construct($options, $attributes);
  }

}
?>
