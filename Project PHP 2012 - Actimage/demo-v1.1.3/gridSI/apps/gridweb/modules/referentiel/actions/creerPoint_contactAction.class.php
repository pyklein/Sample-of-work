<?php

/**
 * Description of creerPoint_de_contactAction
 *
 * @author William
 */
class creerPoint_contactAction extends gridAction {

  public function execute($objRequeteWeb) {
    $objPointDeContact = new Point_contact();
    $objMetier = $this->getUser()->getUtilisateur()->getProfil()->getMetier();
    $objPointDeContact->setMetier($objMetier);
    $boolDejaExistant = false;

    if ($objRequeteWeb->hasParameter('organisme')) {
      $this->idContenant = $objRequeteWeb->getParameter('organisme');
      $this->strContenant = 'organisme';
      $objOrganisme = OrganismeTable::getInstance()->findOneById($this->idContenant);
      if (!$objOrganisme || !$objOrganisme->getEstActif()) {
        $this->redirect('@non_autorise');
      }
      $objPointDeContact->setOrganisme($objOrganisme);
      if (Point_contactTable::getInstance()->retrieveByOrganismeIdAndMetierId($objRequeteWeb->getParameter('organisme'), $objMetier->getId())->execute()->count() > 0) {
        $boolDejaExistant = true;
      }
    } elseif ($objRequeteWeb->hasParameter('service')) {
      $this->idContenant = $objRequeteWeb->getParameter('service');
      $this->strContenant = 'service';
      $objService = ServiceTable::getInstance()->findOneById($this->idContenant);
      if (!$objService || !$objService->getEstActif()) {
        $this->redirect('@non_autorise');
      }
      $objPointDeContact->setService($objService);
      if (Point_contactTable::getInstance()->retrieveByServiceIdAndMetierId($objRequeteWeb->getParameter('service'), $objMetier->getId())->execute()->count() > 0) {
        $boolDejaExistant = true;
      }
    } elseif ($objRequeteWeb->hasParameter('laboratoire')) {
      $this->idContenant = $objRequeteWeb->getParameter('laboratoire');
      $this->strContenant = 'laboratoire';
      $objLaboratoire = LaboratoireTable::getInstance()->findOneById($this->idContenant);
      if (!$objLaboratoire || !$objLaboratoire->getEstActifRecursif()){
        $this->redirect('@non_autorise');
      }
      $objPointDeContact->setLaboratoire($objLaboratoire);
      if (Point_contactTable::getInstance()->retrieveByLaboratoireIdAndMetierId($objRequeteWeb->getParameter('laboratoire'), $objMetier->getId())->execute()->count() > 0) {
        $boolDejaExistant = true;
      }
    } else {
      $this->redirect('@non_autorise');
    }

    if ($boolDejaExistant) {
      $this->getUser()->setFlash('warning', libelle('msg_point_contact_deja_existant_' . strtolower($this->strContenant), array($objMetier)));
      $this->redirect("referentiel/listerOrganismes");
    }

    $this->objForm = new Point_contactForm($objPointDeContact);
    
    // on recharge le formulaire avec les villes (version sans Javascript)
    if ($objRequeteWeb->isMethod('post') && $objRequeteWeb->hasParameter("chargerVilles"))
    {
      $this->objForm->bind($objRequeteWeb->getParameter($this->objForm->getName()));
    }

    // submit de formulaire
    else if ($objRequeteWeb->isMethod('post'))
    {
      $arrValeursPost = $this->getRequest()->getParameter($this->objForm->getName());

      //Si un bout d'adresse français a été renseigné
      if ((strlen($arrValeursPost['adresse']) > 0)            ||
          (strlen($arrValeursPost['code_postal']) > 0)        ||
          (strlen($arrValeursPost['complement_adresse']) > 0) ||
          (strlen($arrValeursPost['ville_id']) > 0)
         )
      {
        //Si un bout d'adresse etrangere a été renseigné
        if ((strlen($arrValeursPost['adresse_etrangere']) > 0)||
            (strlen($arrValeursPost['pays_id']) > 0)
           )
        {
          //On efface les valeurs posté du request
          //$this->getRequest()->offsetUnset($this->objForm->getName());

          //On efface les informations fournies
          //$arrValeursPost['adresse_etrangere']  = "";
          //$arrValeursPost['pays_id']            = "";

          //On remet les valeurs posté dans le request
          $this->getRequest()->setParameter($this->objForm->getName(), $arrValeursPost);

          //On notifie que l'adresse etranger ne sera pa pris en compte
          //$this->getUser()->setFlash('warning', libelle('msg_form_warning_adresse_etrangere'));
        }
      }

      $this->processForm('creer', 'listerPoint_contacts?'.$this->strContenant.'='.$this->idContenant);
    }
  }

}

?>
