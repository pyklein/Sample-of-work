<?php

/**
 * Modification des récompenses
 *
 * @author Alexandre WETTA
 */
class modifierRecompensesAction extends gridAction {

  public function preExecute() {
    //on verifie si il y a un id du dossier BPI sinon on redirige
    if ($this->getRequest()->hasParameter('dossier_bpi_id')) {
      $this->dossierId = $this->getRequestParameter('dossier_bpi_id');
    } else {
      $this->getUser()->setFlash('warning', libelle('msg_credentials_acces_non_autorise'));
      $this->redirect('dossier_bpi/listerDossier_bpis');
    }

    //on regarde s'il y a un inventeur ID 
    if ($this->getRequest()->hasParameter('inventeur_id')) {
      $this->checkInventeur = $this->getRequest()->getParameter('inventeur_id');
    } else {
      $this->checkInventeur = null;
    }
  }

  public function execute($request) {

    //on cherche le dossier BPI
    $this->dossierBpi = Dossier_bpiTable::getInstance()->findOneById($this->dossierId);

    if ($this->dossierBpi) {

      //on retrouve les parts inventives du dossier BPI
      $arrPartInventive = Part_inventiveTable::getInstance()->findByDossierBpiId($this->dossierId);

      if (count($arrPartInventive) != 0) {

        //on recherche les inventeurs par rapport aux parts inventives
        $arrInventeurs = array();
        foreach ($arrPartInventive as $objPartInventive) {
          $objInventeur = InventeurTable::getInstance()->findOneById($objPartInventive->getInventeurId());
          $arrInventeurs[] = $objInventeur;
          if ($this->checkInventeur == null) {
            $this->checkInventeur = $objInventeur->getId();
          }
        }
        $this->arrInventeurs = $arrInventeurs;

        //part Inventive concernée
        $arrPartInventiveCourante = Part_inventiveTable::getInstance()->retrievePartInventiveByDossierAndInventeur($this->checkInventeur, $this->dossierId);
        $objPartInventiveCourante = $arrPartInventiveCourante[0];
        $this->objPartInventiveId = $objPartInventiveCourante->getId() ;
        //on cherche la récompense
        $objRecompense = RecompensesTable::getInstance()->findOneByPartInventiveId($this->objPartInventiveId);
        if ($objRecompense == null) {
          $objRecompense = new Recompenses();
          $objRecompense->setPartInventiveId($this->objPartInventiveId);
        }
        $this->objForm = new RecompensesForm($this->objPartInventiveId, $objRecompense);


        //Exploitation Externe
        $objExpExt = new Exploitation_externe();
        $objExpExt->setPartInventiveId($this->objPartInventiveId);

        $this->objExpExtForm = new Exploitation_externeForm($this->dossierId, $objPartInventiveCourante, $objExpExt);

        //recherche des Exploitations externes déjà existantes (pour l'affichage)
        $this->arrExpExterne = Exploitation_externeTable::getInstance()->retrieveExploitationExterneByPartInventive($this->objPartInventiveId);

        //recherche de contentieux
        $arrContentieux = ContentieuxTable::getInstance()->findByPartInventiveId($this->objPartInventiveId);
        $this->boolContentieuxExiste = false;
        //on check s'il y a des contentieux de type Exploitation externe
        if(count($arrContentieux)!= 0){
          foreach($arrContentieux as $objContentieux){
            if($objContentieux->getTypeContentieuxId() == Type_contentieuxTable::EXPLOITATION_INTERNE && $objContentieux->getEstDesaccord() ){
              $this->boolContentieuxExiste = true;
            }
          }
        }


        //**************REGLES******************
        $this->boolBrevetDepose = false;
        $this->boolExterneEffective = false;
        $this->boolInterneEffective = false;

         //**************check Non suppression des redevances en double******************
        $arrExpExterneNonSuppr = array();
        $arrTempId = array();
        foreach ($this->arrExpExterne as $objExpExt){
          //si la clé existe, la redevance est en double
          if(array_key_exists($objExpExt->getRedevanceId(), $arrTempId)){
            $arrExpExterneNonSuppr[$objExpExt->getRedevanceId()] = $objExpExt->getRedevanceId();
          }
          $arrTempId[$objExpExt->getRedevanceId()] = $objExpExt->getRedevanceId();
        }
        
        $this->arrExpExterneNonSuppr = $arrExpExterneNonSuppr ;
        
        //**************check Exploitation Externe effective******************
        //recherche de l'exploitation BPI
        $objExploitationBpi = Exploitation_bpiTable::getInstance()->findOneByDossierBpiId($this->dossierId);
        if ($objExploitationBpi) {
          if ($objExploitationBpi->getNatureExterneId() == Nature_exploitationTable::EFFECTIVE) {
            $this->boolExterneEffective = true;
          }
        }
        
        //**************check brevet déposé******************
        //Si le dossier est brevetable
        if ($this->dossierBpi->getEstBrevetable()) {
          //recherche du brevet
          $attributionDroit = Attribution_droitTable::getInstance()->findOneByDossierBpiId($this->dossierId);
          //si l'attribution des droits est correcte
          if($attributionDroit){
            if ($attributionDroit->getRedactionBrevetLance()
                    && $attributionDroit->getBrevetId() != null
                    && $attributionDroit->getBrevet()->getDateObtention() != null) {
              $this->boolBrevetDepose = true;
            }
          }
        }

        //**************check Exploitation Interne effective******************
         if ($objExploitationBpi) {
          if ($objExploitationBpi->getNatureInterneId() == Nature_exploitationTable::EFFECTIVE) {
            $this->boolInterneEffective = true;
          }
        }

        $this->boolContentieuxExist = Dossier_bpiTable::getInstance()->hasDossierContentieux($this->dossierId);
        
        //POST d'un des formulaire
        if ($request->isMethod('post')) {
          if ($request->hasParameter('bouton_recompenses')) {
            $this->processForm('creer', '', false);
          } else if ($request->hasParameter('bouton_exploitation')) {
            $this->processForm('creer', 'modifierRecompenses?dossier_bpi_id=' . $this->dossierId . '&inventeur_id=' . $this->checkInventeur, true, true, $this->objExpExtForm);
          }
        }
      } else {
        $this->getUser()->setFlash('warning', libelle('msg_libelle_recompenses_aucun_inventeur_warning'));
        $this->redirect('dossier_bpi/listerDossier_bpis');
      }
    } else {
      $this->getUser()->setFlash('warning', libelle('msg_credentials_acces_non_autorise'));
      $this->redirect('dossier_bpi/listerDossier_bpis');
    }
  }

}
?>
