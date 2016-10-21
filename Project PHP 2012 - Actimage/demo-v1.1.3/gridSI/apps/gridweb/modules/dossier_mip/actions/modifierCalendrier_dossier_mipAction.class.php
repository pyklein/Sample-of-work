<?php

sfContext::getInstance()->getConfiguration()->loadHelpers("Libelle");

/**
 * Gestion du calendrier pour un dossier MIP
 *
 * @author Actimage
 */
class modifierCalendrier_dossier_mipAction extends sfAction {

  public function execute($request) {

    //id du dossier MIP
    $this->strId = $request->getParameter('id');

    //on cherche le bon dossier MIP à modifier
    $this->objDossierMip = Dossier_mipTable::getInstance()->findOneById($request->getParameter('id'));

    //si le dossier n'existe pas ou qu'il n'est pas actif, on redirige
    if (!$this->objDossierMip || !$this->objDossierMip->getEstActif()) {
      $this->redirect("@non_autorise");
    }



    // creation du formulaire pour le calendrier
    $this->objForm = new Gestion_calendrierForm($this->objDossierMip);

    if ($request->isMethod('post')) {
      $this->processForm('modifier',$this->strId,false);
    }
  }

  /**
   * Fonction processForm
   *
   * @author Actimage
   */
  public function processForm($strAction, $id = null, $strContenant = null) {
    $objForm = $this->objForm;

    $strNomModel = 'dossier_mip';

    $objForm->bind($this->getRequest()->getParameter('gestion_calendrier'));

    if ($objForm->isValid()) {
      try {

        $objForm->save();
      } catch (Exception $ex) {
        $this->getUser()->setFlash("erreur", libelle("msg_" . strtolower($strNomModel) . "_" . $strAction . "_erreur", array($ex->getMessage())));
      }
      $this->getUser()->setFlash("succes", libelle("msg_gestion_calendrier_creer_succes"));
      $this->redirect($this->getModuleName() . "/modifierCalendrier_dossier_mip" . "?id=" . $id);
    } else {
      $this->getUser()->setFlash("erreur", libelle("msg_gestion_calendrier_creer_invalide"));
    }
  }

}
?>
