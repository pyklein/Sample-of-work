<?php

/**
 * Action de non authorisation
 * @author Gabor JAGER
 */
class nonAutoriseAction extends sfAction
{
  public function execute($request)
  {
    if ($this->getUser()->hasFlash('msg'))
    {
      $this->strMsg = $this->getUser()->getFlash('msg');
    }
  }
}

