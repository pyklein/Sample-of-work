<?php
/**
 * Liste des entites
 *
 * @author Actimage
 */
class listerEntitesAction extends gridAction {
     public function preExecute()
  {
  }


  public function execute($objRequeteWeb)
  {

    //check si il y a un ID dans l'URL
    $this->boolRenderFiltre = $objRequeteWeb->hasParameter('id');
    $this->entiteId = $objRequeteWeb->getParameter('id');

    
    //si on n'a pas d'id alors c'est la page principale
    //sinon on désactive le filtre
    if(!$this->boolRenderFiltre){
      $this->objFormFiltre = new EntiteFormFilter();
      $objRequeteDoctrine = $this->processFiltreParRelation('Organisme_mindef'); //TODO: utiliser ProcessFiltre
      $this->processPager($objRequeteDoctrine, 'Entite',false);
      $this->arrEntite = '' ;
    }else{
      
      //on verifie si l'entité parent est active
      $this->boolEntiteActive = EntiteTable::getInstance()->verifieEntiteActiveRecursif($objRequeteWeb->getParameter('id'));
      
      $this->arrEntite = EntiteTable::getInstance()->retrieveEntiteByEntiteId($this->entiteId);
      $this->entiteParent = EntiteTable::getInstance()->findOneById($this->entiteId);

      if($this->entiteParent==null){
        $this->redirect("@non_autorise");
      }

      //si il n'y a pas d'entiteId dans l'entité parent cad que c'est une entité racine
      if($this->entiteParent->getEntiteId() == null){
        $this->boolEntiteRacine = true ;
      }else{
        $this->boolEntiteRacine = false ;
        $this->entiteParentEntiteId = EntiteTable::getInstance()->findOneById($this->entiteParent->getEntiteId());
      }

    }

  }

/**
 * ajouter l'id de l'entite parent pour la mettre en session
 * pour la gestion de l'historique
 *
 * @param $entiteId
 * @author Actimage
 */
 public function ajouterHistoriqueEntiteDansSession($entiteId)
  {
   // ajouter l'entite ID courante dans le tableau
    $arrEntite = array("id" => $entiteId);

    // changement de l'entite id dans la session
    $this->getUser()->setAttribute('entite_history', $arrEntite);
  }

  /**
 * recuperation de l'id de l'attribut 'entite_history'
 *
 * @return Array
 * @author Actimage
 */
public function retrieveEntiteIdDansSession()
  {

    $arrEntiteParentId = $this->getUser()->getAttribute('entite_history');

    $entiteParentId = $arrEntiteParentId['id'];

    return $entiteParentId;
  }

  /**
   */
  public function postExecute()
  {
  }
  
}
?>
