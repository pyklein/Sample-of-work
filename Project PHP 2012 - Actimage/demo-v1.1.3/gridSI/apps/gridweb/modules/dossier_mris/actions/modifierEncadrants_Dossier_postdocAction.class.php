<?php

/**
 * Description of modifierEncadrants_Dossier_postdocAction
 *
 * @author Simeon Petev
 */
class modifierEncadrants_Dossier_postdocAction extends gridAction
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
        $this->getUser()->setFlash("erreur", libelle('msg_dossier_postdoc_droit_encadrants'));
      }

      $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN AVANT REDIRECTION; ");

      $this->redirect(url_for('dossier_mris/listerDossier_postdoc'));
    }

    parent::preExecute();

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }

  public function  execute($request)
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    $srvToken = new ServiceToken();
    $objTabSessionEncadrants = null;
    $strToken = '';
    
    $this->objFormEncadrantDossierPostdoc = new Encadrant_postdocForm();

    $objQueryEncadrantsDispo = IntervenantTable::getInstance()->buildQueryIntervenantsActifsResponsablesOrdreAscNomPrenom();
    $this->arrEncadrantsDispo = $objQueryEncadrantsDispo->execute();
    $this->intNombreResEncadrants = $objQueryEncadrantsDispo->count();
    $this->objFormAjoutIntervenant = $this->getFormNouveauIntervenant();

    if (!$srvToken->hasToken('modifier_encadrants_dossier_postdoc'))
    {
      $strToken = $srvToken->creerToken('modifier_encadrants_dossier_postdoc', $this->objDossier->getId());
    } else
    {
      $strToken = $srvToken->getToken('modifier_encadrants_dossier_postdoc');
    }
    
    if ($request->isMethod('get'))
    {
      if ($request->hasParameter('responsable_associe'))
      {
        $this->retirerResponsable($request->getParameter('responsable_associe'),$strToken);
      } else if ($request->hasParameter('start'))
      {
        $this->arrEncadrantsAssocies = $this->getResponsablesAssocies($strToken,true);
      }
    }

    // on recharge le formulaire avec les villes (version sans Javascript)
    if ($request->isMethod('post') && $request->hasParameter("chargerVilles"))
    {
      $this->objFormAjoutIntervenant->bind($request->getParameter($this->objFormAjoutIntervenant->getName()), $request->getFiles($this->objFormAjoutIntervenant->getName()));
    }

    // submit de formulaire
    else
    {
      if ($request->hasParameter('enregistrer'))
      {
        $this->enregistrer($strToken);
      }
      else if ($request->hasParameter('encadrant_disponible'))
      {
        $arrEncAjouter = $request->getParameter('encadrant_disponible');
        $arrValeursForm = $request->getParameter($this->objFormEncadrantDossierPostdoc->getName());

        foreach ($arrEncAjouter as $key => $value)
        {
          if (!$this->ajouterResponsableDispo($key,$arrValeursForm['role_postdoc_id'],$strToken))
          {
            $objEncadrant = IntervenantTable::getInstance()->findOneById($key);
            $objRole = Role_postdocTable::getInstance()->findOneById($arrValeursForm['role_postdoc_id']);

            $this->getUser()->setFlash("erreur", libelle('msg_dossier_mris_err_doublons',array($objEncadrant->getPrenom()." ".$objEncadrant->getNom(),$objRole->getIntitule())));
          }
          break;
        }
      } else if ($request->hasParameter('ajout_nouveau_intervenant'))
      {
        $this->processIntervenantForm();
      }
    }

    $this->arrEncadrantsAssocies = $this->getResponsablesAssocies($strToken);
    $this->intNombreResEncadrantsAssocies = count($this->arrEncadrantsAssocies);

    $this->objPager1 = $this->processPager($objQueryEncadrantsDispo, 'Intervenant',true,1);

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }

  public function  postExecute()
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    parent::postExecute();

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }

  /**
   * Recupere les responsable associés à un dossier de la session s'il existe, ou
   * par le dossier directement sinon
   *
   * @param boolean $boolABlank force la recharge des responsable depuis le dossier
   * @return Doctrine_Collection Liste des responsables
   *
   * @author Simeon PETEV
   */
  private function getResponsablesAssocies($strToken,$boolABlank=false)
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");
    
    $arrEncadrantsTmp = Session_encadrants_dossier_postdocTable::getInstance()->getQueryObject()->where('transaction_token = ?',$strToken)->execute();

    if ($boolABlank)
    {
      //Efface des valeurs eventuelles
      try {
        Session_encadrants_dossier_postdocTable::getInstance()->getQueryObject()->where('transaction_token = ?',$strToken)->delete()->execute();
      } catch (Exception $exc) {
        $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ Effacemment des enrés de la table de session avec token ".$strToken."; ");
        $this->getUser()->setFlash("warning", libelle('msg_system_warning'));
      }

      //On recharge les originaux
      foreach ($this->objDossier->getEncadrant_postdoc() as $objEncadrant)
      {
        $objEncadrantTmp = new Session_encadrants_dossier_postdoc();

        $objEncadrantTmp->setDossierPostdoc($objEncadrant->getDossier_postdoc());
        $objEncadrantTmp->setIntervenant($objEncadrant->getIntervenant());
        $objEncadrantTmp->setRolePostdoc($objEncadrant->getRole_postdoc());
        $objEncadrantTmp->setTransactionToken($strToken);

        try {
          $objEncadrantTmp->save();
        } catch (Exception $exc) {
          $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ Erreur de remplissage de la table de session - token".$strToken."; ");
          $this->getUser()->setFlash("warning", libelle('msg_system_warning'));
        }
      }
    }

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
    
    return $arrEncadrantsTmp;
  }

  /**
   * Essay de rajouter des un responsable avec un role donnée dans la liste
   * temporaire sessionnaire des responsables associés au dossier
   *
   * @param integer $intIdIntervenant
   * @param integer $intRolePostdocId
   * @return boolean True si l'ajout reussi (si pas de doublon), false sinon
   *
   * @author Simeon PETEV
   */
  private function ajouterResponsableDispo($intIdIntervenant,$intRolePostdocId,$strToken)
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");
    
    $objEncadrant = new Session_encadrants_dossier_postdoc();

    $objEncadrant->setDossierPostdoc($this->objDossier);
    $objEncadrant->setIntervenant(IntervenantTable::getInstance()->findOneById($intIdIntervenant));
    $objEncadrant->setRolePostdoc(Role_postdocTable::getInstance()->findOneById($intRolePostdocId));
    $objEncadrant->setTransactionToken($strToken);

    $arrListeEncadrantTemp = Session_encadrants_dossier_postdocTable::getInstance()->getQueryObject()->where('transaction_token = ?',$strToken)->execute();

    foreach ($arrListeEncadrantTemp as $objEncadrantAct)
    {
      if (($objEncadrant->getDossierPostdocId() == $objEncadrantAct->getDossierPostdocId()) &&
          ($objEncadrant->getIntervenantId() == $objEncadrantAct->getIntervenantId()) &&
          ($objEncadrant->getRolePostdocId() == $objEncadrantAct->getRolePostdocId()))
      {
        $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
        return false;
      }
    }

    try {
      $objEncadrant->save();
    } catch (Exception $exc) {
      $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ Erreur de sauveguarde d'encadrant en session - token".$strToken."; ");
      $this->getUser()->setFlash("warning", libelle('msg_system_warning'));
    }

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
    
    return true;
  }
  
  /**
   * Retire le responsable de la table transitoire
   *
   * @param integer $intArrayOffset La position du l'ncadrant dans l'array affiché
   * @param string $strToken Le token de transaction
   *
   * @author Simeon PETEV
   */
  private function retirerResponsable($intArrayOffset,$strToken)
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    //Efface l'objet de la table de session
    try {
      Session_encadrants_dossier_postdocTable::getInstance()->getQueryObject()->where('id = ?',$intArrayOffset)->andWhere('transaction_token = ?',$strToken)->delete()->execute();
    } catch (Exception $exc) {
      $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ Erreur d'effacement d'encadrant de session - token".$strToken."; ");
      $this->getUser()->setFlash("warning", libelle('msg_system_warning'));
    }

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }

  /**
   * Sauveguarde la liste des encadrants
   *
   * @author Simeon PETEV
   */
  private function enregistrer($strToken)
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");
    
    //Start transaction
    Doctrine_Manager::getInstance()->getCurrentConnection()->beginTransaction();

    $arrEncadrants = $this->objDossier->getEncadrant_postdoc();

    foreach ($arrEncadrants as $clef => $objEncadrant)
    {
      $this->objDossier->getEncadrant_postdoc()->remove($clef);
    }

    $arrEncadrantsTemporaires = Session_encadrants_dossier_postdocTable::getInstance()->getQueryObject()->where('transaction_token = ?',$strToken)->execute();

    //On enregistre les nouveau
    foreach ($arrEncadrantsTemporaires as $objEncadrantTmp)
    {
      $objNouveauEncadrant = new Encadrant_postdoc();
      $objNouveauEncadrant->setDossier_postdoc($objEncadrantTmp->getDossierPostdoc());
      $objNouveauEncadrant->setIntervenant($objEncadrantTmp->getIntervenant());
      $objNouveauEncadrant->setRole_postdoc($objEncadrantTmp->getRolePostdoc());

      $this->objDossier->getEncadrant_postdoc()->add($objNouveauEncadrant);
    }

    try {
      $this->objDossier->save();
      $this->getUser()->setFlash("succes", libelle('msg_dossier_mris_enregistrer_encadrants_succes'));

      //Fin transaction
      Doctrine_Manager::getInstance()->getCurrentConnection()->commit();
    } catch (Exception $exc) {
      Doctrine_Manager::getInstance()->getCurrentConnection()->rollback();
      $this->getUser()->setFlash("erreur", libelle('msg_dossier_mris_enregistrer_encadrants_erreur'));
      $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ Erreur sauveduarde encadrants du dossier; ");
    }

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }

  /**
   * Prepara la forme permettant l'ajout d'in nouveau encadrant à chaud
   *
   * @return IntervenantForm
   *
   * @author Simeon PETEV
   */
  private function getFormNouveauIntervenant()
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");
    
    $objIntervenant = new Intervenant();

    $form = new IntervenantForm($objIntervenant);
    $form->setCocheEtDisabledResposnable();

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");

    return $form;
  }

  /**
   * Sauveguarde le nouveau encadrant
   *
   * @author Simeon PETEV
   */
  private function processIntervenantForm()
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");
    
    $objIntervenant = new Intervenant();

    $this->objForm = new IntervenantForm($objIntervenant);

    $arrTainedValues = $this->getRequest()->getParameter($this->objForm->getName());
    $arrTainedValues['est_responsable'] = true;
    $this->getRequest()->offsetUnset($this->objForm->getName());
    $this->getRequest()->setParameter($this->objForm->getName(), $arrTainedValues);

    if ($this->processForm('ajouter_nouveau_intervenant', "", false))
    {
      $this->getRequest()->setParameter('encadrant_disponible', array($this->objForm->getObject()->getId() => 'Ajouter'));
      $this->getRequest()->setMethod('post');
      $this->execute($this->getRequest());
    } else
    {
      $this->objFormAjoutIntervenant = $this->objForm;
    }

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }
}
?>
