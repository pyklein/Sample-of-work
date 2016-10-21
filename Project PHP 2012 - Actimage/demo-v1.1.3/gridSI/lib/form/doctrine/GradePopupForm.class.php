<?php

/**
 * Grade form.
 *
 * @package    gridSI
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class GradePopupForm extends GradeForm
{
  public function configure()
  {
    parent::configure();

    // dans le popup on n'a plus d'autre popup
    $this->widgetSchema['organisme_mindef_id'] = new gridWidgetFormOrganismeMindef(array("popup" => false));
  }
}
