<?php

/**
 * Création d'une nouvelle entité
 *
 * @author Actimage
 */
class creerEntiteAction extends gridAction {

  public function execute($request) {

    $objEntite = new Entite();

    if ($request->getParameter('entite_id') != null) {
      
      $objEntiteParent = EntiteTable::getInstance()->findOneById($request->getParameter('entite_id'));

      $this->strEntiteParentId = $request->getParameter('entite_id') ;

      //on vérifie si l'entité et ses parents sont actifs sinon on redirige
      $this->boolEntiteActive = EntiteTable::getInstance()->verifieEntiteActiveRecursif($request->getParameter('entite_id'));
      if (!$this->boolEntiteActive) {
        $this->redirect('@non_autorise');
      }

      //on set l'organisme MINDEF de la nouvel entité avec celui de son parent
      $objOrgMindefEntiteParent = Organisme_mindefTable::getInstance()->findOneById($objEntiteParent->getOrganismeMindefId());
      $objEntite->setOrganismeMindefId($objOrgMindefEntiteParent->getId());
    }
    

    if ($request->hasParameter('orgmindef')) {
      $objOrgMindef = Organisme_mindefTable::getInstance()->findOneById($request->getParameter('orgmindef'));
      if (!$objOrgMindef || !$objOrgMindef->getEstActif()) {
        $this->redirect('@non_autorise');
      }
      $objEntite->setOrganismeMindefId($objOrgMindef->getId());
    }

    $this->objForm = new EntiteForm($objEntite);
    if ($request->isMethod('post')) {
      if (isset($this->strEntiteParentId)) {

        $this->processForm('creer','listerEntites?id='.$this->strEntiteParentId);
      } else {
        $this->processForm('creer');
      }
    }
  }

}
?>
