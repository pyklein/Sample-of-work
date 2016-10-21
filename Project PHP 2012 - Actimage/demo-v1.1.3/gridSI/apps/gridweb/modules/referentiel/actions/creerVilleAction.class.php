<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//require_once dirname(__FILE__) . '\formProcessAction.class.php';

/**
 * Description of creerVilleAction
 *
 * @author William
 */
class creerVilleAction extends gridAction {

  public function execute($objRequeteWeb) {
    $strRedirection = '';
    $objVille = new Ville();
    if ($objRequeteWeb->hasParameter('departement')){
      $objDepartement = DepartementTable::getInstance()->findOneById($objRequeteWeb->getParameter('departement'));
      if (!$objDepartement || !$objDepartement->getEstActif()){
        $this->redirect('@non_autorise');
      }
      $objVille->setDepartement($objDepartement);
      $strRedirection = '?departement='.$objDepartement->getId();
    }
    $this->objForm = new VilleForm($objVille);
    if ($objRequeteWeb->isMethod('post')) {
      $this->processForm('creer','listerVilles'.$strRedirection);
    }
  }

}

?>
