<?php

/**
 * Activer/Desactiver un inventeur
 * @author Gabor JAGER
 */
class changerActivationInventeurAction extends gridAction
{
  public function  preExecute()
  {
    parent::preExecute();
  }

  public function execute($request)
  {
    if (sfContext::hasInstance())
    {
      sfContext::getInstance()->getLogger()->debug(__CLASS__.'->'.__FUNCTION__.'() Start');
    }

    $this->changerActivation($request->getParameter('id'), 'Inventeur');

    if (sfContext::hasInstance())
    {
      sfContext::getInstance()->getLogger()->debug(__CLASS__.'->'.__FUNCTION__.'() End');
    }
  }

  public function  postExecute()
  {
    parent::postExecute();
  }
}
