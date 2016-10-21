<?php
/**
 * Description of modifierIntervenantAction
 *
 * @author Simeon Petev
 */
class modifierIntervenantAction extends gridAction
{
  public function  preExecute()
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    parent::preExecute();

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }

  public function  execute($request)
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    $objIntervenant = IntervenantTable::getInstance()->getUnAvecId($request->getParameter('id'));

    if (($objIntervenant == null) || (strlen($objIntervenant->getId() == 0)))
    {
      $this->getUser()->setFlash("erreur", libelle("msg_utilisateur_modifier_exist_erreur"));
      $this->redirect(url_for("referentiel_mris/listerIntervenants"));
    }

    $this->objForm = new IntervenantForm($objIntervenant);

    // on recharge le formulaire avec les villes (version sans Javascript)
    if ($request->isMethod('post') && $request->hasParameter("chargerVilles"))
    {
      $this->objForm->bind($request->getParameter($this->objForm->getName()), $request->getFiles($this->objForm->getName()));
    }

    // submit de formulaire
    else if ($request->isMethod('post') || $request->isMethod('put'))
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
      
      $this->processForm('modifier');
    }

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }

  public function  postExecute()
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    parent::postExecute();

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }
}
?>
