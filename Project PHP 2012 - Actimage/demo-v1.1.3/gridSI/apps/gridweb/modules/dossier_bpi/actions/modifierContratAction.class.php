<?php

/**
 * Description of modifierContratAction
 *
 * @author Simeon Petev
 */
class modifierContratAction extends gridAction
{
  public function  preExecute()
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    $idContrat = $this->getRequest()->getParameter('contrat_id');

    $this->objContrat = ContratTable::getInstance()->findOneById(($idContrat) ? $idContrat : 0);

    $this->objDossier = $this->objContrat->getDossier_bpi();

    if (($this->objContrat == null) || ($this->objContrat->getId()==0))
    {
      if ($idDossier != null)
      {
        $this->getUser()->setFlash("erreur", libelle('msg_contrat_droit'));
      }
      $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN AVANT REDIRECTION; ");

      $this->redirect(url_for('dossier_bpi/listerDossier_bpis'));
    }

    parent::preExecute();

    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN; ");
  }

  public function  execute($request)
  {
    $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ DEBUT; ");

    $srvToken = new ServiceToken();
    $objTabSessionSignataires = null;
    $strToken = '';

    if (!$srvToken->hasToken('modifier_contrat_dossier'))
    {
      $strToken = $srvToken->creerToken('modifier_contrat_dossier', $this->objContrat->getId());
    } else
    {
      $strToken = $srvToken->getToken('modifier_contrat_dossier');
    }

    $this->objFormContrat = new ContratForm($this->objContrat);
    $this->objFormSignataire = new Session_contrat_signataireForm();

    if ($request->isMethod('get'))
    {
      //Netoyage de la table de session avan le debut de la modification
      if (!Session_contrat_signataireTable::getInstance()->netoyerSessionParToken($strToken))
      {
        $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ Effacement des entrés avec token ".$strToken." de la table de session; ");
      }

      $arrSignatairesActuels = $this->objContrat->getSignataire();

      //On remlie la table de session
      foreach ($arrSignatairesActuels as $objSignataire)
      {
        $objSessionSignataire = new Session_contrat_signataire();

        $objSessionSignataire->setTransactionToken($strToken);
        $objSessionSignataire->setContratId($this->objContrat->getId());
        $objSessionSignataire->setOrganismeId($objSignataire->getOrganismeId());
        $objSessionSignataire->setServiceId($objSignataire->getServiceId());

        try {
          $objSessionSignataire->save();
        } catch (Exception $exc) {
          $this->getUser()->setFlash('erreur', libelle('msg_contrat_creation_list_session'));
          $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ Erreur remplissage session avec valeurs actuels; ");
        }
      }
    }

    if ($request->isMethod('post'))
    {
      if ($request->hasParameter('ajouter_signataire_submit'))
      {
        $arrValsSublit = $request->getParameter($this->objFormSignataire->getName());
        $arrValsSublit['transaction_token'] = $strToken;

        $this->objFormSignataire->bind($arrValsSublit);

        if ($this->objFormSignataire->isValid())
        {
          try {
            $this->objFormSignataire->save();
          } catch (Exception $exc) {
            $this->getUser()->setFlash('erreur', 'msg_contrat_session_err');
            $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ Erreur sauveguarde signataire en session; ");
          }
        }
      } else if ($request->hasParameter('supprimer_signataire_submit'))
      {
        $arrValsSublit = $request->getParameter('supprimer_signataire_submit');

        foreach ($arrValsSublit as $key => $value)
        {
          $idSessionSignataire = $key;
        }

        $objSessionSignataire = Session_contrat_signataireTable::getInstance()->findOneById($idSessionSignataire);

        try {
            $objSessionSignataire->delete();
          } catch (Exception $exc) {
            $this->getUser()->setFlash('erreur', 'msg_contrat_session_err');
            $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ Erreur effacement signataire de session; ");
          }
      } else
      {
        $hasError = false;

        $arrValeursSumbit = $request->getParameter($this->objFormContrat->getName());

        $this->getRequest()->offsetUnset($this->objFormContrat->getName());

        $arrValeursSumbit['dossier_bpi_id'] = $this->objContrat->getDossier_bpi()->getId();

        $this->getRequest()->setParameter($this->objFormContrat->getName(), $arrValeursSumbit);

        //On remplie la variable objForm utilise pour sauveguarder les objets
        $this->objForm = $this->objFormContrat;
        
        $this->objFormContrat->getConnection()->beginTransaction();
        
        //Si la suaveguard de la forme reussi..
        if ($this->processForm('modifier','',false))
        {
          //On efface les anciens signataires
          SignataireTable::getInstance()->getQueryObject()->where('contrat_id = ?',$this->objContrat->getId())->delete()->execute();

          $arrSignatairesSesion = Session_contrat_signataireTable::getInstance()->findByTransactionToken($strToken);

          //...on sauveguard les nouveaux signataires
          foreach ($arrSignatairesSesion as $objSignataireSession)
          {
            $objSignataire = new Signataire();

            $objSignataire->setContratId($this->objFormContrat->getObject()->getId());
            $objSignataire->setOrganismeId($objSignataireSession->getOrganisme()->getId());
            $objSignataire->setServiceId($objSignataireSession->getServiceId());

            try {
              $objSignataire->save();
            } catch (Exception $exc) {
              $hasError = true;
              $this->getUser()->setFlash('erreur', libelle('msg_contrat_signataire_err_save'));
              $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ Erreur sauveguarde signataires; ");
            }
          }
        } else
        {
          $hasError = true;
        }

        $this->objFormContrat->getConnection()->commit();

        if (!$hasError)
        {
          //Netoyage de la table de session apres l'action
          if (!Session_contrat_signataireTable::getInstance()->netoyerSessionParToken($strToken))
          {
            $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ Effacement des entrés avec token ".$strToken." de la table de session; ");
          }
          $this->getLogger()->debug("{".__CLASS__."} [".__FUNCTION__."] /Ligne: ".__LINE__."/ FIN AVANT REDIRECTION; ");

          $this->redirect(url_for('dossier_bpi/listerContrats?dossier_bpi_id='.$this->objContrat->getDossier_bpi()->getId()));
        }
      }

      $this->objFormContrat->bind($request->getParameter($this->objFormContrat->getName()));
      
      if ($request->hasParameter('ajouter_signataire_submit') || $request->hasParameter('supprimer_signataire_submit'))
      {
        $this->objFormContrat->resetErrorSchema();
      }
    }

    $this->arrSignataires = Session_contrat_signataireTable::getInstance()->findByTransactionToken($strToken);

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
