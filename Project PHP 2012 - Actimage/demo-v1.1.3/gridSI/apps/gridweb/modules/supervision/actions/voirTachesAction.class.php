<?php

/**
 * Voir tâches - Action AJAX
 * @author Gabor JAGER
 */

class voirTachesAction extends sfAction
{
  public function preExecute()
  {
    if (!$this->getRequest()->isXmlHttpRequest())
    {
      $this->redirect("supervision/index");
    }
  }

  public function execute($request)
  {
  }
}

