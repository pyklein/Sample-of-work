<?php

/**
 * Liste des dossiers concernés par une commission
 *
 * @author Actimage
 */
class listerDossiersCommissionAction extends gridAction {

  public function preExecute() {
    parent::preExecute();
  }

  public function execute($request) {

    //on verifie que tt les paramètres sont là
    if ($this->request->hasParameter('id') && ($this->request->hasParameter('proposition') XOR $this->request->hasParameter('EnCours'))) {
      $boolCheckOk = true;
    } else {
      $boolCheckOk = false;
    }
    //s'il y a un paramètre manquant, on redirige
    if (!$boolCheckOk) {
      $this->redirect("@non_autorise");
    }
    //on vérifie que la commission existe bien, sinon on redirige
    $objCommission = CommissionTable::getInstance()->findOneById($request->getParameter('id'));
    if ($objCommission == null) {
      $this->redirect("@non_autorise");
    }

    $this->objCommission = $objCommission;

    $this->strId = $request->getParameter('id');
    $this->arrDomaineScientifique = Domaine_scientifiqueTable::getInstance()->findAll();

    //on selectionne le bon onglet en fonction du paramètre de l'url
    //et on cherche les bons dossiers en fonction de l'onglet
    $arrPager = array();
    $this->checkListeNonVide = false ;
    if ($this->request->hasParameter('proposition')) {
      $this->checkBonnePage = 'proposition';

      $this->checkTypeDossier();
      foreach ($this->arrDomaineScientifique as $domaineSc) {
        $requeteDossiersTemp = Doctrine_Core::getTable($this->strModelContenant)->retrieveDossierPropositionByDomaineScientifiqueId($domaineSc->getId(), $objCommission->getDateTimeObject('date_debut')->format('Y'),$objCommission->getDateTimeObject('date_debut')->format('Y-m-d'));
        //on remplit le tableau de pager
        $objPager = $this->processPager($requeteDossiersTemp, $this->strModelContenant, true, $domaineSc->getId());
        if($objPager->count() != 0){
          $this->checkListeNonVide = true;
        }
        $arrPager[$domaineSc->getId()] = $objPager;
      }
      
    } else if ($this->request->hasParameter('EnCours')) {
      $this->checkBonnePage = 'EnCours';

      $this->checkTypeDossier();

      foreach ($this->arrDomaineScientifique as $domaineSc) {
        $requeteDossiersTemp = Doctrine_Core::getTable($this->strModelContenant)->retrieveDossierValideByDomaineScientifiqueId($domaineSc->getId(), $objCommission->getDateTimeObject('date_debut')->format('Y'));
        //on remplit le tableau de pager
        $objPager = $this->processPager($requeteDossiersTemp, $this->strModelContenant, true, $domaineSc->getId());
        if($objPager->count() != 0){
          $this->checkListeNonVide = true;
        }
        $arrPager[$domaineSc->getId()] = $objPager;
      }

    }
    $this->arrPager = $arrPager;
  }

  protected function checkTypeDossier() {

    //si c'est un dossier de thèse
    if ($this->objCommission->getTypeDossierMrisId() == 1) {
      $this->strModelContenant = 'Dossier_these';
    }

    //si c'est un dossier postdoc
    if ($this->objCommission->getTypeDossierMrisId() == 2) {
      $this->strModelContenant = 'Dossier_postdoc';
    }

    //si c'est un dossier ERE
    if ($this->objCommission->getTypeDossierMrisId() == 3) {
      $this->strModelContenant = 'Dossier_ere';
    }
  }

}
?>
