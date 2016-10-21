<?php

if (sfContext::hasInstance())
{
  sfContext::getInstance()->getResponse()->addJavaScript("ckeditor/ckeditor.js", 'last');
  sfContext::getInstance()->getResponse()->addJavaScript("ckeditor/adapters/jquery.js", 'last');
}

/**
 * CKEditor widget.
 * CKEditor doit être installé dans le répertoire web/js/ckeditor
 * @author     Gabor JAGER
 */
class sfWidgetFormTextareaCKEditor extends sfWidgetFormTextarea
{
  /**
   * Constructor.
   *
   * Available options:
   *
   *  * width:  Width
   *  * height: Height
   *  * tool: CKEditor toolbar name
   *  * config: The javascript configuration file
   *
   * @param array $options     An array of options
   * @param array $attributes  An array of default HTML attributes
   *
   * @see sfWidgetForm
   */
  protected function configure($options = array(), $attributes = array())
  {
    $this->addOption('width', 500);
    $this->addOption('height', 150);
  }

  /**
   * @param  string $name        The element name
   * @param  string $value       The value selected in this widget
   * @param  array  $attributes  An array of HTML attributes to be merged with the default HTML attributes
   * @param  array  $errors      An array of errors for the field
   *
   * @return string An HTML tag string
   *
   * @see sfWidgetForm
   */
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $attributes = array_merge($this->attributes, $attributes);

    $strTextarea = parent::render($name, $value, $attributes, $errors);

    // get ID attribute
    $strId = $this->generateId($name);
    
    $strJs = "
<script type='text/javascript'>
  var config = {
    toolbar             : 'Custom',
    toolbar_Custom      : [['Bold', 'Italic', 'Underline', 'Strike', '-', 'NumberedList', 'BulletedList', '-', 'Undo', 'Redo']],
    language            : 'fr',
    resize_enabled      : false,
    entities            : false,
    entities_latin      : false,
    toolbarCanCollapse  : false,
    width               : '".$this->getOption('width')."',
    height              : '".$this->getOption('height')."'
  };

  $('#".$strId."').ckeditor(config);
</script>";

    return "<span class=\"fck_zone_texte\">".$strTextarea."</span>".$strJs;
  }
}
