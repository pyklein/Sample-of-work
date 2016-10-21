<?php

/**
 * Description of sfWidgetFormReadOnly
 *
 *  Widget en lecture seule (affiche la donnée en italique)
 *
 * @author William
 */
class sfWidgetFormReadOnly extends sfWidgetFormInput {

  /**
   * Constructor.
   *
   * Available options:
   *
   *  * content: Contenu, utilisé pour afficher la valeur d'une dépendance; format: array('model','methode
   *
   * @param array $options     An array of options
   * @param array $attributes  An array of default HTML attributes
   *
   * @see sfWidgetForm
   */
  public function __construct($options = array(), $attributes = array()) {
    $this->addOption('content');
    parent::__construct($options, $attributes);
  }

  public function render($name, $value = null, $attributes = array(), $errors = array()) {
    $contenu = $this->getOption('content');
    $strAffichage = $value;
    if (is_array($contenu)) {
      if (!array_key_exists('model', $contenu)) {
        throw new InvalidArgumentException(sprintf("Un argument 'model' est requis"));
      }

      if (!array_key_exists('method', $contenu)) {
        $contenu = array_merge($contenu, array('method' => '__toString'));
      }

      try {
        $objEnregistrement = Doctrine_core::getTable($contenu['model'])->findOneById($value);
        $strAffichage = call_user_func(array($objEnregistrement, $contenu['method']));
      } catch (Exception $exc) {
        $strAffichage = libelle('msg_libelle_aucun');
      }
    }
    $attributes = array_merge($attributes,array('class' => 'readonlywidget','readonly' => 'true'));

    return $this->renderContentTag('input', $strAffichage,array_merge($attributes,array('value' => $value,'type' => 'hidden','name' => $name)));
  }

}

?>
