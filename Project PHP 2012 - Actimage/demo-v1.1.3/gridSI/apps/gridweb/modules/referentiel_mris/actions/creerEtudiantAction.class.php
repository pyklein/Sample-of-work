<?php
sfContext::getInstance()->getConfiguration()->loadHelpers("Libelle");
/**
 * Ajouter un étudiant

 * @author     Jihad Sahebdin
 */
class creerEtudiantAction extends gridAction
{
  public function  preExecute()
  {
  }

  public function execute($request)
  {   
    $objEtudiant = new Etudiant();
    

    $this->objForm = new EtudiantForm($objEtudiant);
    
    // on recharge le formulaire avec les villes (version sans Javascript)
    if ($request->isMethod('post') && $request->hasParameter("chargerVilles"))
    {
      $this->objForm->bind($request->getParameter($this->objForm->getName()), $request->getFiles($this->objForm->getName()));
    }

    // submit de formulaire
    else if($request->isMethod('post'))
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

      $this->processForm('creer');
    }
  }

  public function  postExecute()
  {
  }
  
}
