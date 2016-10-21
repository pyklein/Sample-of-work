<?php

/**
 * Evenement filter form.
 *
 * @package    gridSI
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class EvenementFormFilter extends BaseEvenementFormFilter
{
  public function configure()
  {
    $this->useFields(array('created_by','created_at','est_cloture'));
  }
}
