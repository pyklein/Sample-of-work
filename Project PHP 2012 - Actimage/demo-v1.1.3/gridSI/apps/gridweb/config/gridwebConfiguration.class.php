<?php

class gridwebConfiguration extends sfApplicationConfiguration
{
  public function configure()
  {
    $this->loadProjectConfig();
    sfWidgetFormSchema::setDefaultFormFormatterName('grid');
  }

  protected function loadProjectConfig()
  {
    static $load = false;

    if (!$load && $this instanceof sfApplicationConfiguration)
    {
      require $this->getConfigCache()->checkConfig('config/msg.yml');
      $load = true;
    }
  }


}
