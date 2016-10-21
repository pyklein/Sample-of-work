<?php

/**
 * Chargement du widget ville
 * @author Gabor JAGER
 */
class chargerWidgetVilleAction extends sfAction
{

  public function preExecute()
  {
    if (!$this->getRequest()->isXmlHttpRequest()
        || !$this->getRequest()->hasParameter('cp'))
    {
      $this->redirect("@accueil");
    }
  }

  public function execute($request)
  {
    $this->arrVilles = VilleTable::getInstance()->buildQueryVilleActifsOrdreAscPourSelectBox($this->getRequest()->getParameter('cp'))->execute();
  }
}
