<?php

/**
 * Description of modifierPoint_contactAction
 *
 * @author William
 */
class modifierPoint_contactAction extends gridAction {

  public function preExecute() {
    if (!$this->getRequest()->hasParameter('id')) {
      $this->redirect("@non_autorise");
    }
  }

  public function execute($objRequeteWeb) {
    $objPointDeContact = Point_contactTable::getInstance()->findOneById($objRequeteWeb->getParameter('id'));
    if(!$objPointDeContact){
      $this->redirect('@non_autorise');
    }

    if ($objPointDeContact->getOrganismeId() != null)
    {
      $this->strContenant = 'organisme';
      $this->idContenant  = $objPointDeContact->getOrganismeId();
    } else if ($objPointDeContact->getLaboratoireId() != null)
    {
      $this->strContenant = 'laboratoire';
      $this->idContenant  = $objPointDeContact->getLaboratoireId();
    } else if ($objPointDeContact->getServiceId() != null)
    {
      $this->strContenant = 'service';
      $this->idContenant  = $objPointDeContact->getServiceId();
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

      $this->processForm('modifier', 'listerPoint_contacts?'.$this->strContenant.'='.$this->idContenant);
    }
  }

}

?>
