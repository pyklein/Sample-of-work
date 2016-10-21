<?php

/**
 * Remarque_bpi form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class Remarque_bpiForm extends BaseRemarque_bpiForm
{
  public function configure()
  {
    $this->useFields(array('contenu'));

    $this->widgetSchema['contenu'] = new sfWidgetFormTextareaCKEditor();
    $this->widgetSchema['contenu']->setLabel(libelle("msg_libelle_contenu"));
    $this->setValidator('contenu',new gridValidatorTextarea(array('required' => true),array('required'=> libelle('msg_libelle_contenu_remarque_required'))));
    parent::configure();
    
  }
}
