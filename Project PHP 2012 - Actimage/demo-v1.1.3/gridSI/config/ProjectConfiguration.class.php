<?php

require_once dirname(__FILE__).'/../../lib/vendor/symfony-1.4.9/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    $this->enablePlugins('sfDoctrinePlugin', 'sfImageTransformPlugin','sfDoctrineActAsSignablePlugin');
  }

  //insertion d'une classe intermédiaire entre les baseRecord et sfDoctrineRecord
  public function configureDoctrine(Doctrine_Manager $manager)
  {
    $options = array('baseClassName' => 'gridDoctrine_Record');
    sfConfig::set('doctrine_model_builder_options', $options);
  }
}
