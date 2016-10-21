<?php

/**
 * Description of PointContactLaboratoireForm
 *
 * @author Simeon Petev
 */
class PointContactLaboratoireForm extends Point_contactForm
{
  public function  configure()
  {
    parent::configure();

    $this->embedRelation('Laboratoire', 'LaboratoireDossierMrisForm');
  }
}
