<?php

/**
 * Modification d'une entité
 *
 * @author Actimage
 */
class modifierEntiteAction extends gridAction
{

  public function preExecute()
  {
    if (!$this->getRequest()->hasParameter('id'))
    {
      $this->redirect("@non_autorise");
    }
  }

  public function execute($request)
  {
    //on verifie qu'il y a bien un ID dans l'URL
    if (!$request->hasParameter('id'))
    {
      $this->redirect("@non_autorise");
    }

    $objEntite = EntiteTable::getInstance()->findOneById($request->getParameter('id'));

    // si l'entite n'existe pas on redirige
    if ($objEntite == null || $request->getParameter('id') == null)
    {
      $this->redirect("@non_autorise");
    }

    //on cherche si l'entité à une entite_id donc un parent
    if($objEntite->getEntiteId() != null) $objEntiteParent = EntiteTable::getInstance()->findOneById($objEntite->getEntiteId());


    $this->objForm = new EntiteForm($objEntite);
    if ($request->isMethod('post'))
    {
      //l'entite à un parent donc on redirige sur la bonne page
      if(isset($objEntiteParent) && $objEntiteParent != null)
      {
         $this->processForm('modifier', 'listerEntites?id='.$objEntiteParent->getId());
      }
      else
      {
         $this->processForm('modifier');
      }
      

    }
  }
}
