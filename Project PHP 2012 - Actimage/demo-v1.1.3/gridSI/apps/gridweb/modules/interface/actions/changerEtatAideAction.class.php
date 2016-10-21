<?php

/**
 * Change l'état de l'aide
 * @author Gabor JAGER
 */
class changerEtatAideAction extends sfAction
{
  public function execute($request)
  {
    if (!$request->hasParameter('valeur'))
    {
      $this->redirect('@non_autorise');
    }

    sfContext::getInstance()->getUser()->setAttribute("aide", $request->getParameter('valeur') == "1" ? 1 : null);
  
    return sfView::NONE;
  }
}
