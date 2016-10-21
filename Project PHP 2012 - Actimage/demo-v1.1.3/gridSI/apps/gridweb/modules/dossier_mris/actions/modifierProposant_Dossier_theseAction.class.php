<?php

/**
 * Ajout d'un proposant pour un dossier de thèse
 *
 * @author Alexandre WETTA
 */
class modifierProposant_Dossier_theseAction extends gridAction {

  public function execute($request) {

    //verification si il y a dans l'url dossier_these_id
    if (!$request->hasParameter('dossier_these_id')) {
      $this->redirect("@non_autorise");
    }

    $this->strId = $request->getParameter('dossier_these_id');

    $objDossierThese = Dossier_theseTable::getInstance()->findOneById($request->getParameter('dossier_these_id'));
    $this->objDossier = $objDossierThese;
    // si l'id du dossier de thèse n'existe pas, on redirige
    if ($objDossierThese == null) {
      $this->redirect("@non_autorise");
    }


    $this->objDossierForm = new Gestion_proposant_dossier_theseForm($objDossierThese);

    //creation du formulaire pour l'étudiant (seul un super-utilisateur MRIS peut y accéder)
    $arrUserCredentials = $this->getUser()->getCredentials();
    $this->boolIsAdminMris = false;
    if (in_array('SUP-MRIS', $arrUserCredentials)) {
      $this->boolIsAdminMris = true;
      $objProposant = new Etudiant();
      $this->objEtudiantForm = new EtudiantForm($objProposant);
    }

    // on recharge le formulaire avec les villes (version sans Javascript)
    if ($request->isMethod('post') && $request->hasParameter("chargerVilles") && $request->hasParameter('etudiant'))
    {
      $this->objEtudiantForm->bind($request->getParameter($this->objEtudiantForm->getName()), $request->getFiles($this->objEtudiantForm->getName()));
    }

    // submit de formulaire
    else if ($request->isMethod('post')) {

      if ($request->hasParameter('dossier_these')) {
        $this->objForm = $this->objDossierForm;
        $retourForm = $this->processForm('modifier', null, false);
        //si le formulaire est bon, on affiche un message de succès et on redirige 
        if ($retourForm)
          $this->getUser()->setFlash("succes", libelle("msg_dossier_these_modifier_succes", array($objDossierThese->getTitre()), true));
        if ($retourForm)
          $this->redirect(url_for('dossier_mris/modifierProposant_Dossier_these?dossier_these_id=' . $this->strId));
      }else if ($request->hasParameter('etudiant')) {
        $this->objForm = $this->objEtudiantForm;
        $retourForm = $this->processForm('creer', null, false);
        //si le premier formulaire est bon, on met à jour le dossier MRIS
        if ($retourForm) {
          $objDossierThese->setRealisePar($this->getUser()->getAttribute('IdDerniereSauvegarde'));
		  $boolErreur = false;
          try {
            $objDossierThese->save();
          } catch (Exception $ex) {
            $this->getUser()->setFlash("erreur", libelle("msg_dossier_these_modifier_erreur", array($ex->getMessage())));
            $boolErreur = true;
          }
          //si il n'y a pas d'erreur on affiche le message de réussite
          if (!isset($boolErreur) && !$boolErreur) {
            $this->getUser()->setFlash("succes", libelle("msg_dossier_these_modifier_succes", array($objDossierThese->getTitre()), true));
          }
        }
        //on redirige sur la même page le form lorsqu'il est bon pour mettre à jour les données (le selectBox des proposants)
        if ($retourForm)
          $this->redirect(url_for('dossier_mris/modifierProposant_Dossier_these?dossier_these_id=' . $this->strId));
      }
    }
  }

}
?>
