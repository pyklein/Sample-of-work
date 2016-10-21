<?php
/**
 * Description of modifierContentieuxAvecTiersAction
 *
 * @author Antonin KALK
 */
class modifierContentieuxAvecTiersAction extends gridAction
{
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

        $this->objForm = new ContentieuxPrincipal_avec_tiers($this->dossierBpi);

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

          //POST du formulaire
          if($request->isMethod('post')){
             if($this->processForm('creer', '', false)){
              $this->getUser()->setFlash('succes', libelle('msg_libelle_contentieux_ajout_succes'));
             }
          }
        }else {
          $this->getUser()->setFlash('warning', libelle('msg_libelle_recompenses_aucun_inventeur_warning'));
          $this->redirect('dossier_bpi/listerDossier_bpis');
        }
      } else {
        $this->getUser()->setFlash('warning', libelle('msg_credentials_acces_non_autorise'));
        $this->redirect('dossier_bpi/listerDossier_bpis');
        }
      }
} ?>

