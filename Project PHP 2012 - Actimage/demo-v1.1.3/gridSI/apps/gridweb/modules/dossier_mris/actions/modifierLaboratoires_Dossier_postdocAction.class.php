<?php

/**
 * Description of modifierLaboratoires_Dossier_postdocAction
 *
 * @author Simeon Petev
 */
class modifierLaboratoires_Dossier_postdocAction extends gridAction
{
  public function  preExecute()
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    $idDossier = $this->getRequest()->getParameter('dossier_postdoc_id');

    $this->objDossier = Dossier_postdocTable::getInstance()->findOneById(($idDossier) ? $idDossier : 0);

    if (($this->objDossier == null) || ($this->objDossier->getId()==0))
    {
      if ($idDossier != null)
      {
        $this->getUser()->setFlash("erreur", libelle('msg_dossier_postdoc_droit_laboratoires'));
      }

      $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN AVANT REDIRECTION; ");

      $this->redirect(url_for('dossier_mris/listerDossier_postdocs'));
    }

    parent::preExecute();

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }

  public function  execute($request)
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    $srvToken = new ServiceToken();
    $strToken = '';
    $this->boolReinitialiser = true;

    $this->objFiltreLaboratoires = new LaboratoireFormFilter();
    $this->objPointContactLaboratoireForm = new PointContactLaboratoireForm();

    if (!$srvToken->hasToken('modifier_laboratoires_dossier_postdoc'))
    {
      $strToken = $srvToken->creerToken('modifier_laboratoires_dossier_postdoc', $this->objDossier->getId());
    } else
    {
      $strToken = $srvToken->getToken('modifier_laboratoires_dossier_postdoc');
    }

    $objQueryLaboratoiresDispo = array();

    if ($request->isMethod('get'))
    {
      if ($request->hasParameter('laboratoire_associe'))
      {
        $this->retirerLaboratoire($request->getParameter('laboratoire_associe'),$strToken);
      } else if ($request->hasParameter('start'))
      {
        $this->arrLaboratoiresAssocies = $this->getLaboratoiresAssocies($strToken,true);
        $this->getUser()->setAttribute('filtre_labo_dossier_postdoc', array('organisme_id'=>"","service_id"=>""));
      }

      if (!$this->getUser()->hasAttribute('filtre_labo_dossier_postdoc'))
      {
        $this->getUser()->setAttribute('filtre_labo_dossier_postdoc', array('organisme_id'=>"","service_id"=>""));
      }
    }

    // on recharge le formulaire avec les villes (version sans Javascript)
    else if ($request->isMethod('post') && $request->hasParameter("chargerVilles"))
    {
      $this->objPointContactLaboratoireForm->bind($request->getParameter($this->objPointContactLaboratoireForm->getName()));
    }

    // submit de formulaire
    else
    {
      if ($request->hasParameter('enregistrer'))
      {
        $this->enregistrer($strToken);
      } else if ($request->hasParameter($this->objFiltreLaboratoires->getName()))
      {
        $this->getUser()->offsetUnset('filtre_labo_dossier_postdoc');

        if ($request->hasParameter('labo_filtre_submit'))
        {
          $this->getUser()->setAttribute('filtre_labo_dossier_postdoc', $request->getParameter($this->objFiltreLaboratoires->getName()));
        } else
        {
          $this->getUser()->setAttribute('filtre_labo_dossier_postdoc', array('organisme_id'=>"","service_id"=>""));
        }
      }
      else if ($request->hasParameter('laboratoire_disponible'))
      {
        $arrLabAjouter = $request->getParameter('laboratoire_disponible');

        foreach ($arrLabAjouter as $key => $value)
        {
          if (!$this->ajouterLaboratoireDispo($key,$strToken))
          {
            $objLaboratoire = LaboratoireTable::getInstance()->findOneById($key);

            $this->getUser()->setFlash("erreur", libelle('msg_dossier_mris_err_doublons_labo',array($objLaboratoire->getIntitule())));
          }
          break;
        }
      } else if ($request->hasParameter('ajout_nouveau_laboratoire'))
      {
        $this->processLaboratoireForm();
      }
    }

    $this->objFiltreLaboratoires->bind($this->getUser()->getAttribute('filtre_labo_dossier_postdoc'));

    $this->arrLaboratoiresAssocies = $this->getLaboratoiresAssocies($strToken);
    $this->intNombreResLaboratoiresAssocies = count($this->arrLaboratoiresAssocies);

    $objQueryLaboratoiresDispo = LaboratoireTable::getInstance()->buildQueryLaboratoiresDisponiblesAvecFiltreSauf($this->objFiltreLaboratoires, Session_dossier_postdoc_laboratoireTable::getInstance()->getIdsLaboratoiresAssocies($strToken,$this->objDossier->getId()));

    $this->objPager1 = $this->processPager($objQueryLaboratoiresDispo, 'Laboratoire',true,1);

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }

  public function  postExecute()
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    parent::postExecute();

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }

  /**
   * Recupere les laboratoires associés à un dossier de la session s'il existe, ou
   * par le dossier directement sinon
   *
   * @param boolean $boolABlank force la recharge des laboratoires depuis le dossier
   * @return Doctrine_Collection Liste des laboratoires
   *
   * @author Simeon PETEV
   */
  private function getLaboratoiresAssocies($strToken,$boolABlank=false)
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    $arrLaboratoiresTmp = Session_dossier_postdoc_laboratoireTable::getInstance()->getQueryObject()->where('transaction_token = ?',$strToken)->execute();

    if ($boolABlank)
    {
      //Efface des valeurs eventuelles
      try {
        Session_dossier_postdoc_laboratoireTable::getInstance()->getQueryObject()->where('transaction_token = ?',$strToken)->delete()->execute();
      } catch (Exception $exc) {
        $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ Effacemment des enrés de la table de session avec token ".$strToken."; ");
        $this->getUser()->setFlash("warning", libelle('msg_system_warning'));
      }

      //Start transaction
      Doctrine_Manager::getInstance()->getCurrentConnection()->beginTransaction();

      try {
        //On recharge les originaux
        foreach ($this->objDossier->getLaboratoires() as $objLaboratoire)
        {
          $objLaboratoireTmp = new Session_dossier_postdoc_laboratoire();

          $objLaboratoireTmp->setDossierPostdoc($this->objDossier);
          $objLaboratoireTmp->setLaboratoire($objLaboratoire);
          $objLaboratoireTmp->setTransactionToken($strToken);

          $objLaboratoireTmp->save();
        }
        
        //Commit transaction
        Doctrine_Manager::getInstance()->getCurrentConnection()->commit();
      } catch (Exception $exc) {
        $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ Erreur de remplissage de la table de session - token".$strToken."; ");
        $this->getUser()->setFlash("warning", libelle('msg_system_warning'));
        Doctrine_Manager::getInstance()->getCurrentConnection()->rollback();
      }
    }

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");

    return $arrLaboratoiresTmp;
  }

  /**
   * Essay de rajouter des une laboratoire dans la liste
   * temporaire sessionnaire des laboratoires associés au dossier
   *
   * @param integer $intIdLaboratoire L'id de laboratoire
   * @param string $strToken Le tocken de transaction
   * @return boolean True si l'ajout reussi (si pas de doublon), false sinon
   *
   * @author Simeon PETEV
   */
  private function ajouterLaboratoireDispo($intIdLaboratoire,$strToken)
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    $objLaboratoire = new Session_dossier_postdoc_laboratoire();

    $objLaboratoire->setDossierPostdoc($this->objDossier);
    $objLaboratoire->setLaboratoire(LaboratoireTable::getInstance()->findOneById($intIdLaboratoire));
    $objLaboratoire->setTransactionToken($strToken);

    $arrListeLaboratoiresTemp = Session_dossier_postdoc_laboratoireTable::getInstance()->getQueryObject()->where('transaction_token = ?',$strToken)->execute();

    foreach ($arrListeLaboratoiresTemp as $objLaboratoireAct)
    {
      if ($objLaboratoire->getLaboratoireId() == $objLaboratoireAct->getLaboratoireId())
      {
        $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
        return false;
      }
    }

    //Start transaction
    Doctrine_Manager::getInstance()->getCurrentConnection()->beginTransaction();

    try {
      $objLaboratoire->save();
      
      //Commit transaction
      Doctrine_Manager::getInstance()->getCurrentConnection()->commit();
    } catch (Exception $exc) {
      $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ Erreur de sauveguarde de laboratoire en session - token".$strToken."; ");
      $this->getUser()->setFlash("warning", libelle('msg_system_warning'));
      Doctrine_Manager::getInstance()->getCurrentConnection()->rollback();
    }

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");

    return true;
  }

  /**
   * Retire la laboratoire de la table transitoire
   *
   * @param integer $intArrayOffset La position de la laboratoire dans l'array affiché
   * @param string $strToken Le token de transaction
   *
   * @author Simeon PETEV
   */
  private function retirerLaboratoire($intArrayOffset,$strToken)
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    //Start transaction
    Doctrine_Manager::getInstance()->getCurrentConnection()->beginTransaction();

    try {
      //Efface l'objet de la table de session
      Session_dossier_postdoc_laboratoireTable::getInstance()->getQueryObject()->where('id = ?',$intArrayOffset)->andWhere('transaction_token = ?',$strToken)->delete()->execute();

      //Commit transaction
      Doctrine_Manager::getInstance()->getCurrentConnection()->commit();
    } catch (Exception $exc) {
      $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ Erreur d'effacement de laboratoire de session - token".$strToken."; ");
      $this->getUser()->setFlash("warning", libelle('msg_system_warning'));
      Doctrine_Manager::getInstance()->getCurrentConnection()->rollback();
    }

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }

  /**
   * Sauveguarde la liste des laboratoires
   *
   * @author Simeon PETEV
   */
  private function enregistrer($strToken)
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    //Start transaction
    Doctrine_Manager::getInstance()->getCurrentConnection()->beginTransaction();

    try {
      $arrLabos = LaboratoireTable::getInstance()->retreveLaboratoiresAvecIds(Session_dossier_postdoc_laboratoireTable::getInstance()->getIdsLaboratoiresAssocies($strToken,$this->objDossier->getId()));

      $objDoctColl = new Doctrine_Collection('Laboratoire');

      foreach ($this->objDossier->getLaboratoires() as $key => $value)
      {
        $this->objDossier->getLaboratoires()->remove($key);
      }

      foreach ($arrLabos as $objLabo)
      {
        $this->objDossier->getLaboratoires()->add($objLabo);
      }

      $this->objDossier->save();
      
      //Fin transaction
      Doctrine_Manager::getInstance()->getCurrentConnection()->commit();

      $this->getUser()->setFlash("succes", libelle('msg_dossier_mris_enregistrer_laboratoires_succes'));
    } catch (Exception $exc) {
      $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ Erreur sauveguarde laboratoires du dossier; ");
      $this->getUser()->setFlash("erreur", libelle('msg_dossier_mris_enregistrer_laboratoires_erreur'));
      Doctrine_Manager::getInstance()->getCurrentConnection()->rollback();
    }

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }

  /**
   * Sauveguarde la nouvelle laboratoire
   *
   * @author Simeon PETEV
   */
  private function processLaboratoireForm()
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");
    
    $objMetierMris = null;

    $objMetierMris = MetierTable::getInstance()->findOneByIntitule(MetierTable::MRIS);

    $objPointC = new Point_contact();
    $objPointC->setMetier($objMetierMris);

    $this->objPointContactLaboratoireForm = new PointContactLaboratoireForm($objPointC);
    $this->objForm = $this->objPointContactLaboratoireForm;

    $arrValeursPost = $this->getRequest()->getParameter($this->objPointContactLaboratoireForm->getName());

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

    if ($this->processForm('ajouter_nouveau_laboratoire', "", false))
    {
      $this->getRequest()->setParameter('laboratoire_disponible', array($this->objForm->getObject()->getLaboratoire()->getId() => 'Ajouter'));
      $this->getRequest()->setMethod('post');
      $this->execute($this->getRequest());
    } else
    {
      $this->objPointContactLaboratoireForm = $this->objForm;
    }

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }
}
?>
